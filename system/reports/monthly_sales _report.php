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
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Bar Chart</h3>

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
                            <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas><!-- drawing the chart using canvas tag -->
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
$sql = "
SELECT DATE_FORMAT(purchase_date, '%M') AS Month, SUM(qty) AS TotalQuantity, SUM(issued_qty) AS TotalIssuedQuantity, SUM(issued_qty * unit_price) AS TotalSales FROM item_stock GROUP BY DATE_FORMAT(purchase_date, '%M') ORDER BY Month";
$result = $db->query($sql);

$months = [];
$amounts = [];

while ($row = $result->fetch_assoc()) {
    $months[] = $row['Month']; //fill as arrays
    $amounts[] = $row['TotalSales'];
}

// Encode data as JSON
$months_json = json_encode($months); //make php variable to java script varible 
$amounts_json = json_encode($amounts);
?>
<script>
    $(document).ready(function () {//after document load
        var barChartCanvas = $('#barChart').get(0).getContext('2d');//read barchart element and make 2d chart
        var months = <?php echo $months_json; ?>;//assing arryas
        var amounts = <?php echo $amounts_json; ?>;

        var barChartData = {//design data to be displayed
            labels: months,
            datasets: [
                {
                    label: 'Material Qty',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: amounts,
                    fill: false  // Ensure the area under the line is not filled
                }
            ]
        };

        var barChartOptions = {
            maintainAspectRatio: false, //size to hieght
            responsive: true,
            legend: {
                display: true
            },
            scales: {
                xAxes: [{
                        gridLines: {
                            display: true,
                        }
                    }],
                yAxes: [{
                        gridLines: {
                            display: true,
                        }
                    }]
            }
        };

        // Create the chart
        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        });
    });
</script>