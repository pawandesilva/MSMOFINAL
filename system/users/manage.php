<?php 
ob_start();
session_start();//session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "User Management";
$breadcrumb_item = "User";
$breadcrumb_item_active = "Manage";
?>
<div class="row">
    <div class=" col-12">
        <a href="<?= SYS_URL ?>users/add.php" class="btn btn-success mb-2"><i class="fas fa-plus-circle"></i>New</a>
        <div class="card">
            <div class="card-header border-success">
                <h3 class="card-title text-bold">User Details</h3><br>
                <div class="card-tools foat-right float-right"></div>
                <div class="input-group input-group-sm foat-right " style="width: 250px;">
                    <input type="text" name="table_search" class="form-control float-right " placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
            </div>
        </div>
        <!-- card header -->
         <div class="card-body table-responsive p-0" style="height: 300px;">
          <?php
          $db = dbConn();
          $sql="SELECT * FROM users u INNER JOIN  employee e ON e.UserID=u.UserID LEFT JOIN departments d ON d.id=e.DepartmentId LEFT JOIN designations p ON p.Id=e.DesignationId";
          $result = $db->query($sql);
          ?>
             <table class= "table table-head-fixed text-nowrap">
                 <thead>
                     <tr>
                         <th>ID</th>
                         <th>First Name</th>
                         <th>Last Name</th>
                         <th>App.Date</th>
                         <th>Designation</th>
                         <th>Department</th>
                     </tr>
                 </thead>
             <tbody>
                 <?php
                 if($result->num_rows>0){
                     while($row=$result->fetch_assoc()){
                         ?>
                 <tr>
                     <td><?= $row['UserID'] ?></td>
                     <td><?= $row['FirstName'] ?></td>
                     <td><?= $row['LastName'] ?></td>
                     <td><?= $row['AppDate'] ?></td>
                     <td><?= $row['DesignationId'] ?></td>
                     <td><?= $row['DepartmentId'] ?></td>
                 </tr>
                 <?php
                     }
                 }
                 ?>
                 
                     
                 </tbody>
             </table>
         </div>
    </div>
          
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';//lay out file in out 2 steps behind
?>