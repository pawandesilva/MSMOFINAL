<?php
include '../functions.php';
extract($_GET);
$db = dbConn();
$date = DateTime::createFromFormat('m/d/Y', $date)->format('Y-m-d');
$sql = "SELECT * FROM employee_leaves WHERE leave_date='$date'";
$result = $db->query($sql);


?>
<div class="row">
    <div class="col">
        <table class="table table-hover text-nowrap" id="myTable">
            <thead>
                <tr>
            <a href="showleave.php"></a>
                    <th>ID</th>
                    <th>Date</th>
                    <th>leave_type</th>


                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?= $row['employee_id'] ?></td>
                            <td><?= $row['leave_date'] ?></td>
                            <td><?= $row['leave_type'] ?></td>

                        </tr>

                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
$content = ob_get_clean();
include 'layouts.php';
?>
