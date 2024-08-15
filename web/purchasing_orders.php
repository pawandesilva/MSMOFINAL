<?php
ob_start();
include 'supplier_layout.php';
include '../functions.php';
include '../config.php';
?>
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="text-center mx-auto mt-5" style="max-width: 700px; color: #935116">
                        <h1 class="text-center  " style="color: #935116">Purchasing Orders</h1>
                        <hr class="col-6 offset-md-3 mb-4 ">
                    </div>
                <div class="card container-fluid" style="background-color: #D0E7D2">
                <div class="col-12 container-fluid">
                    
                    
                    <table class="table fixed table-responsive-lg   mt-5 table-hover caption-top   ">
                        <?php
                        extract($_GET);
                        extract($_POST);
                        $userId=$_SESSION['USERID'];
                        $db = dbConn();
                        $sql= "SELECT * FROM suppliers   WHERE UserId='$userId' ";
                        $result=$db->query($sql);
                        $row=$result->fetch_assoc();
                        $supplierId=$row['SupplierId'];
                        $sql="SELECT * FROM purchasing_orders WHERE SupplierId='$supplierId'";
                        $result=$db->query($sql);
                        
                        
                        ?>
                        
                        <thead class="">
                            
                            <tr>
                                <th scope="col">Order ID</th>
                                <th scope="col">Order Name</th>
                                <th scope="col">Order Delivery Date</th>
                                <th scope="col">Order Due Date</th>
                                
                                <th scope="col">View</th>
                                
                            </tr>
                        </thead>
                        <tbody >
                            <?php
                            if($result->num_rows> 0){
                                while ($row=$result-> fetch_assoc()){
                                    ?>
                            <tr>
                                <td><?=$row['OrderId']?></td>
                                <td><?=$row['OrderName']?></td>
                                <td><?=$row['DiliveryDate']?></td>
                                <td><?=$row['DueDate']?></td>
                                
                                <td><a href="<?= SYS_URL ?>order_management/checked_purchasing_order.php?orderid=<?= $row['OrderId']?>"  class="btn btn-info"><i class="fas fa-eye"></i>   view</a></td>
                            </tr>
                            <?php
                                }
                            }
                            ?>
                            
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




