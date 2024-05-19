
<?php 
ob_start();
session_start();//session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Delivery and Logistics";
$breadcrumb_item = "Delivery and Logistics";
$breadcrumb_item_active = "manage";
?>
<div class="row">
    <div class="col-4">        
        
        



    </div>
    <div class="col-md-8">
            </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';//lay out file in out 2 steps behind
?>

