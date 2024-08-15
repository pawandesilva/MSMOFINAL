<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Inventory And Stock Management";
$breadcrumb_item = "Inventory Management";
$breadcrumb_item_active = "Profoma Invoice";
?>


<div class="row">
    <div class="col-12">  
        
        <div class="card">
            <div class="card-header  ">
                <h3 class="card-title font-weight-bold">Display proforma Invoices</h3>

                <div class="card-tools">
                    <div class="input-group input-group-sm" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <?php
                $db= dbConn();
                $sql= "SELECT ProformaId,FirstName,LastName,PoName,Date FROM `profoma_invoices`  INNER JOIN msmo.suppliers ON profoma_invoices.SupplierId = suppliers.SupplierId  ORDER BY profoma_invoices.Date" ;
                $result= $db->query($sql);
                
                ?>
                <table class="table table-hover text-nowrap table-head-fixed">
                    <thead>
                        <tr>
                            <th>Proforma ID</th>
                            <th>Supplier Name</th>
                            <th>Purchasing Order</th>
                            <th>Date</th>
                            

                            
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if($result->num_rows >0){
                            while($row= $result->fetch_assoc()){
                                ?>
                        <tr>
                            <td><?= $row['ProformaId']?></td>
                            <td><?= $row['FirstName']?>  <?= $row['LastName']?></td>
                            <td><?= $row['PoName']?></td>
                            <td><?= $row['Date']?></td>
                            
                            
                            
                            
                            
                            
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                    
                </table>
            </div>
            <!--card body-->
        </div>
        <!--card-->
    </div>
</div>
        
<?php
$content = ob_get_clean();
include '../layouts.php'; //lay out file in out 2 steps behind
?>