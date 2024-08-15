<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Order Management";
$breadcrumb_item = "Order Management";
$breadcrumb_item_active = "manage_Orders";

extract($_GET);
extract($_POST);
//$data=$order_id;
?>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">



                <!-- Main content -->
                <div class="invoice p-3 mb-3">
                    <!-- title row -->
                    <div class="row" style="background-color:#95D2B3; color: #ffffff; padding: 10px; border-radius: 8px;height: 75px; display: flex; border: darkgreen">

                        <div class="col-12">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT `order_date` , `FirstName`,`LastName`, `delivery_name`, `delivery_address`, `delivery_phone`, `billing_name`, `billing_address`, `billing_phone`, `order_number`, `new_order_flag`" . " FROM `orders` INNER JOIN customers ON orders.customer_id=customers.CustomerId";
                            $result = $db->query($sql);
                            ?>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <h4>
                                        <i class="fas fa-cart-arrow-down"></i>Order Number:<?= $row['order_number'] ?><br>
                                        <small class="">Customer:<?= $row['FirstName'] ?> <?= $row['LastName'] ?></small>
                                        <small class="float-right">Order Date:<?= $row['order_date'] ?></small>


                                    </h4>
                                </div>

                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info mt-auto">
                                <div class="col-sm-4 invoice-col mt-4">
                                    <strong><h4 class="underlined-heading">Delivery Details</h4></strong>
                                    <address>
                                        <strong>Delivery Name:</strong><?= $row['delivery_name'] ?><br>

                                        <strong>Delivery Address:</strong><br>
        <?= $row['delivery_address'] ?><br>
                                        <strong>Delivery Phone:</strong>
                                        <?= $row['delivery_phone'] ?><br>

                                    </address>
                                </div>

                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col mt-4">
                                    <strong><h4 class="underlined-heading">Billing Details</h4></strong>
                                    <address>
                                        <strong>Billing Name:</strong><?= $row['billing_name'] ?><br>

                                        <strong>Billing Address:</strong><br>
        <?= $row['billing_address'] ?><br>
                                        <strong>Billing Phone:</strong>
                                        <?= $row['billing_phone'] ?><br>

                                    </address>
                                </div>
        <?php
    }
}
?>
                        <!-- /.col -->

                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row mt-">
                        <div class="col-12 table-responsive">
                            <table class="table table-striped">
<?php
$db = dbConn();
$sql = "SELECT  `order_id`, `item_id`,`item_name`, `stock_id`, `unit_price`, `qty` FROM `order_items` INNER JOIN items ON order_items.item_id=items.id WHERE 1";
$result = $db->query($sql);
?>
                                <thead>
                                    <tr>
                                        <th>Product Name</th>
                                        <th>Unit Price</th>
                                        <th>Qty</th>
                                        <th>Amount</th>

                                    </tr>
                                </thead>
                                <tbody>
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $rows = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $rows[] = $row; // Add each row to the $rows array
            }
        } else {
            // Handle the case where no rows are returned
            echo "No data found.";
        }
        echo "<pre>";
print_r($rows);
echo "</pre>";
        $total = 0; //initialize total amount
        $totalAmount=0;
        foreach ($rows as $row) {
            $itemtotal = $row['qty'] * $row['unit_price'];
            $totalAmount += $itemtotal; //add item total to overall total
        }
        ?>

                                            <tr>
                                                <td><?= $row['item_name'] ?></td>
                                                <td><?= $row['unit_price'] ?></td>
                                                <td><?= $row['qty'] ?></td>
                                                <td><?= $itemtotal ?></td>

                                            </tr>

                                        </tbody>

                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row align-content-end">

                                <!-- /.col -->
                                <div class="col-6">
                                    <p class="lead">Amount Due 2/22/2014</p>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td><?= $totalAmount ?></td>
                                            </tr>
                                            <tr>
                                                <th>Tax (9.3%)</th>
                                                <td>$10.34</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping:</th>
                                                <td>$5.80</td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td>$265.24</td>
                                            </tr>
                                        </table>
        <?php
    }
}
?>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                    <div class="row mt-3 mb-5" style="background-color:#95D2B3; color: #ffffff; padding: 10px; border-radius: 8px;height: 50px; display: flex; border: darkgreen"></div>

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-12">
                            <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                            <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                                Payment
                            </button>
                            <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                <i class="fas fa-download"></i> Generate PDF
                            </button>
                        </div>
                    </div>
                </div>
                <!-- /.invoice -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<?php
$content = ob_get_clean();
include '../layouts.php'; //lay out file in out 2 steps behind
?>
