<?php
ob_start();
session_start();
include_once '../init.php';
include "../../phpqrcode/qrlib.php";

$link = "Order Management";
$breadcrumb_item = "Order Management";
$breadcrumb_item_active = "View Purchasing Order";

extract($_GET);

$qr_path = '../../qr/';

if (!file_exists($qr_path))
    mkdir($qr_path);

$errorCorrectionLevel = 'L';
$matrixPointSize = 4;

$data = $appointment_id;
$filename = $qr_path . 'test' . md5($data . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';

QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchasing Order</title>
    <style>
        body {
            background-color: #f4f7fa;
            font-family: Arial, sans-serif;
        }
        .order-container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            margin-top: 30px;
        }
        .order-header {
            text-align: center;
            border-bottom: 1px solid #dee2e6;
            padding-bottom: 20px;
            margin-bottom: 20px;
            background-color: #28a745;
            color: #ffffff;
            border-radius: 8px 8px 0 0;
        }
        .order-header h2 {
            font-size: 2.5rem;
            font-weight: 700;
        }
        .order-section {
            margin-bottom: 20px;
        }
        .order-section h4 {
            font-size: 1.25rem;
            font-weight: 600;
            color: #28a745;
            margin-bottom: 15px;
        }
        .order-section p {
            font-size: 1rem;
            color: #6c757d;
            margin-bottom: 5px;
        }
        .table-responsive {
            margin-top: 20px;
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }
        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            background-color: #28a745;
            color: #ffffff;
        }
        .table tbody tr:nth-of-type(even) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .order-footer {
            text-align: center;
            padding: 20px;
            background-color: #28a745;
            color: #ffffff;
            border-radius: 0 0 8px 8px;
            margin-top: 30px;
        }
        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }
        .btn-default {
            color: #212529;
            background-color: #f8f9fa;
            border-color: #f8f9fa;
        }
        .btn-success {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-primary {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
    </style>
</head>
<body>

<div class="row">
    <div class="col-12"> 
        <div class="container order-container">
            <div class="order-header">
                <h2>Purchasing Order</h2>
            </div>
            <div class="invoice p-3 mb-3" id="contentToPrint">
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <img class='image img-content-fluid height-control' width="200" height="150" src="../assets/dist/img/credit/logo.jpg" alt=""/>
                        <h4>
                            <i class="fas fa-list"></i> Job Card.
                            <small class="float-right">Date: <?= date('Y/m/d') ?></small>
                        </h4>
                    </div>
                    <div class="col-sm-4 offset-9 invoice-col">
                        <?= '<img src="' . $qr_path . basename($filename) . '" width="200" height="200"/>'; ?>
                    </div>
                </div>
                
                <!-- info row -->
                <div class="row invoice-info">
                    <!-- Supplier Info -->
                    <div class="col-sm-4 invoice-col">
                        <div class="row">
                            <div class="col-md-5 order-section">
                                <h4>Supplier Information</h4>
                                <?php
                                $db = dbConn();
                                $sql = "SELECT s.FirstName, s.CompanyName, s.AddressLine1, s.AddressLine2, s.AddressLine3, s.Email, s.MobileNo, s.RegNo 
                                        FROM suppliers s 
                                        INNER JOIN purchasing_orders po ON s.SupplierId = po.SupplierId 
                                        WHERE po.OrderId = 1;";
                                $result = $db->query($sql);
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <p><strong>Supplier:</strong> <?= $row['FirstName'] ?></p>
                                        <address>
                                            <p><strong>Address:</strong> <?= $row['AddressLine1'] ?>,<br>
                                            <?= $row['AddressLine2'] ?>,<br>
                                            <?= $row['AddressLine3'] ?>.</p>
                                        </address>
                                        <p><strong>Phone:</strong> <?= $row['MobileNo'] ?></p>
                                        <p><strong>Email:</strong> <?= $row['Email'] ?></p>
                                        <p><strong>Reg No:</strong> <?= $row['RegNo'] ?></p>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                    <!-- Order Info -->
                    <div class="col-sm-4 invoice-col">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT po.OrderId, po.OrderName, po.DiliveryDate, po.DueDate 
                                FROM purchasing_orders po 
                                WHERE po.OrderId = 1;";
                        $result = $db->query($sql);
                        ?>
                        <b>Invoice #007612</b><br><br>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <b>PO Number:</b> <?= 'PO' . date('Ymd') . $row['OrderId'] ?><br>
                                <b>Order ID:</b> <?= $row['OrderId'] ?><br>
                                <b>Order Due Date:</b> <?= $row['DueDate'] ?><br>
                                <b>Account:</b> 968-34567
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
                        $sql = "SELECT po.OrderId, po.OrderName, s.FirstName, po.ProductDescription, po_items.Material, po_items.Qty 
                                FROM purchasing_orders po 
                                INNER JOIN po_items ON po.OrderId = po_items.OrderId 
                                INNER JOIN suppliers s ON po.SupplierId = s.SupplierId 
                                WHERE po.OrderId = 2;";
                        $result = $db->query($sql);
                        ?>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Order Id</th>
                                    <th>Order Name</th>
                                    <th>Supplier</th>
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
                                            <td><?= $row['OrderId'] ?></td>
                                            <td><?= $row['OrderName'] ?></td>
                                            <td><?= $row['FirstName'] ?></td>
                                            <td><?= $row['Material'] ?></td>
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
                </div>

                <div class="row no-print">
                    <div class="col-12">
                        <button type="button" onclick="printContent()" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                        <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit Job Card</button>
                        <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;"><i class="fas fa-download"></i> Generate PDF</button>
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
    function printContent() {
        var content = document.getElementById("contentToPrint").innerHTML;
        var originalBody = document.body.innerHTML;
        document.body.innerHTML = content;
        window.print();
        document.body.innerHTML = originalBody;
    }
</script>
</body>
</html>
