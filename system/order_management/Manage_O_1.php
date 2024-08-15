<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Order Management";
$breadcrumb_item = "Order Management";
$breadcrumb_item_active = "manage_Orders";
?>

<div class="row">
    <div class="col-12">  
        
        <div class="card">
            <div class="card-header  ">
                <h3 class="card-title font-weight-bold">Display Product Orders</h3>

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
                $sql= "SELECT `id`,`order_number`, `FirstName`,`LastName`, `order_date` FROM `orders` INNER JOIN customers ON orders.customer_id=customers.CustomerId " ;
                $result= $db->query($sql);
                
                
                ?>
                <table class="table table-hover text-nowrap table-head-fixed">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Order Number</th>
                            <th>Customer Name</th>
                            <th>Order Date</th>
                            <th>Status</th>
                            
                            <th>View Details</th>
                            

                            
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($result->num_rows >0){
                            while($row= $result->fetch_assoc()){
                                ?>
                        <tr>
                            <td><?= $row['id']?></td>
                            <td><?= $row['order_number']?></td>
                            <td><?= $row['FirstName']?> <?= $row['LastName']?> </td> 
                            <td><?= $row['order_date']?></td>
                            <td></td>
                           
                                <td><a href="<?= SYS_URL ?>order_management/view_order_details.php?order_id=<?= $row['id']?>" class="btn btn-info"><i class="fas fa-eye"></i>   view</a></td>
                            
                            
                            
                            
                            
                            
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
include '../layouts.php'; //lay out file in out 2 steps behind
?>
