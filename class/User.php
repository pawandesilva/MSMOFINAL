<?php
class User{
    
    protected $db;
    
    public function __construct(){
        $this->db= dbConn();
    }
    
    public function checkUserName($username){
        $sql = "SELECT * FROM users WHERE UserName = '$UserName'";
        $result = $this->$db->query($sql);
        ($result->num_rows > 0){
            return true;
    }else{
        return false;
    }
    }
}
?>
