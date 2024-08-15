<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Inventory And Stock Management";
$breadcrumb_item = "Inventory Management";
$breadcrumb_item_active = "Add Stock";
?>

<div class="tab-content" id="purchasing_order">
    <!-- Create Order Tab -->
    <div class="row">
        <div class="col-12">
            <a href="" class="btn btn-success mb-2"><i class="fas fa-plus-circle"></i> New</a>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add Stock</h3>
                </div>
                <div class="tab-pane fade show active" id="create_order" role="tabpanel" aria-labelledby="create-order-tab">
                    <div class="card-body">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            extract($_POST);

                            $item_id = dataClean($item_id);

                            $unit_price = dataClean($unit_price);
                            //$purchase_date = dataClean($purchase_date);


                            $message = array();
                            //required validation----------------------------

                            if (empty($item_id)) {
                                $message['item_id'] = "The item name should not be empty..!";
                            }
                            if (empty($qty)) {
                                $message['qty'] = "The qty should not be empty..!";
                            }
                            if (empty($unit_price)) {
                                $message['unit_price'] = "The unit price should not be empty..!";
                            }
                            if (empty($purchase_date)) {
                                $message['purchase_date'] = "The purchase date should not be empty..!";
                            }
                            if (empty($supplier_id)) {
                                $message['supplier_id'] = "The Supplier name should not be empty..!";
                            }
                            if (empty($message)) {
                                $db = dbConn();
                                echo $sql = "INSERT INTO item_stock (item_id,qty,unit_price,supplier_id,purchase_date,UnitId) VALUES ($item_id,$qty,$unit_price,$supplier_id,$purchase_date,$unit);";
                                $db->query($sql);
                                header("Location:manage.php");
                            }
                        }
                        ?>

                        <form  action="" method="post" role="form" novalidate>
                            <div class="form-group">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM suppliers";
                                $result = $db->query($sql);
                                ?>
                                <label for="supplier">Supplier Name</label><br><!-- comment -->
                                <select name="supplier_id" id="supplier_id" class=" col-12 height-control form-control-lg ">
                                    <option value=" ">--</option>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row['SupplierId'] ?>"<?= @$supplier_id == $row['SupplierId'] ? 'selected' : '' ?>><?= $row['FirstName'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?= @$message['supplier_id'] ?></span>

                            </div>
                            <div class="form-group">
                                <label for="PurchaseDate">Purchase Date</label>
                                <input type="date" class="form-control col-3" name="purchase_date" id="purchase_date" required value="<?= @$purchase_date ?>">
                                <span class="text-danger"><?= @$message['purchase_date'] ?></span>
                            </div> 
                            <div class="form-group">
                                <?php
                                $db = dbConn();
                                $sql = "SELECT * FROM items";
                                $result = $db->query($sql);
                                ?>
                                <label for="item_name" >Item Name</label>
                                <select name="item_id" id="item_id" class="col-12 height-control form-control-lg">
                                    <option value=" ">--</option>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        ?>

                                        <option value="<?= $row['id'] ?>"<?= @$item_id == $row['id'] ? 'selected' : '' ?>><?= $row['item_name'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <span class="text-danger"><?= @$message['item_id'] ?></span>
                            </div>
                            <table class="table  table-hover border border-success rounded-1  text-nowrap" id="materials">
                                <thead>
                                    <tr>
                                        <th>Unit</th>
                                        <th>Qty</th>

                                        <th>Unit Price</th>


                                        <th></th><th>
                                        </th></tr>
                                </thead>
                                <tbody>
                                    <tr class="material-row">

                                        <td>
                                            
                                            <?php
                                            $db = dbConn();
                                            $sql = "SELECT * FROM units";
                                            $result = $db->query($sql);
                                            ?>
                                            <select name="unit" id="unit" class="col-6 height form-control-lg">
                                                <option value=" ">--</option>
                                                <?php
                                                while ($row = $result->fetch_assoc()) {
                                                    ?>

                                                    <option value="<?= $row['UnitId'] ?>"<?= @$unit == $row['UnitId'] ? 'selected' : '' ?>><?= $row['Unit'] ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </td>

                                        <td>
                                            <input type="number" name="qty" class="form-control" id="quantity" placeholder="Enter Quantity" >

                                            <span class="text-danger"><?= @$message['qty'] ?></span>
                                        </td>





                                        <td> 

                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Rs</span>
                                                <input type="text" name="unit_price" class="form-control" aria-label="Amount (to the nearest dollar)">
                                                <span class="input-group-text">.00</span>


                                            </div>
                                            <span class="text-danger"><?= @$message['unit_price'] ?></span>



                                        </td>



                                    </tr>

                                </tbody>

                            </table>
                            <input type="submit" value="submit" class="btn btn-primary" >


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
