<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Order Management";
$breadcrumb_item = "Order Management";
$breadcrumb_item_active = "manage";
?>


<div class="row col-md-8">
    <div class="col-sm-4 mb-3 mb-sm-1">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title  card-title-large">Purchsing Orders</h1>





                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                <img class="card-img" src="../assets/dist/img/credit/Form-16.png" alt=""/>
                <a href="purchasing_order.php" <div class="text-center"><button type="submit"  class="btn border border-1 border-dark btn-warning w-50 mt-3 align-center">Create Purchase Order</button></a>

            </div>
        </div>
    </div>
    <div class="col-sm-4 mb-3 mb-sm-1">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title  card-title-large">View Orders</h1>





                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                
                <img class="card-img img-content-fluid" src="../assets/dist/img/credit/order-inquiry-3.png" alt=""/>
                <a href="purchasing_order.php" <div class="text-center"><button type="submit"  class="btn border border-1 border-dark btn-success  mt-3 align-center">View Orders</button></a>

            </div>
        </div>
    </div>
</div>

</div>
<div class="col-md-8">
</div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php'; //lay out file in out 2 steps behind
?>