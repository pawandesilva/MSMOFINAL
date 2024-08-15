<?php
include 'supplier_layout.php';
include '../functions.php';

?>
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">


                    
                    <div class="position-relative">
                        <img src="assets/img/supplier_dashboard.jpeg" alt="" class="img-fluid w-100">
                        
                        <!-- Buttons on top of the image -->
                        <div class="row">
                        <div class="position-absolute col-5" style="top: 20%; left: 10%;">
                            <a href="purchasing_orders.php" class="btn btn-info btn-lg m-3 border-1" style="width: 200px;">
                                <i class="fas fa-solid fa-arrow-down"></i><br><strong>NEW<br>Purchasing Orders</strong>
                            </a>
                        </div>
                        <div class="position-absolute col-4" style="top: 20%; left: 30%;">
                            <a href="supplier_create_order.php" class="btn btn-warning btn-lg m-3" style="width: 200px;">
                                <i class="fas fa-solid fa-list-ul"></i><br><strong>Create Order</strong>
                            </a>
                        </div>
                        </div>
                    </div>
                    



                </div>
            </div>
        </div>
    </div>
</div>
