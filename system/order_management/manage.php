<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Order Management";
$breadcrumb_item = "Order Management";
$breadcrumb_item_active = "manage";
?>

<div class="row">
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <h2 class="text-center "><strong>Purchase Orders</strong></h2>
                <div class="text-center ">
                    <a href="managePO.php">
                        <button type="button" class="btn border border-1 border-dark btn-warning w-100 "><strong>Manage</strong></button>
                    </a>
                </div>
                <img class="card-img mb-3 mt-auto" src="../assets/dist/img/credit/purchaseorder.png" alt="Purchase Orders"/>
                
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-3">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <h2 class="text-center "><strong>Product Orders</strong></h2>
                <div class="text-center ">
                    <a href="Manage_O.php">
                        <button type="button" class="btn border border-1 border-dark btn-info w-100 "><strong>Manage</strong></button>
                    </a>
                </div>
                <img class="card-img img-content-fluid mb-3" src="../assets/dist/img/credit/20943858.jpg" alt="Product Orders"/>
                
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include '../layouts.php'; //lay out file in out 2 steps behind
?>