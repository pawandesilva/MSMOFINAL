<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Production Management";
$breadcrumb_item = "Production Management";
$breadcrumb_item_active = "Material Request";
extract ($_GET);
?>


<div class="row">
    <div class="col-12"> 
        <div class="container order-container ">
            <div class="order-header "  >
                <h2>Material Request</h2>
            </div>
            <div class="invoice p-3 mb-3 border border-1 border-black" id="contentToPrint">
                <!-- title row -->
                <div class="row" style="background-color:#95D2B3; color: #ffffff; padding: 10px; border-radius: 8px;height: 75px; display: flex; border: darkgreen">
                    
                    <div class="col-4 text-center d-flex align-items-center justify-content-center">
                        <h4 style="margin: 0;">
                            <strong><h2 class='font-weight-bold align-items-center' style="color: #2C6581;"> Material Request</h2></strong>
                        </h4>
                    </div>
                    
                            </div>
                <!-- Table row -->
                            <div class="row">
                            <div class="col-12 table-responsive">
                            <?php
                            $db = dbConn();
                            
                            $sql = "SELECT * FROM raw_materialreq_items rmri INNER JOIN raw_materials rm ON rmri.Material=rm.MaterialId INNER JOIN units ON rmri.Unit=units.UnitId WHERE Id= '$req_id' ";   //rmri INNER JOIN raw_materials rm ON rmri.Material=rm.MaterialId INNER JOIN units u ON u.Unit=rmri.Unit where
                            
                            $result = $db->query($sql);
                            
                            ?>
                            <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                            <th>Material</th>
                            <th>Qty</th>
                            <th>Unit</th>
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
                                    <td><?= $row['Unit'] ?></td>
                                    <td><?= $row['Description'] ?></td>
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
                
                
                
                
                 <!-- /.row -->
                            <div class="row mt-3 mb-5" style="background-color:#95D2B3; color: #ffffff; padding: 10px; border-radius: 8px;height: 50px; display: flex; border: darkgreen"></div>
            </div>
           
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php'; //lay out file in out 2 steps behind
?>

