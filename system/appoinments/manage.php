<?php
ob_start();

session_start();
include_once '../init.php';

$link = "Appoinments";//browser left side text
$breadcrumb_item = "Appoinments";
$breadcrumb_item_active = "Manage";

?>
<div class="row">
    <div class="col-12">  
        <a href="<?= SYS_URL ?>appoinments/qr_scan.php" class="btn btn-success mb-2"><i class="fas fa-qrcode mr-2"></i>  QR Scan</a>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Appointment Details</h3>

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
                $db= dbConn();
                $sql= "SELECT appoinments.id , customers.FirstName , customers.LastName , customers.Email , customers.MobileNo , appoinments.date , appoinments.startTime , appoinments.endTime FROM msmo.appoinments INNER JOIN msmo.customers ON appoinments.CustomerId = customers.CustomerId";
                $result= $db->query($sql);
                
                ?>
                <table class="table table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Mobile No</th>
                            <th>App.Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($result->num_rows >0){
                            while($row= $result->fetch_assoc()){
                                ?>
                        <tr>
                            <td><?= $row['FirstName']?></td>
                            <td><?= $row['LastName']?></td>
                            <td><?= $row['Email']?></td>
                            <td><?= $row['MobileNo']?></td>
                            <td><?= $row['date']?></td>
                            <td><?= $row['startTime']?></td>
                            <td><?= $row['endTime']?></td>
                            <td><a href="<?= SYS_URL ?>appoinments/issue_job_card.php?appointment_id=<?= $row['id'] ?>" class="btn btn-warning"><i class="fas fa-calendar"></i> Issue Job Card</a></td>
                            
                            
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
            <!--card body-->
        </div>
        <!--card-->
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>