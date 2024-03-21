<?php
include 'db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$user = $_SESSION['ID'];


$id = $_GET['id'];

$query = mysqli_query($conn, "SELECT * FROM student_info where STUDENT_ID = '$id' ");
$row = mysqli_fetch_assoc($query);
$student = $row['FIRSTNAME'] . ' ' . $row['LASTNAME'];

mysqli_query($conn, "INSERT into history_log (transaction,user_id,date_added) 
		VALUES ('printed $student permanent record','$user',NOW() )");



?>

<head>
    <link rel="icon" href="images/logo.jpg">

    <title>Student Grading System</title>

    <!-- Bootstrap Core CSS -->
    <link href="asset/css/bootstrap.min.css" rel="stylesheet">
    <link href="asset/css/styles.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="asset/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="asset/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="asset/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <script src="datatables/jquery.dataTables.js"></script>
    <script src="datatables/dataTables.bootstrap.js"></script>
    <link href="datatables/dataTables.bootstrap.css" rel="stylesheet">

    <script src="assets/js/jquery.min.js"></script>
    <script src="asset/js/bootstrap.min.js" type="text/javascript"></script>

    <script src="assets/js/ie-emulation-modes-warning.js"></script>
    <script src="assets/js/jq.js"></script>
    <style>
        @media print {
            @page {
                size: 8.5in 13in;
            }

            head {
                height: 0px;
                display: none;
            }

            #head {
                display: none;
                height: 0px;
            }

            #print {
                position: fixed;
                top: 0px;
                margin-top: 20px;
                margin-bottom: 30px;
                margin-right: 50px;
                margin-left: 50px;
            }
        }

        #print {
            width: 7.5in;
        }

        input {
            border: 0;
            outline: 0;
            background: transparent;
            border-bottom: 1px solid black;
        }

        .foo {
            font-family: "Bodoni MT", Didot, "Didot LT STD", "Hoefler Text", Garamond, "Times New Roman", serif;
            font-size: 24px;
            font-style: italic;
            font-variant: normal;
            font-weight: bold;
            line-height: 24px;
        }

        .p {
            font-family: "Segoe UI", Frutiger, "Frutiger Linotype", "Dejavu Sans", "Helvetica Neue", Arial, sans-serif;
            font-size: 14px;
            font-style: italic;
            font-variant: normal;
            font-weight: 550;
            line-height: 20px;
            letter-spacing: 2px;
        }
    </style>

</head>



<body style="background-color:white">
    <span id='returncode'></span>
    <div class="col-md-2" id="head">
        <button class="btn btn-info" onclick="print()"><i class="glyphicon glyphicon-print"></i>PRINT</button>
        <a class="btn btn-info" onclick="window.close()">Cancel</a>

    </div>
    <center>
        <div id='print'>
            <div style="margin-left:.3in;margin-right:.5in;margin-top:.2in;margin-bottom:.1in;line-height:1mm;">


            </div>
            <div class="row">
                <div class="col-md-12">
                    <center>
                        <p><b>
                                <img src="images/DepEd.png" alt="DepEd Logo" style="position: absolute; top: -8px; right: 50px; width: 95px; ">
                                <img src="images/image.png" alt="DepEd Logo" style="position: absolute; top: 10px; left: 1px; width: 85px;">

                                <p>Republic of the Philippines
                                    <br> Department of Education
                                </p>
                                <h4>Learner's Permanent Academic Record for Junior High School
                                    <br>(SF10-JHS)
                                </h4>
                            </b></p>
                    </center>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <table style="line-height:5mm">
                        <?php
                        include 'db.php';
                        $id = $_GET['id'];
                        $sql = mysqli_query($conn, "SELECT * from student_info where STUDENT_ID = '$id'");
                        while ($row = mysqli_fetch_assoc($sql)) {
                            $mid = $row['MIDDLENAME'];
                        ?>
                            <tr>
                                <td style="width:800px;font-size:12px">
                                    <label for="">Last Name:&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                                    <b style="font-size:13px;text-transform: uppercase;"><?php echo $row['LASTNAME'] . ", " .  $row['FIRSTNAME'] . " " .  substr("$mid", 0, 1) . "."; ?></b>
                                    <br>
                                    <label for="">Place of Birth:&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                                    <h style="font-size:12px"><?php echo $row['BIRTH_PLACE'] ?></h>


                                </td>
                                <td style="width:800px;font-size:12px">
                                    <label for="">Date of Birth:&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                                    <h style="font-size:12px"><?php echo date("F d,Y") ?></h>
                                    <br>
                                    <label for="">Town / City:&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                                    <h style="font-size:12px"><?php echo $row['ADDRESS'] ?></h>
                                </td>

                            </tr>


                    </table>
                    <table>
                        <tr>
                            <td style="width:1000px;font-size:12px;text-align:left">

                                <label for="">Parent or Guardian:&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                                <h style="font-size:12px;text-transform: capitalize"><?php echo $row['PARENT_GUARDIAN'] ?></h>
                            </td>
                            <td style="width:600px;font-size:12px;text-align:left">


                            </td>
                        </tr>

                    </table>
                    <table>

                        <tr>
                            <td style="width:1000px;font-size:12px;text-align:left">


                                <label for="">Address of Parent or Guardian:&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                                <h style="font-size:12px;text-transform: capitalize"><?php echo $row['P_ADDRESS'] ?></h>

                            </td>
                        </tr>

                    </table>
                    <table>
                        <tr>

                            <td style="width:800px;font-size:12px">


                                <label for="">Intermediate Course Completed at:&nbsp</label>
                                <h style="text-transform: capitalize"><?php echo $row['INT_COURSE_COMP'] ?></h>

                            </td>
                            <td style="width:200px;font-size:12px">
                                <label for="">Year:&nbsp&nbsp&nbsp&nbsp&nbsp</label>
                                <h style="text-transform: capitalize"><?php echo $row['SCHOOL_YEAR'] ?></h>
                            </td>
                            <td style="width:200px;font-size:12px">
                                <label for="">Ave:&nbsp</label>
                                <h style="text-transform: capitalize"><?php echo $row['GEN_AVE'] ?></h>
                            </td>


                        </tr>
                    </table>
                <?php } ?>
                </div>

</body>
<script>
    function printContent(el) {
        var restorepage = document.body.innerHTML;
        var printcontent = document.getElementById(el).innerHTML;
        document.body.innerHTML = printcontent;
        window.print();
        document.body.innerHTML = restorepage;

        $.ajax({
            url: 'print_log.php?act=form137&id=<?php echo $_GET['id'] ?>',
            success: function(html) {
                $('#returncode').html(html);
            }
        });
    }
</script>