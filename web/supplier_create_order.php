<?php
ob_start();
include 'supplier_layout.php';
include '../functions.php';
include '../config.php';
?>
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5  rounded">
            <div class="row g-4">
                <div class="text-center mx-auto mt-5" style="max-width: 700px; color: #935116">
                    <h1 class="text-center  " style="color: #935116">Create Proforma Invoice</h1>
                    <hr class="col-6 offset-md-3 mb-4 ">
                </div>
                <div class="card container-fluid" style="background-color: #C7E8CA">

                    <div class="col-12 container-fluid mt-4 mb-4">


                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            extract($_POST);

                            $order_name = dataClean($order_name);

                            
                            
                            $order_date = dataClean($order_date);
                            $exp_date = dataClean($exp_date);
                            $message = array();
                            //required validation-----------------------------------------
                            if (empty($order_name)) {
                                $message['order_name'] = "The order name should not be blank..!";
                            }
                            if (empty($order_date)) {
                                $message['order_date'] = "The order date should not be empty..!";
                            }
                            if (empty($exp_date)) {
                                $message['exp_date'] = "The order date should not be empty..!";
                            }
                            if (empty($materials)) {
                                $message['materials'] = "The materials should not be empty..!";
                            }
                            if (empty($qty)) {
                                $message['qty'] = "The qty should not be empty..!";
                            }
                            if (empty($unit_price)) {
                                $message['unit_price'] = "The unit price should not be empty..!";
                            }
                            if (empty($weight)) {
                                $message['weight'] = "The weigth should not be empty..!";
                            }
                            if (empty($units)) {
                                $message['units'] = "The units should not be empty..!";
                            }












                            /* if (isset($_FILES['itemImages'])) {
                              $itemImages = $_FILES['itemImages'];
                              $uploadResult = uploadFiles($itemImages);

                              foreach ($uploadResult as $key => $value) {
                              if ($value['uplaod']) {//check upload true
                              echo $value['file'];
                              $sql = "INSERT INTO itemimage(columns) Values()";
                              } else {
                              foreach ($value as $result) {
                              echo $result; //display errors
                              }
                              }
                              }
                              } */
                            
                            if (empty($message)) {
                                extract($_GET);
                                $userId = $_SESSION['USERID'];
                                $db = dbConn();
                                $sql = "SELECT * FROM suppliers   WHERE UserId='$userId' ";
                                $result = $db->query($sql);
                                $row = $result->fetch_assoc();
                                $supplierId = $row['SupplierId'];
                                // Insert into profoma_invoices
                                 $sql1 = "INSERT INTO profoma_invoices (PoName,Date,SupplierId) VALUES('$order_name','$order_date','$supplierId')";
                                $db->query($sql1);
                                $PI_Id=$db->insert_id;

                                
                               
                                
                                //Insert into Raw_material_Stock
                                foreach($materials as $key=>$value){
                                    $w=$weight[$key];
                                    $q=$qty[$key];
                                    $price=$unit_price[$key];
                                    $u=$units[$key];
                                $sql3 ="INSERT INTO raw_material_stock (MaterialId,Weight,Date,ExpDate,Amount,UnitPrice,Details,ProformaId,UnitId) VALUES ('$value','$w','$order_date','$exp_date','$q','$price','$details','$PI_Id','$u')";
                                $db->query($sql3);
                                }
                            }
                        }
                        ?>
                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" enctype="multipart/form-data" novalidate >

                            <div class="form-group mt-3">
                                <?php
                                extract($_GET);
                                $userId = $_SESSION['USERID'];
                                $db = dbConn();
                                $sql = "SELECT * FROM suppliers   WHERE UserId='$userId' ";
                                $result = $db->query($sql);
                                $row = $result->fetch_assoc();
                                $supplierId = $row['SupplierId'];
                                $sql = "SELECT * FROM purchasing_orders WHERE SupplierId='$supplierId'";
                                $result = $db->query($sql);
                                //$sql = "SELECT * FROM  purchasing_orders po  INNER JOIN suppliers s ON  s.SupplierId=po.SupplierId INNER JOIN users u ON s.UserId=u.UserId WHERE s.SupplierId= '$supplierId' ";
                                ?>
                                <label for="Order_name">Order Name</label>
                                <select name="order_name" id="order_name"  class="form-select form-select-lg mb-3 border border-1 border-dark" aria-label="Large select example">
                                    <option value="" >--</option>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <option value="<?= $row['OrderId'] ?>"><?= $row['OrderName'] ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="form-group col-4 mb-4">

                                    <label for="orderDate">Order Date</label>
                                    <input type="date" class="form-control col-3" id="order_date" name="order_date">
                                    <span class="text-danger"><?= @$message['order_date'] ?></span>
                                </div>
                                <div class="form-group col-4 mb-4">

                                    <label for="orderDate">Expire Date</label>
                                    <input type="date" class="form-control col-3" id="exp_date" name="exp_date">
                                    <span class="text-danger"><?= @$message['exp_date'] ?></span>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <table class="table  table-hover border border-success rounded-1  text-nowrap" id="materials">
                                    <thead>
                                        <tr>
                                            <th><b>Material</b></th>
                                            <th>Qty</th>
                                            <th>Weight</th>

                                            <th>Unit Price</th>


                                            <th></th><th>
                                            </th></tr>
                                    </thead>
                                    <tbody>
                                        <tr class="material-row">
                                            <td>
                                                <select name="materials[]" id="materials" class="form-control " required>
                                                    <option>--</option>
                                                    <?php

                                                    $db = dbConn();
                                                    $sql = "SELECT MaterialId ,MaterialName FROM raw_materials";
                                                    $result = $db->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            ?>
                                                            <option value="<?= $row['MaterialId'] ?>"><?= $row['MaterialName'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    
                                                    ?>
                                                </select>
                                                <span class="text-danger"><?= @$message['material'] ?></span>

                                            </td>
                                            <td><input type="number" name="qty[]" class="form-control" id="quantity" placeholder="Enter Quantity" ><span class="input-group-text"><select name="units[]" id="units" class="form-control " required>
                                                    <option>--</option>
                                                    <?php

                                                    $db = dbConn();
                                                    $sql = "SELECT UnitId,Unit FROM units";
                                                    $result = $db->query($sql);
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            ?>
                                                            <option value="<?= $row['UnitId'] ?>"><?= $row['Unit'] ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    
                                                    ?>
                                                </select><span class="text-danger"><?= @$message['units'] ?></span></span><span class="text-danger"><?= @$message['qty'] ?></span></td>
                                            <td><input type="number" name="weight[]" class="form-control" id="weight" placeholder="Enter weight" ><span class="input-group-text">Kg</span><span class="text-danger"><?= @$message['weight'] ?></span></td>

                                            <td> 
                                                <div class="input-group mb-3">
                                                    <span class="input-group-text">Rs</span>
                                                    <input type="text" class="form-control" name="unit_price[]" id="unit_price" placeholder="Unit Price" >
                                                    <span class="input-group-text">.00</span>

                                                </div>
                                                <span class="text-danger"><?= @$message['unit_price'] ?></span>

                                            </td>

                                            <td><button type="button" class="removeBtn btn btn-danger btn-sm mt-1 ml-3" >Remove</button>  </td>

                                        </tr>

                                    </tbody>
                                </table>
                                <div class="form-group align-content-sm-start">
                                    <button type='button' id='addbtn' class='btn btn-warning   mt-2 mb-4'>Add Material</button>
                                </div>
                                <div>







                                    <div class="input-group">
                                        <span class="input-group-text">More Details</span>
                                        <textarea class="form-control" id="details" name="details" aria-label="With textarea"></textarea>
                                    </div>
                                    <div class="text-center"><button type="submit" class="w-100 btn form-control border-secondary py-3 bg-white text-primary mt-4">Submit</button></div
                                    </form>

                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
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

