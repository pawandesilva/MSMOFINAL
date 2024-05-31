<?php
ob_start();
include 'header.php';
include '../functions.php'; //one upon the web file the function file exist
?>


 <div class="container-fluid contact py-5">
        <div class="container py-5">
            <div class="p-5 bg-light rounded">
                <div class="row g-4">
                    <div class="col-12">
                        <div class="text-center mx-auto mt-4" style="max-width: 700px;">
                            <h1 class="text-primary">Registration</h1>
                            <hr class="col-6 offset-md-3 mb-4 ">
                            
                            
                            <!-- Buttons for Supplier and Customer Registration -->
                            <div class="d-flex justify-content-center mt-4 ">
                                
                                <a href="register.php" class="w-100 btn form-control border-secondary py-3 bg-white text-danger ml-3 mr-3 "><i class="fa-solid fa-image-portrait fa-beat fa-2x" style="color: #ba2626;"></i><br><span class="btn-large">Customer Registration</span></a>
                                
                                
                                <a href="supplier_registration.php"  class="w-100 btn form-control border-secondary py-3 bg-white text-primary  font-weight-bold ml-3 "><i class="fas fa-solid fa-people-carry-box fa-beat fa-2x" style="color: #15b22f; "></i><br><span class="btn-large"> Supplier Registration</span></a>
                               
                            </div>
                            <img class="img-fluid" src="assets/img/pepernoten-dessert-still-life-view_23-2149766644.jpg"  alt=""/>
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

