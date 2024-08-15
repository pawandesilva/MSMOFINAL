<?php
ob_start();
include_once '../init.php';
$link = "Dashboard";
$breadcrumb_item = "Reports";
$breadcrumb_item_active = "Chart";
?>   


<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">

            <!-- /.col (LEFT) -->
            <div class="col-md-6">
                <!-- LINE CHART -->
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title"><strong>Percentage of Raw Material Amount In Stock</strong></h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart">
                            <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->



            </div>
            <!-- /.col (RIGHT) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->


<?php
$content = ob_get_clean();
include '../layouts.php';
?>
<?php
$db = dbConn();
$sql = "SELECT rm.MaterialName as Material, SUM(rms.Amount) as TotalAmount FROM raw_materials rm INNER JOIN raw_material_stock rms ON rms.MaterialId=rm.MaterialId GROUP BY rm.MaterialName";
$result = $db->query($sql);

$materials = [];
$amounts = [];

while ($row = $result->fetch_assoc()) {
    $materials[] = $row['Material'];
    $amounts[] = $row['TotalAmount'];
}

// Encode data as JSON
$materials_json = json_encode($materials);
$amounts_json = json_encode($amounts);
?>
<script>
    $(document).ready(function () {
        var pieChartCanvas = $('#pieChart').get(0).getContext('2d');
        var materials = <?php echo $materials_json; ?>;
        var amounts = <?php echo $amounts_json; ?>;

        function getRandomColor() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return 'rgba(' + r + ',' + g + ',' + b + ',0.9)';
        }

        // Generate dynamic colors for each segment
        var pieColors = amounts.map(() => getRandomColor());

        var pieChartData = {
            labels: materials,
            datasets: [
                {
                    label: 'Material Amount',
                    backgroundColor: pieColors, // Array of dynamically generated colors
                    borderColor: 'rgba(255,255,255,1)', // White border color
                    data: amounts
                }
            ]
        };

        var pieChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: true
            }
        };

        // Create the chart
        new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieChartData,
            options: pieChartOptions
        });
    });
</script>