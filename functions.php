<?php

//create database connection

function dbConn() {
    $server = "localhost";
    $username = "root";
    $password = "";
    $db = "msmo";

    $conn = new mysqli($server, $username, $password, $db);

    if ($conn->connect_error) {
        die("Database Error :" . $conn->connect_error);
    } else {

        return $conn;
    }
}

//End Database connection
//Data clean function---------------------------------
function dataClean($data = null) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

//End data clean--------------------------------------
//function to check permission------------------

function checkPermission($current_url = null, $userid = null){//get current url dynamically 
    $parsed_url = parse_url($current_url);//parse the url
    $path = $parsed_url['path'];//extract the path component 
    $file_name = basename($path, '.php');//get file name without extention
    $folder_name = basename(dirname($path));//get folder name

    $db = dbConn();
    $sql = "SELECT * FROM `user_modules` um "
            . "INNER JOIN modules m ON m.Id=um.ModuleId"
            . " WHERE um.UserID='$userid' AND m.Path = '$folder_name' AND m.File='$file_name';";
    $result = $db->query($sql);
    
    if($result->num_rows<=0){
        return false;
        
    }else{
        return true;
    }
       
}

?>