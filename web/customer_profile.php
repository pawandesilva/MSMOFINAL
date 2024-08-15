<?php
ob_start();
include 'customer_dashboard.php';
include '../functions.php';
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
                                    
                                    <div class="col-md-3 border-right " >
                                                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                                                        <img id="profilephoto" class="rounded-circle mt-5" width="150px" src="https://st3.depositphotos.com/15648834/17930/v/600/depositphotos_179308454-stock-illustration-unknown-person-silhouette-glasses-profile.jpg" alt="Profile Image"> 
                                                    </div>
                                        
                                </div>
                                
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include 'footer.php';
ob_end_flush();
?>