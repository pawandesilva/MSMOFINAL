<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Order Management";
$breadcrumb_item = "Order Management";
$breadcrumb_item_active = "Approve purchasing order";
?>


<div class="row">
    <div class="col-12">  
        
        <div class="card">
            <div class="card-header  ">
                <h3 class="card-title font-weight-bold">Approve Purchasing Orders</h3>

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
                $sql= "SELECT purchasing_orders.OrderId, purchasing_orders.OrderName , suppliers.FirstName , purchasing_orders.DiliveryDate , purchasing_orders.DueDate  FROM msmo.purchasing_orders INNER JOIN msmo.suppliers ON purchasing_orders.SupplierId = suppliers.SupplierId ORDER BY purchasing_orders.DueDate" ;
                $result= $db->query($sql);
                
                ?>
                <table class="table table-hover text-nowrap table-head-fixed">
                    <thead>
                        <tr>
                            <th>Order Id</th>
                            <th>Order Name</th>
                            <th>Supplier</th>
                            <th>Delivery Date</th>
                            <th>Due Date</th>

                            
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($result->num_rows >0){
                            while($row= $result->fetch_assoc()){
                                ?>
                        <tr>
                            <td><?= $row['OrderId']?></td>
                            <td><?= $row['OrderName']?></td>
                            <td><?= $row['FirstName']?></td>
                            <td><?= $row['DiliveryDate']?></td>
                            <td><?= $row['DueDate']?></td>
                            
                            <td><a href="view_purchasing_orders.php" class="btn btn-info"><i class="fas fa-eye"></i>   view</a></td>
                            <td><a href="" class="btn btn-success"><i class="fas fa-check-circle"></i>   Approve</a></td>
                            <td><a href="" class="btn btn-danger"><i class="fas fa-times-circle"></i>   Reject</a></td>
                            
                            
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
<script>