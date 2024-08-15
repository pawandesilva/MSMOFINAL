<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Employee Management";
$breadcrumb_item = "Employee Management";
$breadcrumb_item_active = "manage";
?>


<div class="row col-md-10">
    <div class="col-sm-4 mb-3 mb-sm-1">
        
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                <h1 class="card-title card-title-large mb-2 text-center"><h2 class="text-center mb-5"><strong>Manage Employee</strong></h2></h1>
                <img class="card-img img-content-fluid mb-3" src="../assets/dist/img/credit/supplier3.jpg" alt=""/>
                <div class="text-center mt-auto">
                    <a href="emp_management.php">
                        <button type="submit" class="btn border border-1 border-dark btn-success w-100 mt-3 align-center">Manage</button>
                    </a>
                </div>
            </div>
        </div>
        
        
    </div>
    <div class="col-sm-4 mb-3 mb-sm-1">
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                
                <h1 class="card-title card-title-large mb-2 text-center"><h2 class="text-center"><strong>Employee Profile</strong></h2></h1>
                <img class="card-img img-content-fluid mb-3" src="../assets/dist/img/credit/profile.jpg" alt=""/>
                <div class="text-center mt-auto">
                    <a href="view_suppliers.php">
                        <button type="submit" class="btn border border-1 border-dark btn-info w-100 mt-3 align-center">View Profile</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4 mb-3 mb-sm-1">
       
        
        <div class="card h-100">
            <div class="card-body d-flex flex-column">
                 <h1 class="card-title card-title-large mb-2 text-center"><h2 class="text-center mb-4"><strong>Employee Contacts</strong></h2></h1>
              
                <img class="card-img mb-3" src="../assets/dist/img/credit/supplier profile.jpg" alt=""/>
                <div class="text-center mt-auto">
                    <a href="contacts.php">
                        <button type="submit" class="btn border border-1 border-dark btn-warning w-100 mt-3 align-center">View Contacts</button>
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