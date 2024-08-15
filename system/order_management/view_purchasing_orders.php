<?php
ob_start();
session_start();
include_once '../init.php';
include "../../phpqrcode/qrlib.php";

$link = "Order Management";
$breadcrumb_item = "Order Management";
$breadcrumb_item_active = "view purchsing order";

extract($_GET);
extract($_POST);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    
    $db= dbConn();
    $sql = "UPDATE purchasing_orders SET Status='$status' WHERE OrderId='$orderid'";
    $db->query($sql);
}


$qr_path = '../../qr/';

if (!file_exists($qr_path))
    mkdir($qr_path);

$errorCorrectionLevel = 'L';
$matrixPointSize = 4;

$data = $orderid;

$filename = $qr_path . 'test' . md5($data . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';

QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
?>

<div class="row">
    <div class="col-12"> 
        <div class="container order-container ">
            <div class="order-header "  >
                <h2>Purchasing Order</h2>
            </div>
            <div class="invoice p-3 mb-3 border border-1 border-black" id="contentToPrint">
                <!-- title row -->
                <div class="row" style="background-color:#91B940; color: #ffffff; padding: 10px; border-radius: 8px;height: 150px; display: flex; border: darkgreen">
                    <div class="col-4 d-flex align-items-center">
                        <img class='image img-fluid img-rounded' width="250" height="150" src="../assets/dist/img/credit/logo.jpg" alt=""/>
                    </div>
                    <div class="col-4 text-center d-flex align-items-center justify-content-center">
                        <h4 style="margin: 0;">
                            <strong><h2 class='font-weight-bold ' style="color: #2C6581;"><i class="fas fa-list"></i> Purchasing Order</h2></strong>
                        </h4>
                    </div>
                    <div class="col-4 text-right">
                        <?= '<img src="' . $qr_path . basename($filename) . '" width="100" height="100"/>'; ?><br>
                        style="display: block; margin-top: 10px;">Date: <?= date('Y/m/d') ?>
                            </div>
                            </div>


                            <!-- Info row -->
                            <div class="row invoice-info">
                            <!-- Supplier Information -->
                            <div class="col-sm-6 invoice-col mt-2 ">
                            <div class="order-section">
                            <h4><b>Supplier Information</b></h4>
                            <?php
                            $db = dbConn();
                            
                            $sql = "SELECT s.FirstName, s.CompanyName, s.AddressLine1, s.AddressLine2, s.AddressLine3, s.Email, s.MobileNo, s.RegNo 
                    FROM suppliers s 
                    INNER JOIN purchasing_orders po ON s.SupplierId = po.SupplierId 
                    WHERE po.OrderId = '$orderid';";
                            $result = $db->query($sql);
                            ?>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <div class="d-flex">
                                    <div style="flex: 1;">
                                    <p><strong>Supplier:</strong> <?= $row['FirstName'] ?></p>
                                    <address>
                                    <p><strong>Address:</strong><br>
                                    <?= $row['AddressLine1'] ?>,<br>
                                    <?= $row['AddressLine2'] ?>,<br>
                                    <?= $row['AddressLine3'] ?>.</p>
                                    </address>
                                    </div>
                                    <div style="flex: 1; padding-left: 20px;">
                                    <p><strong>Phone:</strong> <?= $row['MobileNo'] ?></p>
                                    <p><strong>Email:</strong> <?= $row['Email'] ?></p>
                                    <p><strong>Reg No:</strong> <?= $row['RegNo'] ?></p>
                                    </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            </div>
                            </div>
                            <!-- Order Information -->
                            <div class="col-sm-6 invoice-col  mt-5 ">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT po.OrderId, po.OrderName, po.DiliveryDate, po.DueDate,po.PaymentMethod ,po.Status
                FROM purchasing_orders po 
                WHERE po.OrderId = '$orderid';";
                            $result = $db->query($sql);
                            
                            ?>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <b>PO Number:</b> <?= 'PO' . date('Y') . date('m') . date('d') . $row['OrderId'] ?><br>
                                    <b>Order ID:</b> <?= $row['OrderId'] ?><br>
                                    <b>Order Due Date:</b> <?= $row['DueDate'] ?><br>
                                    <b>Payment Method:</b> <?= $row['PaymentMethod'] ?><br>
                                    <b>Status:<?= $row['Status']=='1'?'Approved':'' ?></b> <br>
                                    <?php
                                }
                            }
                            ?>
                            </div>
                            </div>


                            <!-- Table row -->
                            <div class="row">
                            <div class="col-12 table-responsive">
                            <?php
                            $db = dbConn();
                            
                            $sql = "SELECT po_items.Material, po_items.Qty, po.ProductDescription,rm.MaterialName 
                FROM purchasing_orders po 
                INNER JOIN po_items ON po.OrderId = po_items.OrderId 
                INNER JOIN suppliers s ON po.SupplierId = s.SupplierId INNER JOIN raw_materials rm ON rm.LotNo=po_items.Material 
                WHERE po.OrderId = '$orderid'";
                            
                            $result = $db->query($sql);
                            
                            ?>
                            <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                            <th>Material</th>
                            <th>Qty</th>
                            <th>Description</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                    <td><?= $row['MaterialName'] ?></td>
                                    <td><?= $row['Qty'] ?></td>
                                    <td><?= $row['ProductDescription'] ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            </tbody>
                            </table>
                            </div>
                            <!-- /.col -->
                            </div>
                            <!-- /.row -->




                            <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">

                            </div>

                            </div>
                            <!-- /.row -->
                            <div class="row mt-3 mb-5" style="background-color:#91B940; color: #ffffff; padding: 10px; border-radius: 8px;height: 50px; display: flex; border: darkgreen"></div>

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                            <div class="col-12">
                            <button type="button" onclick="printContent()" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                            <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                            Purchasing Order
                            </button>
                            <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                            <i class="fas fa-download"></i> Generate PDF
                            </button>
                            
                            
                            </div>
                            </div>
                            </div>

                            </div>
                            </div>
                            </div>
                            <?php
                            $content = ob_get_clean();
                            include '../layouts.php';
                            ?>
                            <script>
                            //print function
                            function printContent() {
                                var content = document.getElementById("contentToPrint").innerHTML;
                                var originalBody = document.body.innerHTML;
                                document.body.innerHTML = content;
                                window.print();
                                document.body.innerHTML = originalBody;

                            }

                            </script>