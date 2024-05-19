<?php
session_start();

session_destroy();
//redirrect to the login form
header("Location:login.php");
?>
