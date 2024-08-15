<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Customer Management";
$breadcrumb_item = "Customer Management";
$breadcrumb_item_active = "contacts";
?>
<!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body pb-0">
          <div class="row">
            <?php
            $db = dbConn();
            $sql = "SELECT * FROM customers";
            $result = $db->query($sql);

            while ($row = $result->fetch_assoc()) {
                ?>
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                    <div class="card bg-light d-flex flex-fill">
                        <div class="card-header text-muted border-bottom-0">
                            
                        </div>
                        <div class="card-body pt-0">
                            <div class="row">
                                <div class="col-7">
                                    
                                    <h2  class="lead text-center  text-capitalize mb-3" style="color:#1B6B93 "><i class="fas fa-lg fa-user-tag  "> </i><b><strong class=""><?= $row['FirstName'].' '.$row['LastName'] ?></strong></b></h2>
                                    <div class="mb-4"><b>Reg No:<strong class="text-danger"> <?=  $row['RegNo']  ?></strong></b></div>
                                    
                                    <ul class="ml-4 mb-0 fa-ul text-muted">
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-building"></i></span><b>Address:</b> <?= $row['AddressLine1'] . ', ' . $row['AddressLine2'] . ', ' . $row['AddressLine3'] ?></li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-mobile"></i></span><b>Mobile No :</b><?= $row['MobileNo'] ?></li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-phone"></i></span><b>Tel No :</b><?= $row['TelNo'] ?></li>
                                        <li class="small"><span class="fa-li"><i class="fas fa-lg fa-envelope"></i></span><b>Email :</b> <?= $row['Email'] ?></li>
                                    </ul>
                                </div>
                                <div class="col-5 text-center">
                                    <img src="../../dist/img/user1-128x128.jpg" alt="user-avatar" class="img-circle img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="text-right">
                                <a href="#" class="btn btn-sm bg-teal">
                                    <i class="fas fa-comments"></i>
                                </a>
                                <a href="customer_profile.php?customerId=<?=$row['CustomerId']?> " class="btn btn-sm btn-primary">
                                    <i class="fas fa-user"></i> View Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <nav aria-label="Contacts Page Navigation">
            <ul class="pagination justify-content-center m-0">
              <li class="page-item active"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">4</a></li>
              <li class="page-item"><a class="page-link" href="#">5</a></li>
              <li class="page-item"><a class="page-link" href="#">6</a></li>
              <li class="page-item"><a class="page-link" href="#">7</a></li>
              <li class="page-item"><a class="page-link" href="#">8</a></li>
            </ul>
          </nav>
        </div>
        <!-- /.card-footer -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
<?php
$content = ob_get_clean();
include '../layouts.php'; //lay out file in out 2 steps behind
?>

