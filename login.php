<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <link rel="icon" href="images/logo.jpg">
  <title>Educational Management Information System</title>
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="asset/css/style.css" rel="stylesheet">
  <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
  <link href="assets/css/sticky-footer-navbar.css" rel="stylesheet">
  <link href="asset/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <script src="assets/js/ie-emulation-modes-warning.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jquery.js"></script>
  <style>
    body {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-color: #f5f5f5;
    }

    .login-form {
      border: 5px solid grey;
      border-radius: 20px;
      padding: 30px;
      width: 500px;
      background-color: white;
    }

    .login-form h3 {

      color: black;
      border-radius: 5px;
      padding: 10px 0;
      margin-bottom: 20px;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="login-form" id="login_modal" role="dialog">
      <h3><b>Please Login</b></h3>
      <form class="form-horizontal" method="post">
        <div class="form-group">
          <label class="control-label col-sm-2" for="user">User:</label>
          <div class="col-md-10">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
              <input type="text" class="form-control" id="user" name="user" placeholder="Enter User" autocomplete="off">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-2" for="pwd">Password:</label>
          <div class="col-md-10">
            <div class="input-group">
              <span class="input-group-addon"><i class="fa fa-key fa" aria-hidden="true"></i></span>
              <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter password">
            </div>
          </div>
        </div>
        <div class="form-group">
          <div class="col-md-offset-9 col-md-12">
            <button type="hidden" class="btn btn-default">Login</button>
          </div>
        </div>
      </form>
      <?php
      include 'connect.php';
      ?>
    </div>
  </div>
  <script src="assets/js/jquery.min.js"></script>
  <script>
    window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')
  </script>
  <script src="js/bootstrap.min.js"></script>
  <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
</body>

</html>