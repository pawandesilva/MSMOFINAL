<?php
ob_start();
session_start();
$link = "Appoinments";//browser left side text
$breadcrumb_item = "Appoinments";
$breadcrumb_item_active = "Manage";
include '../init.php';
echo 'test';
?>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>