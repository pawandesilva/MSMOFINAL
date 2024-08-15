<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Employee Management";
$breadcrumb_item = "Employee Management";
$breadcrumb_item_active = "manage";
?>
<div class="tab-content" id="employee_manage">
   
    <div class="row">
        
        <div class="col-12">
            
            <div>
                <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Employee Leaves</p>
              </div>
              <div class="icon">
                <i class="fas fa-list-ul"></i>
              </div>
              <a href="show_emp_leaves.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
            </div>
            <a href="<?= SYS_URL?>employee/add_employee.php" class="btn btn-success mb-2"><i class="fas fa-plus-circle"></i>Add New Employee</a><!-- comment -->
            <form class="mt-3 " action="<?= htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <input type="date" name="from_date">
                <input type="date" name="to_date"><!-- comment -->
                <button class="rounded-3" type="submit" >search</button>
            </form>
            <div class="card">
            <div class="card-header">
                <h3 class="card-title"><strong>Employee Details</strong></h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <?php
                $where=null;
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    extract($_POST);
                    
                    //$where="WHERE item_stock.purchase_date BETWEEN '$from_date' AND '$to_date'";
                    
                }
                $db = dbConn();
                $sql = "SELECT `EmployeeID`, `FirstName`,`LastName`, `Email`, `TelNo`,`NIC`, `AppDate`, `Designation`, `Department`, `UserID` FROM `employee` e INNER JOIN designations d ON e.DesignationId=d.Id INNER JOIN departments dp ON e.DepartmentId=dp.Id ";
                $result=$db->query($sql);
                ?>
                
                <table class="table table-hover text-nowrap " id="myTable">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Email</th>
                            <th>Tel No</th>
                            <th>NIC</th>
                            <th>Department</th>
                            <th>Designation</th>
                            <th>User ID</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($result->num_rows > 0 ){
                            while($row = $result->fetch_assoc()){
                                ?>
                           
                        <tr>
                    <td><?= $row['EmployeeID']?></td>
                    <td><?= $row['FirstName']?></td>
                    <td><?= $row['Email']?></td>
                    <td><?= $row['TelNo']?></td>
                    <td><?= $row['NIC']?></td>
                    <td><?= $row['Department']?></td>
                    
                    <td><?= $row['Designation']?></td>
                    <td><?= $row['UserID']?></td>
                    
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <div id="pagination" class="d-flex justify-content-center"></div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php'; //lay out file in out 2 steps behind
?>
 

