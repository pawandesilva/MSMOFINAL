<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Inventory And Stock Management";
$breadcrumb_item = "manage";
$breadcrumb_item_active = "product";
?>
<div class="tab-content" id="product">
    <!-- Create production Tab -->
    <div class="row">
        
        <div class="col-12">
            <div class="row">
                <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p><strong>Proforma Invoices</strong></p>
              </div>
              <div class="icon">
                <i class="fas fa-list-ul"></i>
              </div>
              <a href="profoma_invoices.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p><strong>New Material Requests</strong></p>
              </div>
              <div class="icon">
                <i class="fas fa-shopping-cart"></i>
              </div>
              <a href="profoma_invoices.php" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
          <!-- ./col -->
            </div>
            
            <a href="<?= SYS_URL?>inventory/add_stock.php" class="btn btn-success mb-2"><i class="fas fa-plus-circle"></i> New</a><!-- comment -->
            <form class="mt-3 " action="<?= htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <input type="date" name="from_date">
                <input type="date" name="to_date"><!-- comment -->
                <button class="rounded-3" type="submit" >search</button>
            </form>
            <div class="card">
            <div class="card-header">
                <h3 class="card-title"><strong>Product Details</strong></h3>

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
                $where=null;
                if($_SERVER['REQUEST_METHOD']=='POST'){
                    extract($_POST);
                    
                    //$where="WHERE item_stock.purchase_date BETWEEN '$from_date' AND '$to_date'";
                    
                }
                $db = dbConn();
                $sql="SELECT * FROM items";
                $result=$db->query($sql);
                ?>
                
                <table class="table table-hover text-nowrap " id="myTable">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Item Name</th>
                          
                            <th>Item Image</th>
                            
                            <th>Item Category</th>
                            <th>Status</th>
                            
                            <th>Description</th>
                            <th>Unit Price</th>
                            <th>Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($result->num_rows > 0 ){
                            while($row = $result->fetch_assoc()){
                                ?>
                           
                        <tr>
                    <td><?= $row['id']?></td>
                    <td><?= $row['item_name']?></td>
                    <td><?= $row['item_image']?></td>
                    <td><?= $row['item_category']?></td>
                    <td><?= $row['status']?></td>
                    
                    <td><?= $row['description']?></td>
                    <td><?= $row['unit_price']?></td>
                    <td><?= $row['qty']?></td>
                    <td></td>
                    
                        </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <div id="pagination" class="d-flex justify-content-center"></div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php'; //lay out file in out 2 steps behind
?>


