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

// Single image & file upload
function uploadFile($file, $location) {
    $message = array();
    // ['name'] is an attribute of the array(more example: name,full_path,tmp_name,size,error,type..)
    $file_name = $file['name'];
    $file_tmp = $file['tmp_name'];
    $file_size = $file['size'];
    $file_error = $file['error'];
    // Work out the file extension
    $file_ext = explode('.', $file_name);
    $file_ext = strtolower(end($file_ext));
    $allowed_ext = array('png', 'jpg', 'gif', 'jpeg', 'pdf');
    if (in_array($file_ext, $allowed_ext)) { // check if the uploaded image extension is within the allowed extensions
        if ($file_error === 0) {
            if ($file_size <= 5097152) {
                $file_name = uniqid('', true) . '.' . $file_ext; //create new unique file name
                $file_destination = $location . '/' . $file_name; //file destination
                move_uploaded_file($file_tmp, $file_destination); //moves the file from the temp location to the new destination
                $message['upload'] = true;
                $message['file'] = $file_name;
            } else { //validation if exeeds the maximum file size
                $message['upload'] = false;
                $message['error_file'] = "The file size is invalid for $file_name";
            }
        } else { //validation if file has error/corrupted
            $message['upload'] = false;
            $message['error_file'] = "Error occurred while uploading $file_name";
        }
    } else { //validation if wrong file type
        $message['upload'] = false;
        $message['error_file'] = "Invalid file type selected!";
    }

    return $message;
}

/*function uploadFiles($files){
    $messages = array();//store the result messages for each file upload.
    foreach($files['name'] as $key => $filename){//$key is the index of the file
        $filetmp =$files['tmp_name'][$key];//temporary file path
        $filesize = $files['size'][$key];//size of the file
        $fileerror = $files['error'][$key];// Error code associated with the file uploading
        
        //extract file extention and convert to lower case
        $file_ext = explode('.',$filename);//explode convert to array
        $file_ext = strtolower(end($file_ext));
        
        //define allowed file extentions
        
        $allowed_ext = array('pdf','png','jpg','gif','jpeg');
        
        if(in_array($file_ext, $allowed_ext)){//check the file ext. is in the allowed extention
            if($fileerror==0){//check no errors
               if($filesize <= 5242880){//check max size is 5mb
                   //generate unique name and move the file to uplaod directory
                   $filename= uniqid('',true ). '.' . $file_ext;
                   $file_destination = '../uploads/' . $filename;
                   move_uploaded_file($filetmp,$file_destination);//take file from temp location and move
                   
                   $messages[$key]['upload']=true;
                   $messages[$key]['file']=$filename;//if file upload success,store success message alog with new file name
                  
               } else{
                   $messages[$key]['upload']= false;
                   $messages[$key]['size']="The file size is invalid for $filename";
               }
               } else {
                   $messages[$key]['upload']=false;
                   $messages[$key]['uplaoding']="Error occured while uploading $filename";//error in uploading message
               }   
               }else{
                   $messages[$key]['upload']=false;
                   $messages[$key]['type']="Invalid file type for $filename";//file type is not allowed stores error message
               }
                
            }
            return $messages;//send result
        }*/
function checkRole($role=null){
    session_start();
    $user_id=$_SESSION['USERID'];//take login user id
    $sql="SELECT * FROM users u WHERE u.UserId='$user_id' AND u.UserRole='$role'";
    $result= $db->query($sql);
    
    if($result->num_rows<= 0 ){
        header("Location: unauthorized.php");
        return false;
    }else{
        return true;
        
    }
    
    
    
}
    


?>