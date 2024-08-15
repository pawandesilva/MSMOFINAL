<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Customer Management";
$breadcrumb_item = "Customer Management";
$breadcrumb_item_active = "reports";
?>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            
            <!-- /.col (LEFT) -->
            <div class="col-md-10">
                <!-- LINE CHART -->
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Total No of Customers from each District</h3>

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
$sql = "SELECT d.Name as District, COUNT(c.CustomerId) as TotalCustomers FROM districts d INNER JOIN customers c ON c.DistrictId = d.Id GROUP BY d.Name";
$result = $db->query($sql);

$districts = [];
$customers = [];

while ($row = $result->fetch_assoc()) {
    $districts[] = $row['District'];//fill as arrays
    $customers[] = $row['TotalCustomers'];
}

// Encode data as JSON
$districts_json = json_encode($districts);//make php variable to java script varible 
$customers_json = json_encode($customers);
?>
<script>
    $(document).ready(function () {//after document load
        var barChartCanvas = $('#barChart').get(0).getContext('2d');//read barchart element and make 2d chart
        var districts = <?php echo $districts_json; ?>;//assing arryas
        var customers = <?php echo $customers_json; ?>;

        var barChartData = {//design data to be displayed
            labels: districts,
            datasets: [
                {
                    label: 'No of customers',
                    backgroundColor: '#feb236',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#feb236',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: '#feb236',
                    data: customers,
                    fill: false  // Ensure the area under the line is not filled
                }
            ]
        };

        var barChartOptions = {
            maintainAspectRatio: false,//size to hieght
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
