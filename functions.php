<?php
//create database connection
function dbConn(){
    $server = "localhost";
    $username ="root";
    $password = "";
    $db = "msmo";
    
    $conn = new mysqli($server,$username,$password,$db);
    
    if ($conn->connect_error){
        die("Database Error :" . $conn->connect_error);
        
    }else{
       
        return $conn;
    }
}

//End Database connection

//Data clean function---------------------------------
function dataClean($data = null){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    
    return $data;
}
//End data clean--------------------------------------

?>