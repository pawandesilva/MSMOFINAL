<?php
ob_start();
session_start(); //session_start() creates a session or resumes the current one based on a session identifier passed via a GET or POST request, or passed via a cookie.
include_once '../init.php';
$link = "Supplier Management";
$breadcrumb_item = "Supplier Management";
$breadcrumb_item_active = "Profile";

if (isset($_GET['supplierId'])) {
    $supplierId = $_GET['supplierId'];
} else {
    // Handle the case where supplierId is not set
    die("Supplier ID not provided.");
}
?>

<div class="p-5 bg-light rounded">
    <div class="row g-4">
        <div class="col-12">
            <div class="text-center mx-auto mt-4" style="max-width: 700px; color: #935116">
                <h2 class="text-center" style="color: #78A083"><strong>Supplier Profile</strong></h2>
                <hr class="col-6 offset-md-3 mb-4">
            </div>
            <div class="container-fluid">
                <div class="p-5 bg-gradient rounded">
                    <div class="card text-center">
                        <div class="card-header " style="background-color: #AF8F6F">

                        </div>
                        <div class="card-body">

                            <div class="container rounded bg-white mt-5 mb-5">
                                <div class="row">
                                    <?php
                                    $db = dbConn();
                                    $sql = "SELECT * FROM suppliers INNER JOIN districts ON supplierId=districts.Id WHERE SupplierId='$supplierId'";
                                    $result = $db->query($sql);

                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <div class="col-md-3 border-right">
                                            <h2 class="text-capitalize" style="color: #1B6B93 "><strong><?= $row['FirstName'] ?></strong></h2>
                                            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                                                <img id="profilephoto" class="rounded-circle mt-1" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg" alt="Profile Image">
                                                <p class="text-center "><?= $row['Email'] ?></p>
                                                <p class="text-center bg-light"><?= $row['Bio'] ?></p>
                                            </div>



                                        </div>
                                        <div class="col-md-8">


                                            <div class="align-items-center text-center">

                                                <h3 class="text-center offset-md-5"><strong>Reg No:<strong class="text-danger"><?= $row['RegNo'] ?></strong></h3>
                                                <div class="container-fluid text-center">

                                                    <div class="bg-light text-left mt-5 p-4">
                                                        <div class="row mb-2">
                                                            <div class="col-md-4"><strong>Name</strong></div>
                                                            <div class="col-md-8 text-capitalize">: <?= $row['FirstName'] . ' ' . $row['LastName'] ?></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4"><strong>Company Name</strong></div>
                                                            <div class="col-md-8">: <?= $row['CompanyName'] ?></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4"><strong>Gender</strong></div>
                                                            <div class="col-md-8">: <?= $row['Gender'] ?></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4"><strong>Tel. Number</strong></div>
                                                            <div class="col-md-8">: <?= $row['TelNo'] ?></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4"><strong>Mobile Number</strong></div>
                                                            <div class="col-md-8">: <?= $row['MobileNo'] ?></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4"><strong>District</strong></div>
                                                            <div class="col-md-8">: <?= $row['Name'] ?></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4"><strong>Address</strong></div>
                                                            <div class="col-md-8">:  <?= $row['AddressLine1'] . ', ' . $row['AddressLine2'] . ', ' . $row['AddressLine3'] ?></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4"><strong>Area Of Expertise</strong></div>
                                                            <div class="col-md-8">: <?= $row['AreaOfExpertise'] ?></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4"><strong>Register Date</strong></div>
                                                            <div class="col-md-8">: <?= $row['RegDate'] ?></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4"><strong>Certifications/<br>Qualifications</strong></div>
                                                            <div class="col-md-8">: <?= $row['CertificationsQualifications'] ?></div>
                                                        </div>
                                                        <div class="row mb-2">
                                                            <div class="col-md-4"><strong>Additional Info</strong></div>
                                                            <div class="col-md-8">: <?= $row['AdditionalInformation'] ?></div>
                                                        </div>
                                                    </div>




                                                </div>


                                            </div>



    <?php
}
?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-12">
                            <button type="button" onclick="printContent()" class="btn btn-default"><i class="fas fa-print"></i> Print</button>
                            <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                <i class="fas fa-download"></i> Generate PDF
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





<?php
$content = ob_get_clean();
include '../layouts.php'; //lay out file in out 2 steps behind
?>

    <script>
        //print function
        function printContent() {
            var content = document.getElementById("contentToPrint").innerHTML;
            var originalBody = document.body.innerHTML;
            document.body.innerHTML = content;
            window.print();
            document.body.innerHTML = originalBody;

        }

    </script>
