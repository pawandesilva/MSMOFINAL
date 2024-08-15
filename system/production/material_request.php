<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Production Management";
$breadcrumb_item = "Production Management";
$breadcrumb_item_active = "Material Request";
?>
<div class="tab-content" id="purchasing_order">
    <!-- Create Order Tab -->
    <div class="row">
        <div class="col-12">
            <a href="" class="btn btn-success mb-2"><i class="fas fa-plus-circle"></i> New Material Request</a>
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create Raw Material Request</h3>
                </div>
                <div class="tab-pane fade show active" id="material_request" role="tabpanel" aria-labelledby="materialrequest-tab">

                    <div class="card-body">
                        <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            extract($_POST);
                            //$order_name = dataClean($order_name);

                            $description = dataClean($description);
                            

                            //required validation------------------------------
                            if (empty($material_request_name)) {
                                $message['material_request_name'] = "Material request name should not be blank..!";
                            }
                            if (empty($RequestDate)) {
                                $message['RequestDate'] = "Request Date should not be blank..!";
                            }
                            if (empty($RequestDueDate)) {
                                $message['RequestDueDate'] = "Request Due Date should not be blank..!";
                            }
                            
                            //if (empty($material)) {
                            //$message['FirstName'] = "Material should not be blank..!";
                            //}
                            // if (empty($quantitiy)) {
                            // $message['quantity'] = "quantity should not be blank..!";
                            // }
                            


                            if (empty($message)) {
                                $db = dbConn();
                                $sql = "INSERT INTO raw_material_requests (RequestName, RequestDate, RequestDueDate) 
VALUES ('$material_request_name', '$RequestDate', '$RequestDueDate')";
                                $db->query($sql);
                                $req_Id = $db->insert_id;
                                
                                foreach ($materials as $key => $value) {
                                    $q = $qty[$key];
                                    $u=$units[$key];
                                    $sql ="INSERT INTO `raw_materialreq_items`( `Material`, `Qty`, `Unit`, `Description`,`Id`) VALUES ('$value','$q','$u','$description','$req_Id')";
                                    $db->query($sql);
                                }
                            }
                        }
                        ?>

                        <form  action="" method="post" role="form" novalidate>
                            <div class="form-group">
                                <label for="material_request_name">Material Request Name </label>
                                <input type="text" class="form-control" id="material_request_name" name="material_request_name"  placeholder="Material Request Name ">
                                <span class="text-danger"><?= @$message['material_request_name'] ?></span>
                            </div>
                            <div class="form-group">
                                <label for="RequestDate">Request Date</label>
                                <input type="date" class="form-control col-3" name="RequestDate" id="RequestDate">
                                <span class="text-danger"><?= @$message['RequestDate'] ?></span>
                            </div>
                            <div class="form-group">

                                <label for="RequestDueDate">Request Due Date</label>
                                <input type="date" class="form-control col-3" id="RequestDueDate" name="RequestDueDate">
                                <span class="text-danger"><?= @$message['RequestDueDate'] ?></span>
                            </div>
                            
                            <div class=" form-group">
                                <table class="table table-hover table-striped border border-1 text-nowrap" id="materials">
                                    <thead>
                                        <tr>
                                            <th>Material</th>
                                            <th>Qty</th>
                                            <th>Unit<th>
                                            
                                            

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
                                            <td><input type="number" name="qty[]" class="form-control" id="quantity" placeholder="Enter Quantity"></td>
                                                <td><span class="input-group-text"><select name="units[]" id="units" class="form-control " required>
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
                                                

                                            <td><button  type='button' class='removeBtn btn btn-danger btn-sm mt-1 ml-3'>Remove</button>  </td>
                                        </tr>
                                    </tbody>
                                </table>


                                <button type='button' id='addbtn' class='btn btn-warning  mt-2 mb-4'>Add Material</button>
                                <div>



                                 
                                    <div class="form-group">
                                        <label for="description">Material Description</label>
                                        <textarea class="form-control" name="description" id="description" rows="3" placeholder="Enter Product Description"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Create Request</button>
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