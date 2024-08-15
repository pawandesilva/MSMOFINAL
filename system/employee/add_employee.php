<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Employee Management";
$breadcrumb_item = "Employee";
$breadcrumb_item_active = "Add";

// Initialize the message array

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    extract($_POST);

    // Data Clean-----------------------
    $FirstName = dataClean($FirstName);
    $LastName = dataClean($LastName);
    $DesignationId = dataClean($DesignationId);
    $DepartmentId = dataClean($DepartmentId);
    $AppDate = dataClean($AppDate);
    $address_line1 = dataClean($address_line1);
    $address_line2 = dataClean($address_line2);
    $address_line3 = dataClean($address_line3);

    $message = array(); // Initialize the message array
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
    
    

    // Check User name already exists
    if (empty($message)) { // Proceed only if there are no validation errors
        $db = dbConn();
        $sql = "SELECT * FROM users WHERE UserName = '$UserName'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            $message['UserName'] = "This User Name already exists..!";
        } else {
            // Insert user data if no errors
            $pw = password_hash($Password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (FirstName, LastName, UserName, Password, UserType, Status)
                    VALUES ('$FirstName', '$LastName', '$UserName', '$pw', 'employee', '1')";
            $db->query($sql);

            // Get last inserted user ID and insert employee data
            $UserId = $db->insert_id;
            $sql = "INSERT INTO employee (AppDate, DesignationId, DepartmentId, UserID)
                    VALUES ('$AppDate', '$DesignationId', '$DepartmentId', '$UserId')";
            $db->query($sql);

            header("Location: manage.php");
        }
    }
}
?>

<div class="row">
    <div class="col-12">
        <a href="" class="btn btn-success mb-2"><i class="fas fa-plus-circle"></i> New</a>
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Add New Employee</h3>
            </div>
            <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputFirstName">First Name</label>
                        <input type="text" class="form-control" id="FirstName" name="FirstName" placeholder="Enter First Name">
                        <span class="text-danger"><?= @$message['FirstName'] ?> </span>
                    </div>

                    <div class="form-group">
                        <label for="inputLastName">Last Name</label>
                        <input type="text" class="form-control" id="LastName" name="LastName" placeholder="Enter Last Name">
                        <span class="text-danger"><?= @$message['LastName'] ?></span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="email">Email</label>
                        <input type="text" class="form-control border " name="email" id="email" placeholder="Email" required>
                        <span class="text-danger"><?= @$message['email'] ?></span>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-4 mt-3">
                            <label for="address_line1">Address Line 1</label>
                            <input type="text" class="form-control border " name="address_line1" id="address_line1" placeholder="Address Line 1" required>
                        </div>
                        <div class="form-group col-md-4 mt-3">
                            <label for="address_line2">Address Line 2</label>
                            <input type="text" class="form-control border " name="address_line2" id="address_line2" placeholder="Address Line 2" required>
                        </div>
                        <div class="form-group col-md-4 mt-3">
                            <label for="address_line3">Address Line 3</label>
                            <input type="text" class="form-control border " name="address_line3" id="address_line3" placeholder="Address Line 3" required>
                        </div>
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

                    <div class="form-group mt-3">
                        <label for="telno">TelNo</label>
                        <input type="text" class="form-control border " name="telno" id="telno" placeholder="Tel. No." required>
                    </div>


                </div>
                <div class="card-footer">
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