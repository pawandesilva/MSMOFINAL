<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Inventory And Stock Management";
$breadcrumb_item = "Inventory Management";
$breadcrumb_item_active = "manage";
?>


<div class="row col-md-10">
    <div class="col-sm-4 mb-3 mb-sm-1">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <h1 class="card-title card-title-large mb-2 text-center"><h2 class="text-center mb-5"><strong>Material Stock</strong></h2></h1>
                <img class="card-img img-content-fluid mb-3" src="../assets/dist/img/credit/material_stock.jpg" alt=""/>
                <div class="text-center mt-auto">
                    
                    <a href="material_stock_manage.php">
                        <button type="submit" class="btn border border-1 border-dark btn-warning w-100 mt-3 align-center">Manage Materials</button>
                    </a>
                </div>
            </div>
        </div>
        
        
    </div>
    <div class="col-sm-4 mb-3 mb-sm-1">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                
                <h1 class="card-title card-title-large mb-2 text-center"><h2 class="text-center"><strong>Product Stock</strong></h2></h1>
                <img class="card-img img-content-fluid mt-5" src="../assets/dist/img/credit/product_stock.jpg" alt=""/>
                
                <div class="text-center mt-auto">
                    <a href="product_stock_manage.php">
                        <button type="submit" class="btn border border-1 border-dark btn-success w-100 mt-3 align-center">Manage Products</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 mb-3 mb-sm-1">
       
        
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                 <h1 class="card-title card-title-large mb-2 text-center"><h2 class="text-center mb-4"><strong>Stock Reports</strong></h2></h1>
              
                <img class="card-img mb-3" src="../assets/dist/img/credit/stock_report.jpg" alt=""/>
                <div class="text-center mt-auto">
                    
                    <a href="reports.php">
                        <button type="submit" class="btn border border-1 border-dark btn-info w-100 mt-3 align-center">View Reports</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean();
include '../layouts.php'; //lay out file in out 2 steps behind
?>