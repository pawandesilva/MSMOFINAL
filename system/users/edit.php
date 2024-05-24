<?php
ob_start();
session_start();
include_once '../init.php';

$link = "User Management";
$breadcrumb_item = "User";
$breadcrumb_item_active = "Update";

if($_SERVER['REQUEST_METHOD']=='GET'){
    extract($_GET);
    $db = dbConn();
    $sql = "SELECT * FROM users u INNER JOIN employee e ON e.UserID=u.UserId WHERE u.UserId='$userid'";
    $result=$db->query($sql);
    $row=$result->fetch_assoc();
    
    $FirstName = $row['FirstName'];
    $LastName = $row['LastName'];
    $DesignationId = $row['DesignationId'];
    $DepartmentId =$row['DepartmentId'];
    $AppDate = $row['AppDate'];
    $UserId=$row['UserID'];
}

 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);

    // Data Clean-----------------------
    $FirstName = dataClean($FirstName);
    $LastName = dataClean($LastName);
    $DesignationId = dataClean($DesignationId);
    $DepartmentId = dataClean($DepartmentId);
    $AppDate = dataClean($AppDate);
    
     
    $message = array();// Initialize the message array
    // Required validations------------------------
    if (empty($FirstName)) {
        $message['FirstName'] = "The First Name should not be empty..!";
    }
    if (empty($LastName)) {
        $message['LastName'] = "The Last Name should not be empty..!";
    }
    if (empty($DesignationId)) {
        $message['DesignationId'] = "The Designation should not be blank..!";
    }
    if (empty($AppDate)) {
        $message['AppDate'] = "The App Date should not be empty..!";
    }
    
    

    if(empty($message)){
            $db = dbConn();
            //update statement
            $sql = "UPDATE users SET  FirstName='$FirstName', LastName='$LastName' WHERE UserId='$UserId'";
                    
            $db->query($sql);

           
            $sql = "UPDATE employee SET
                    AppDate='$AppDate', DesignationId='$DesignationId', DepartmentId='$DepartmentId' WHERE UserID='$Userid';";
                 
            $db->query($sql);

            header("Location: manage.php");
        }
    }

?>

<div class="row">
    <div class="col-12">
        <a href="" class="btn btn-success mb-2"><i class="fas fa-plus-circle"></i> New</a>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit User</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputFirstName">First Name</label>
                        <input type="text" class="form-control" id="FirstName" name="FirstName" placeholder="Enter First Name" value="<?= @$FirstName ?>">
                        <span class="text-danger"><?= @$message['FirstName'] ?> </span>
                    </div>

                    <div class="form-group">
                        <label for="inputLastName">Last Name</label>
                        <input type="text" class="form-control" id="LastName" name="LastName" placeholder="Enter Last Name" value="<?= @$LastName ?>">
                        <span class="text-danger"><?= @$message['LastName'] ?></span>
                    </div>

                    <div class="form-group">
                        <label for="DesignationId">Designation</label>
                        <?php
                        $db = dbConn();
                        $sql = "SELECT * FROM Designations";
                        $result = $db->query($sql);
                        ?>
                        <select class="form-control" id="DesignationId" name="DesignationId">
                            <option value="">--</option>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <option value="<?= $row['Id'] ?>"><?= $row['Designation'] ?> </option>
                            <?php } ?>
                        </select>
                        <span class="text-danger"><?= @$message['DesignationId'] ?></span>
                    </div>

                    <div class="form-group">
                        <label for="DepartmentId">Department</label>
                        <?php
                        $sql = "SELECT * FROM departments";
                        $result = $db->query($sql);
                        ?>
                        <select class="form-control" id="DepartmentId" name="DepartmentId">
                            <option value="">--</option>
                            <?php while ($row = $result->fetch_assoc()) { ?>
                                <option value="<?= $row['Id'] ?>"><?= $row['Department'] ?></option>
                            <?php } ?>
                        </select>
                        <span class="text-danger"><?= @$message['DepartmentId'] ?></span>
                    </div>

                    <div class="form-group">
                        <label for="AppDate">Application Date</label>
                        <input type="date" class="form-control" id="AppDate" name="AppDate">
                        <span class="text-danger"><?= @$message['AppDate'] ?></span>
                    </div>

                    
                </div>
                <div class="card-footer">
                    <input type='hidden' name='UserId' value="<?=$UserId?>">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../layouts.php';
?>
