<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Inventory And Stock Management";
$breadcrumb_item = "Inventory Management";
$breadcrumb_item_active = "sales report";
?>



<div class="row">
    <div class="col-12">
        <div class="container order-container">
            <div class="order-header">
                <h2>Report</h2>
            </div>
            <div class="invoice p-3 mb-3 border border-1 border-black" id="contentToPrint">
                <!-- title row -->
                <div class="row" style="background-color:#91B940; color: #ffffff; padding: 10px; border-radius: 8px; height: 150px; display: flex; border: darkgreen">
                    <div class="col-4 d-flex align-items-center">
                        <img class='image img-fluid img-rounded' width="250" height="150" src="../assets/dist/img/credit/logo.jpg" alt=""/>
                    </div>
                    <div class="col-4 text-center d-flex align-items-center justify-content-center">
                        <h4 style="margin: 0;">
                            <strong><h2 class='font-weight-bold' style="color: #2C6581;"><i class="fas fa-list"></i> Monthly Sales Report</h2></strong>
                        </h4>
                    </div>
                </div>
                <!-- Info row -->
                <div class="row invoice-info mt-3">
                    <!-- Sales Report Information -->
                    <div class="col-sm-12 invoice-col">
                        <h4><b>Monthly Sales Report For 2024</b></h4>
                    </div>
                </div>
                <!-- Table row -->
                <div class="row mt-3">
                    <div class="col-12 table-responsive">
                        <?php
                        $db = dbConn();
                        $sql = "SELECT DATE_FORMAT(purchase_date, '%M') AS Month, SUM(qty) AS TotalQuantity, SUM(issued_qty) AS TotalIssuedQuantity, SUM(issued_qty * unit_price) AS TotalSales FROM item_stock GROUP BY DATE_FORMAT(purchase_date, '%M') ORDER BY Month";
                        $result = $db->query($sql);
                        ?>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Total Qty</th>
                                    <th>Total Issued Qty</th>
                                    <th>Total Sales</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?= $row['Month'] ?></td>
                                            <td><?= $row['TotalQuantity'] ?></td>
                                            <td><?= $row['TotalIssuedQuantity'] ?></td>
                                            <td><?= $row['TotalSales'] ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- this row will not appear when printing -->
                <div class="row no-print mt-3">
                    <div class="col-12">
                        <button type="button" onclick="printContent()" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
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
include '../layouts.php'; //lay out file in out 2 steps behind
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

