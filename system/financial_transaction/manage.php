
<?php 
ob_start();
session_start();//session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Financial Transaction";
$breadcrumb_item = "Financial Transaction";
$breadcrumb_item_active = "manage";
?>
<div class="tab-content" id="purchasing_order">
    <!-- Create Order Tab -->
    <div class="row">
        
        <div class="col-12">
            <div>
                <div class="col-lg-3 col-6">
            <!-- small card -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>53<sup style="font-size: 20px">%</sup></h3>

                <p>Profoma Invoices</p>
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
            </div>
            <a href="<?= SYS_URL?>inventory/add_stock.php" class="btn btn-success mb-2"><i class="fas fa-plus-circle"></i> New</a><!-- comment -->
            <form class="mt-3 " action="<?= htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <input type="date" name="from_date">
                <input type="date" name="to_date"><!-- comment -->
                <button class="rounded-3" type="submit" >search</button>
            </form>
            <div class="card">
            <div class="card-header">
                <h3 class="card-title"><strong>Stock Details</strong></h3>

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
                    
                    $where="WHERE item_stock.purchase_date BETWEEN '$from_date' AND '$to_date'";
                    
                }
                $db = dbConn();
                $sql = "SELECT item_stock.qty,item_stock.unit_price,item_stock.purchase_date,suppliers.FirstName,items.item_name,item_category.category_name,units.Unit FROM"
                        . " item_stock INNER JOIN suppliers ON item_stock.supplier_id=suppliers.SupplierId INNER JOIN items ON item_stock.item_id=items.id INNER JOIN item_category ON item_category.id=items.item_category INNER JOIN units ON item_stock.UnitId=units.UnitId $where" ;
                $result=$db->query($sql);
                ?>
                
                <table class="table table-hover text-nowrap " id="myTable">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Unit Price</th>
                            <th>Qty</th>
                            <th>Unit</th>
                            <th>Purchase Date</th>
                            <th>Supplier</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        if($result->num_rows > 0 ){
                            while($row = $result->fetch_assoc()){
                                ?>
                           
                        <tr>
                    <td><?= $row['item_name']?></td>
                    <td><?= $row['category_name']?></td>
                    <td><?= $row['unit_price']?></td>
                    <td><?= $row['qty']?></td>
                    <td><?= $row['Unit']?></td>
                    
                    <td><?= $row['purchase_date']?></td>
                    <td><?= $row['FirstName']?></td>
                    
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

<?php
$content = ob_get_clean();
include '../layouts.php';//lay out file in out 2 steps behind
?>