<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Order Management";
$breadcrumb_item = "Order Management";
$breadcrumb_item_active = "purchasing order";
?>
<div class="tab-content" id="purchasing_order">
    <!-- Create Order Tab -->
    <div class="row">
        <div class="col-12">
            <a href="" class="btn btn-success mb-2"><i class="fas fa-plus-circle"></i> New</a>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create Purchasing Order</h3>
                </div>
                <div class="tab-pane fade show active" id="create_order" role="tabpanel" aria-labelledby="create-order-tab">

                    <div class="card-body">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            extract($_POST);
                            $order_name = dataClean($order_name);
                            $address_line1 = dataClean($address_line1);
                            $address_line2 = dataClean($address_line2);
                            $address_line3 = dataClean($address_line3);
                            $description = dataClean($description);
                            
                            //required validation------------------------------
                            if(empty($order_name)){
                                $message['order_name'] = "Order name should not be blank..!";
                            }
                            if(empty($order_date)){
                                $message['order_date'] = "Order Date should not be blank..!";
                                
                            }
                             if(empty($order_due_date)){
                                $message['order_due_date'] = "Order Due Date should not be blank..!";
                                
                            }
                            if(empty($FirstName)){
                                $message['FirstName'] = "Supplier Name should not be blank..!";
                                
                            }
                            if(empty($unit_price)){
                                $message['unit_price'] = "Unit Price should not be blank..!";
                                
                            }
                            if(empty($unit_price)){
                                $message['unit_price'] = "Unit Price should not be blank..!";
                                
                            }
                            if(empty($payment_method)){
                                $message['payment_method'] = "payment Method should not be blank..!";
                                
                            }
                            if(empty($address_line1)){
                                $message['address_line1'] = "Shippling Address should not be blank..!";
                                
                            }
                        }
                        ?>

                        <form>
                            <div class="form-group">
                                <label for="order_name">Order Name </label>
                                <input type="text" class="form-control" id="order_name" placeholder="Enter Order Name ">
                            </div>
                            <div class="form-group">
                                <label for="orderDate">Order Date</label>
                                <input type="date" class="form-control" id="order_date">
                            </div>
                            <div class="form-group">

                                <label for="orderDate">Order Due Date</label>
                                <input type="date" class="form-control" id="order_due_date">
                            </div>
                            <div class="form-group">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM suppliers";
                                $result = $db->query($sql);
                                ?>
                                <label for="FirstName">Supplier Name</label><br>
                                <select name="FirstName" id="FirstName"  class=" col-12 height-control form-control-lg border " >
                                    <option value="">--</option>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row['SupplierId'] ?>"><?= $row['FirstName'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM suppliers";
                                $result = $db->query($sql);
                                ?>
                                <label for="company_name">Company Name</label>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>

                                    <input type="text" class="form-control" id="order_date" value="<?= $row['CompanyName'] ?>" >
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="form-group mt-3">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" name="email" id="email" placeholder="Email" required>
                            <span class="text-danger"><?= @$message['email'] ?></span>
                        </div>
                            <div class="form-group mt-3">
                            <label for="telno">Tel. No.(Home)</label>
                            <input type="text" class="form-control " name="telno" id="telno" placeholder="Tel. No." required>
                        </div>
                            <div class="form-group">
                                <label for="unit_price">Unit Price</label>
                                <input type="number" class="form-control" id="unit_price"  placeholder="Enter Unit Price">
                            </div>
                            <div class="form-group">
                                <label for="quantity">Quantity</label>
                                <input type="number" class="form-control" id="quantity" placeholder="Enter Quantity">
                            </div>
                            <div class="form-group">
                                <label for="Payment_method">Payment Method</label>
                                <select name="payment_method" id="payment_method" class="col-12 height-control form-control-lg border">
                                    <option>--</option>
                                    <option>Bank Transfer</option>
                                    <option>Check</option>
                                    <option>Cash On Delivery</option>

                                </select>
                            </div>
                            <div class="form-group mt-3">
                                <label for="address_line1">Shipping Address</label><br>
                                <label for="address_line1">Address Line 1</label>
                                <input type="text" class="form-control " name="address_line1" id="address_line1" placeholder="Address Line 1" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="address_line2">Address Line 2</label>
                                <input type="text" class="form-control " name="address_line2" id="address_line2" placeholder="Address Line 2" required>
                            </div>
                            <div class="form-group mt-3">
                                <label for="address_line3">Address Line 3</label>
                                <input type="text" class="form-control " name="address_line3" id="address_line3" placeholder="Address Line 3" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Product/Service Description</label>
                                <textarea class="form-control" id="description" rows="3" placeholder="Enter Product/Service Description"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit For Approval</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- View Orders Tab -->
            <div class="tab-pane fade" id="view-orders" role="tabpanel" aria-labelledby="view-orders-tab">
                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Existing Orders</h5>
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Order Number</th>
                                    <th scope="col">Order Date</th>
                                    <th scope="col">Supplier Name</th>
                                    <th scope="col">Item Details</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Sample Order Row -->
                                <tr>
                                    <td>001</td>
                                    <td>2023-05-01</td>
                                    <td>ABC Suppliers</td>
                                    <td>Item A, Item B</td>
                                    <td>100</td>
                                    <td>$1000</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning">Edit</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </td>
                                </tr>
                                <!-- Repeat rows as needed -->
                            </tbody>
                        </table>
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