<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Supplier Management";
$breadcrumb_item = "Supplier Management";
$breadcrumb_item_active = "manage";
?>
<div class="row">
    <div class="col-12">  
        <div class="card">
            <div class="card-header  ">
                <h3 class="card-title font-weight-bold">Display Suppliers</h3>
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
                $db = dbConn();
                $sql = "SELECT s.SupplierId,s.FirstName,s.LastName,s.RegNo,d.Name,"
                        . "s.ProfileImage From suppliers s INNER JOIN districts d ON d.Id=s.DistrictId";
                $result = $db->query($sql);
                ?>
                <table class="table table-hover text-nowrap table-head-fixed">
                    <thead>
                        <tr>
                            <th>Supplier Id</th>
                            <th>Supplier Name</th>
                            <th>Reg No</th>
                            <th>District</th>
                            <th>Profile Image</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?= $row['SupplierId'] ?></td>
                                    <td><?= $row['FirstName'] ?></td>
                                    <td><?= $row['RegNo'] ?></td>
                                    <td><?= $row['Name'] ?></td>
                                    <td><?= $row['ProfileImage'] ?></td>
                                    <td><a href="<?= SYS_URL ?>suppliers/supplier_profile.php?supplierId=<?= $row['SupplierId'] ?>"
                                           class="btn btn-info"><i class="fas fa-eye"></i>   view</a></td>
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
