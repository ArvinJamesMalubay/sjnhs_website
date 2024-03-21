<?php
session_start(); // Start or resume session

include 'db.php'; // Include your database connection file

// Retrieve form data
$id = $_POST['id'];
$school = $_POST['school'];
$yr = $_POST['yr'];
$sec = $_POST['sec'];
$tny = $_POST['tny'];
$sy = $_POST['sy'];
$au = $_POST['au'];
$lu = $_POST['lu'];
$adv = $_POST['adviser'];
$tbca = $_POST['class'];
$rank = $_POST['rank'];
$subject = $_POST['subj'];
$una = $_POST['1st'];
$ikaduwa = $_POST['2nd'];
$ikatlo = $_POST['3rd'];
$ikaapat = $_POST['4th'];
$u = $_POST['units'];
$f = $_POST['final'];
$a = $_POST['action'];
$month = $_POST['month'];
$dc = $_POST['dc'];
$p = $_POST['p'];
$Tdc = $_POST['Tdc'];
$Tp = $_POST['Tp'];
$user = $_SESSION['ID'];

// Check if the student year record already exists
$search_qry = mysqli_query($conn, "SELECT * FROM student_year_info 
    LEFT JOIN student_info ON student_year_info.STUDENT_ID = student_info.STUDENT_ID 
    WHERE student_year_info.STUDENT_ID = '$id' AND student_year_info.YEAR = '$yr' ");
$num_rows = mysqli_num_rows($search_qry);

if ($num_rows >= 1) {
	echo "<script>
            alert('Student Year Record already exists!');
            window.location.replace(document.referrer);
          </script>";
} else {
	// Insert student year info into database
	$insert_sql = "INSERT INTO student_year_info (STUDENT_ID, SCHOOL, YEAR, SECTION, TOTAL_NO_OF_YEAR, SCHOOL_YEAR, ADVANCE_UNIT, LACK_UNIT, ADVISER, RANK, TO_BE_CLASSIFIED, TDAYS_OF_CLASSES, TDAYS_PRESENT, ACTION)
                   VALUES ('$id', '$school', '$yr', '$sec', '$tny', '$sy', '$au', '$lu', '$adv', '$rank', '$tbca', '$Tdc', '$Tp', 'Promoted')";
	$insert_result = mysqli_query($conn, $insert_sql);

	if ($insert_result) {
		$last_id = mysqli_insert_id($conn);

		// Log the transaction
		mysqli_query($conn, "INSERT INTO history_log (transaction, user_id, date_added) 
                             VALUES ('added record of $id', '$user', NOW())");

		// Insert subjects and grades
		$subjects_count = count($subject);
		for ($i = 0; $i < $subjects_count; $i++) {
			if ($subject[$i] != '') {
				$subject_sql = "INSERT INTO total_grades_subjects (STUDENT_ID, SYI_ID, SUBJECT, 1ST_GRADING, 2ND_GRADING, 3RD_GRADING, 4TH_GRADING, UNITS, FINAL_GRADES, PASSED_FAILED)
                                VALUES ('$id', '$last_id', '$subject[$i]', '$una[$i]', '$ikaduwa[$i]', '$ikatlo[$i]', '$ikaapat[$i]', '$u[$i]', '$f[$i]', '$a[$i]')";
				mysqli_query($conn, $subject_sql);
			}
		}

		// Insert attendance records
		$months_count = count($month);
		for ($j = 0; $j < $months_count; $j++) {
			$attendance_sql = "INSERT INTO attendance (STUDENT_ID, SYI_ID, MONTH, DAYS_OF_CLASSES, DAYS_PRESENT)
                               VALUES ('$id', '$last_id', '$month[$j]', '$dc[$j]', '$p[$j]')";
			mysqli_query($conn, $attendance_sql);
		}

		// Calculate general average and update student year info
		$query = "SELECT COUNT(TGS_ID) AS tg_count, SUM(FINAL_GRADES) AS fin_grade FROM total_grades_subjects WHERE SYI_ID = '$last_id'";
		$query_result = mysqli_query($conn, $query);
		$row = mysqli_fetch_assoc($query_result);
		$gen_ave = $row['fin_grade'] / $row['tg_count'];
		mysqli_query($conn, "UPDATE student_year_info SET GEN_AVE = '$gen_ave' WHERE SYI_ID = '$last_id'");

		// Check failed subjects and update action accordingly
		$failed_query = "SELECT * FROM total_grades_subjects WHERE SYI_ID = '$last_id' AND PASSED_FAILED = 'FAILED'";
		$failed_result = mysqli_query($conn, $failed_query);
		$failed_count = mysqli_num_rows($failed_result);

		$grade_query = mysqli_query($conn, "SELECT * FROM grade WHERE grade_id = '$yr'");
		$grade_row = mysqli_fetch_assoc($grade_query);
		$tbca2 = $grade_row['grade'];

		if ($failed_count > 2) {
			mysqli_query($conn, "UPDATE student_year_info SET ACTION = 'Retained', TO_BE_CLASSIFIED = '$tbca2' WHERE SYI_ID = '$last_id'");
		} else {
			mysqli_query($conn, "UPDATE student_year_info SET ACTION = 'Conditional(Promoted)', TO_BE_CLASSIFIED = '$tbca2' WHERE SYI_ID = '$last_id'");
		}

		// Redirect to a specific page
		header('Location: rms.php?page=record&id=' . $id);
		exit(); // Terminate the script after redirection
	} else {
		die('Error executing query: ' . mysqli_error($conn));
	}
}

mysqli_close($conn);
