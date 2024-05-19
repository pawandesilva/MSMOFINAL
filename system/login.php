<?php

session_start();
include '../functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Log in</title>
  <style>
      
    .bg-color {
      background-image: url('assets/dist/img/copy-space-glasses-with-flavored-fruit-juice-cinnamon.jpg'); /* Replace 'path/to/your/image.jpg' with the actual path to your image */
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
    }
    
    
    @keyframes slideIn {
      0% {
        transform: translateY(-100%);
        opacity: 0;
      }
      100% {
        transform: translateY(0);
        opacity: 1;
      }
    }
    
    .login-box {
      animation: slideIn 0.85s ease-in-out;
    }
  </style>
    

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <link href="assets/dist/css/mystyle.css" rel="stylesheet" type="text/css"/>
</head>
<body class="hold-transition login-page bg-color">
<div class="login-box offset-5 rounded-3  ">
  <div class="login-logo ">
      <img src="assets/dist/img/logo.jpg" class="img-fluid border-success border-1" width="150" alt=""/>
      
      <a href="../../index2.html"><b class="success">MSMO </b></a>
  </div>
  <!-- /.login-logo -->
  <?php
  if($_SERVER['REQUEST_METHOD']=='POST'){
      extract($_POST);
      
      $username = dataClean($username);
      $message = array();
      
      if(empty($username)){
          $message['username']= "User name should not be empty..!";
          
      }
      if(empty($password)){
          $message['password']="Password should not be empty..!";
          
      }
      if(empty($message)){
          $db= dbConn();
           $sql="SELECT * FROM users u INNER JOIN employee e  ON e.UserID=u.UserId WHERE u.UserName='$username'";
          $result=$db->query($sql);
          
          if($result->num_rows==1){
              $row=$result->fetch_assoc();
              if(password_verify($password, $row['Password'])){
                  $_SESSION['USERID']= $row['UserID'];
                  $_SESSION['FIRSTNAME']= $row['FirstName'];
                  $_SESSION['LASTNAME'] = $row['LastName'];
                  
                  header("Location:dashboard.php");
                  
              }else{
                  $message['password']="Invalid user name or  password..!";
                  
              }
          }else {
                  $message['password']="Invalid user name or password..! ";
          }
          
      } 
          
      }
  
  ?>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="input-group mb-3">
          <input type="text" class="form-control" name="username" id="username" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" name="password" id="password" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-success btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <div class="text-danger"><?= @$message['username'] ?></div>
      <div class="text-danger"><?= @$message['password']?></div>

      

      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>
