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

                            $description = dataClean($description);

                            //required validation------------------------------
                            if (empty($order_name)) {
                                $message['order_name'] = "Order name should not be blank..!";
                            }
                            if (empty($order_date)) {
                                $message['order_date'] = "Order Date should not be blank..!";
                            }
                            if (empty($order_due_date)) {
                                $message['order_due_date'] = "Order Due Date should not be blank..!";
                            }
                            if (empty($supplier_id)) {
                                $message['supplier_id'] = "Supplier Name should not be blank..!";
                            }
                            //if (empty($material)) {
                            //$message['FirstName'] = "Material should not be blank..!";
                            //}
                            // if (empty($quantitiy)) {
                            // $message['quantity'] = "quantity should not be blank..!";
                            // }
                            if (empty($payment_method)) {
                                $message['payment_method'] = "Payment Method should not be blank..!";
                            }


                            if (empty($message)) {
                                $db = dbConn();
                                $sql = "INSERT INTO purchasing_orders (OrderName, DiliveryDate, DueDate, SupplierId, PaymentMethod,ProductDescription) 
VALUES ('$order_name', '$order_date', '$order_due_date', '$supplier_id', '$payment_method','$description')";
                                $db->query($sql);
                                $po_id = $db->insert_id;
                                foreach ($materials as $key => $value) {
                                    $q = $qty[$key];
                                    $sql = "INSERT INTO po_items (OrderId, Material, Qty) VALUES ('$po_id', '$value', '$q')";
                                    $db->query($sql);
                                }
                            }
                        }
                        ?>

                        <form  action="" method="post" role="form" novalidate>
                            <div class="form-group">
                                <label for="order_name">Order Name </label>
                                <input type="text" class="form-control" id="order_name" name="order_name" value="<?= @$order_name ?>" placeholder="Enter Order Name ">
                                <span class="text-danger"><?= @$message['order_name'] ?></span>
                            </div>
                            <div class="form-group">
                                <label for="orderDate">Order Date</label>
                                <input type="date" class="form-control col-3" name="order_date" id="order_date">
                                <span class="text-danger"><?= @$message['order_date'] ?></span>
                            </div>
                            <div class="form-group">

                                <label for="orderDate">Order Due Date</label>
                                <input type="date" class="form-control col-3" id="order_due_date" name="order_due_date">
                                <span class="text-danger"><?= @$message['order_due_date'] ?></span>
                            </div>
                            <div class="form-group">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM suppliers";
                                $result = $db->query($sql);
                                ?>
                                <label for="FirstName">Supplier Name</label><br>
                                <select name="supplier_id" id="supplier_id"  class=" col-12 height-control form-control-lg border "  >
                                    <option value="">--</option>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row['SupplierId'] ?>"><?= $row['FirstName'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?= @$message['supplier_id'] ?></span>
                            </div>
                            <div class=" form-group">
                                <table class="table table-hover table-striped border border-1 text-nowrap" id="materials">
                                    <thead>
                                        <tr>
                                            <th>Material</th>
                                            <th>Qty</th>

                                            <th><th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="material-row">
                                            <td>
                                                <select name="materials[]" id="materials" class="form-control " required>
                                                    <option>--</option>
                                                    <?php
                                                    //field name is not lotid it should be material
                                                    $db = dbConn();
                                                    $sql = "SELECT LotNo ,MaterialName FROM raw_materials";
                                                    $result = $db->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            ?>
                                                            <option value="<?= $row['LotNo'] ?>"><?= $row['MaterialName'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    //where is the that sir lot no is in materials table iwant to take data from that
                                                    ?>
                                                </select>
                                                <span class="text-danger"><?= @$message['material'] ?></span>
                                            </td>
                                            <td><input type="number" name="qty[]" class="form-control" id="quantity" placeholder="Enter Quantity"></td>



                                            <td><button  type='button' class='removeBtn btn btn-danger btn-sm mt-1 ml-3'>Remove</button>  </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <button type='button' id='addbtn' class='btn btn-warning  mt-2 mb-4'>Add Material</button>
                                <div>



                                    <div class="form-group">
                                        <label for="Payment_method">Payment Method</label>
                                        <select name="payment_method" id="payment_method" class="col-12 height-control form-control-lg border">
                                            <option>--</option>
                                            <option>Cash</option>
                                            <option>Bank Transfer</option>
                                            <option>Check</option>
                                            <option>Cash On Delivery</option>

                                        </select>
                                        <span class="text-danger"><?= @$message['payment_method'] ?></span>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Product Description</label>
                                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter Product Description"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit For Approval</button>
                                    </form>
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
            $(document).ready(function () {
                //add item function
                function addMaterials() {
                    var tableBody = $('#materials tbody');
                    var newRow = tableBody.find('.material-row').first().clone(true);

                    //clear input values in cloned row
                    newRow.find('input').val('');

                    //append the cloned row to the table body
                    tableBody.append(newRow);
                }
                function removeMaterials(button) {
                    var row = $(button).closest('tr');
                    row.remove();
                }

                $('#addbtn').click(addMaterials);
                $('#materials').on('click', '.removeBtn', function () {
                    removeMaterials(this);
                });


            });
        </script>