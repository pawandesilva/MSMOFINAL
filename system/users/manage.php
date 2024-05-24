<?php 
ob_start();
session_start();//session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';

$current_url =$_SERVER['REQUEST_URI'];
if(!checkPermission($current_url,$_SESSION['USERID'])){
    header("Location:../unauthorized.php");
}

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
                <div class="card-tools foat-right "></div>
                <div class="input-group input-group-sm foat-right " style="width: 250px; display:flex; justify-content:flex-end;align-items: center;">
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
          $sql="SELECT * FROM users u INNER JOIN  employee e ON e.UserID=u.UserId LEFT JOIN departments d ON d.id=e.DepartmentId LEFT JOIN designations p ON p.Id=e.DesignationId";
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
                         <th></th>
                         <th></th>
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
                     <td><a href="<?= SYS_URL ?>users/edit.php?userid=<?= $row ['UserId']?>" class=" btn btn-warning"><i class="fas fa-edit"></i>Edit</a></td>
                     <td><a href="<?= SYS_URL ?>users/delete.php?userid=<?= $row ['UserId']?>" onclick="return confirmDelete();" class=" btn btn-danger"><i class="fas fa-trash"></i>Delete</a></td>
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
<script>
    function confirmDelete(){
        return confirm("Are you sure you want to delete this record?");
    }
    </script>