<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Employee Management";
$breadcrumb_item = "Employee";
$breadcrumb_item_active = "requests";
?>
<div class="tab-content" id="leave_request">
    <!-- Create leave request Tab -->
    <div class="row">
        <div class="col-12">

            <a href="" class="btn btn-success mb-2"><i class="fas fa-plus-circle"></i> New</a>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Leave Request</h3>
                </div>
                <div class="tab-pane fade show active" id="leave_request" role="tabpanel" aria-labelledby="leave-request-tab">
                    <div class="card-body">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            extract($_POST);

                            $item_id = dataClean($item_id);

                            $unit_price = dataClean($unit_price);
                            //$purchase_date = dataClean($purchase_date);


                            $message = array();
                            //required validation----------------------------

                            if (empty($item_id)) {
                                $message['item_id'] = "The item name should not be empty..!";
                            }
                            if (empty($qty)) {
                                $message['qty'] = "The qty should not be empty..!";
                            }
                            if (empty($unit_price)) {
                                $message['unit_price'] = "The unit price should not be empty..!";
                            }
                            if (empty($purchase_date)) {
                                $message['purchase_date'] = "The purchase date should not be empty..!";
                            }
                            if (empty($supplier_id)) {
                                $message['supplier_id'] = "The Supplier name should not be empty..!";
                            }
                            if (empty($message)) {
                                $db = dbConn();
                                echo $sql = "INSERT INTO item_stock (item_id,qty,unit_price,supplier_id,purchase_date,UnitId) VALUES ($item_id,$qty,$unit_price,$supplier_id,$purchase_date,$unit);";
                                $db->query($sql);
                                header("Location:manage.php");
                            }
                        }
                        ?>

                        <form  action="" method="post" role="form" novalidate>
                            <div class="form-group">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM employee";
                                $result = $db->query($sql);
                                ?>
                                <label for="employee">Employee Name</label><br><!-- comment -->
                                <select name="employee_id" id="employee_id" class=" col-12 height-control form-control-lg ">
                                    <option value=" ">--</option>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row['EmployeeID'] ?>"<?= @$employee_id == $row['EmployeeID'] ? 'selected' : '' ?>><?= $row['FirstName'] ?> <?= $row['LastName'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?= @$message['supplier_id'] ?></span>

                            </div>
                            <div class="form-group">
                                <label for="FromDate">From-Date</label>
                                <input type="date" class="form-control col-3" name="from_date" id="from_date" required value="<?= @$from_date ?>">
                                <span class="text-danger"><?= @$message['from_date'] ?></span>
                            </div> 
                            <div class="form-group">
                                <label for="ToDate">To-Date</label>
                                <input type="date" class="form-control col-3" name="to_date" id="to_date" required value="<?= @$to_date ?>">
                                <span class="text-danger"><?= @$message['to_date'] ?></span>
                            </div> 
                            <div class="form-group">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM leave_types";
                                $result = $db->query($sql);
                                ?>
                                <label for="item_name" >Leave Type</label>
                                <select name="ltype_id" id="ltype_id" class="col-12 height-control form-control-lg">
                                    <option value=" ">--</option>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value="<?= $row['LeaveTypeId'] ?>"<?= @$item_id == $row['LeaveTypeId'] ? 'selected' : '' ?>><?= $row['LeaveType'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?= @$message['item_id'] ?></span>
                            </div>
                            <input type="submit" value="submit" class="btn btn-primary" >


                        </form>
                    </div>

                </div>    
            </div>   
        </div> 
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>
