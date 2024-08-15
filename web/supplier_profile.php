<?php
ob_start();
include 'supplier_layout.php';
include '../functions.php';
?>

<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto mt-4" style="max-width: 700px; color: #935116">
                        <h2 class="text-center  " style="color: #935116">My Profile</h2>
                        <hr class="col-6 offset-md-3 mb-4 ">

                    </div>
                    <div class="container-fluid">
                        <div class="p-5 bg-gradient rounded">
                            <div class="card text-center">
                                <div class="card-header bg-gradient-green">
                                    Featured
                                </div>
                                <div class="card-body">
                                    <div class="container rounded bg-white mt-5 mb-5">

                                        <?php
                                        extract($_GET);
                                        extract($_POST);
                                        
                                            
                                            $db = dbConn();
                                             $sql = "SELECT * FROM suppliers s INNER JOIN users u ON s.UserId=u.UserId WHERE s.SupplierId='$supplierId'";
                                            $result = $db->query($sql);
                                            $row = $result->fetch_assoc();
                                            

                                            $first_name = $row['FirstName'];
                                            $last_name = $row['LastName'];
                                            $company_name = $row['CompanyName'];
                                            $email = $row['Email'];
                                            $address_line1 = $row['AddressLine1'];
                                            $address_line2 = $row['AddressLine2'];
                                            $address_line3 = $row['AddressLine3'];
                                            $telno = $row['TelNo'];
                                            $mobile_no = $row['MobileNo'];
                                            $UserId = $row['UserId'];
                                            $profileImage =$row['ProfileImage'];
                                        
                                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                                            extract($_POST);

                                            $first_name = dataClean($first_name);
                                            $last_name = dataClean($last_name);
                                            $company_name = dataClean($company_name);
                                            $address_line1 = dataClean($address_line1);
                                            $address_line2 = dataClean($address_line2);
                                            $address_line3 = dataClean($address_line3);
                                           
                                            $telno = dataClean($telno);
                                            $mobile_no = dataClean($mobile_no);
                                            $bio = dataClean($bio);
                                            

                                            $message = array();
                                            
                                            /*if(!empty($_FILES['profileImage']['name'])){
                                                $profileImage = $_FILES['profileImage'];//retrieve uploaded file
                                                $uploadResult = uploadFiles($profileImage,$db);
                                                foreach($uploadResult as $key => $value){
                                                    if(@$value['upload']){
                                                        $profileImagePath= $value['file'];//path of the uploaded file
                                                    }else{
                                                        foreach($value as $result){
                                                            echo $result;
                                                        }
                                                    }
                                                }
                                            }*/
                                            
                                            
                                            

                                            //required validation---------------------------------
                                            if (empty($title)) {
                                                $message['title'] = "The Title should not be blank..!";
                                            }
                                            if (empty($first_name)) {
                                                $message['first_name'] = "The first name should not be blank..!";
                                            }
                                            if (empty($last_name)) {
                                                $message['last_name'] = "The last name should not be blank..!";
                                            }
                                            if (empty($company_name)) {
                                                $message['company_name'] = "The company name should not be blank..!";
                                            }
                                            if (empty($address_line1)) {
                                                $message['address_line1'] = "The address should not be blank..!";
                                            }
                                            if (empty($address_line2)) {
                                                $message['address_line2'] = "The address should not be blank..!";
                                            }
                                            if (empty($address_line3)) {
                                                $message['address_line3'] = "The address should not be blank..!";
                                            }
                                            if (empty($telno)) {
                                                $message['telno'] = "The Telephone no should not be blank..!";
                                            }
                                            if (empty($mobile_no)) {
                                                $message['mobile_no'] = "The mobile no should not be blank..!";
                                            }
                                            if (empty($gender)) {
                                                $message['gender'] = "The gender should not be blank..!";
                                            }
                                            if (empty($bio)) {
                                                $message['bio'] = "The bio should not be blank..!";
                                            }

                                            //advanced validations--------------------------------------------
                                            if (ctype_alpha(str_replace(' ', '', $first_name)) === false) {
                                                $message['first_name'] = "Only letters and spaces are allowed..!";
                                            }
                                            if (ctype_alpha(str_replace(' ', '', $last_name)) === false) {
                                                $message['last_name'] = "Only letters and spaces are allowed..!";
                                            }
                                            if (ctype_alpha(str_replace(' ', '', $company_name)) === false) {
                                                $message['company_name'] = "Only letters and spaces are allowed..!";
                                            }
                                            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                                                $message['email'] = "Invalid Email address..!";
                                            } else { //to check any other emails exists in the db
                                                $db = dbConn();
                                                $sql = "SELECT * FROM suppliers WHERE Email ='$email'";
                                                $result = $db->query($sql);

                                                if ($result->num_rows > 0) {
                                                    $message['email'] = "This Email already exists..!";
                                                }
                                            }
                                            if(empty($message)){
                                                $db= dbConn();
                                                echo $sql = "INSERT INTO suppliers ('Title','Bio','Gender','ProfileImage') Values ('$title','$bio','$gender','$profileImage')";
                                                $db->query($sql);
                                            }
                                            //profile image upload
                                            if(!empty($_FILES['profileImage']['name']) && empty($message)) {
                                                $file = $_FILES['profileImage'];
                                                $location ="uploads";
                                                $uploadResult = uploadFiles($file,$location);
                                                $prv_profileImage = isset($profileImage) ? $profileImage : '';
                                                if($uploadResult['upload']){
                                                    //delete the privious profile image if exists
                                                    if(!empty($prv_profileImage)&& file_exists($location . '/' . $prv_profileImage)){
                                                        unlink($location. '/' . $prv_profileImage);
                                                    }
                                                    $profileImage = $uploadResult['file'];
                                                
                                            }else{
                                                $error = $uploadResult['error_file'];
                                                $message['profileImage']="<br>Image upload failed : $error";
                                            }
                                            }else {
                                                $profileImage = $prv_profileImage;
                                            }
                                                
                                            

                                            if (empty($message)) {
                                                $db = dbConn();
                                                //update statement
                                                 $sql = "UPDATE users SET  FirstName='$FirstName', LastName='$LastName' WHERE UserId='$UserId'";

                                                $db->query($sql);

                                                $sql = "UPDATE suppliers SET FirstName='$first_name',LastName='$last_name',CompanyName='$company_name',Email='$email',AddressLine1='$address_line1',AddressLine2='$address_line2',AddressLine3='$address_line3',TelNo='$telno',MobileNo='$mobile_no',ProfileImage='$profileImage'
                   WHERE UserID='$Userid'";

                                                $db->query($sql);

                                                header("Location: supplier_dashboard.php");
                                            }
                                            
                                            
                                        }
                                        
                                        ?>

                                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data" role="form"  class="" novalidate>
                                            <div class="row">
                                               

                                                <div class="col-md-3 border-right">
                                                    <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                                                        <!-- default Image -->
                                                        <img src="<?= !empty($prv_profileImage) ? '../uploads' . $profileImage : '../uploads/66758c0502f915.11718671.jpg';?>" id="profilephoto" class="rounded-circle mt-5" width="150px" src='$pr' alt="Profile Image"> 
                                                        <input type="hidden" value="<?= $profileImage;?>" name="prv_profileImage">
                                                        
                                                       
                                                        <!-- Image upload button-->
                                                        
                                                        <label for="profileImage">Upload Image</label><br>
                                                        <input type="file" id="profileImage" name="profileImage[]" accept="image/*" class="form-control mt-3">
                                                        
                                                        <span class="error_span text-danger"><?= @$message['profileImage']?></span>

                                                        <span class="font-weight-bold "><strong><?= $row['FirstName'].' '.$row['LastName']?></strong></span>
                                                        <span class="text-black-50"><?=   $row['Email'] ?></span>
                                                        <span></span>

                                                    </div>


                                                </div>
                                                <div class="col-md-1 border-right"></div> <!-- Line separator -->
                                                <div class="col-md-8">
                                                    <div class="p-3 py-5">
                                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                                            <h4 class="text-center">Profile Settings</h4>
                                                        </div>

                                                        <div class="row mt-2">
                                                            <div>
                                                                <label for="title">Title: </label>
                                                                <select class="form-select form-select-sm mb-3 border border-1" id="title" name="title">
                                                                    <option value="--">--</option>
                                                                    <option value="mr"  <?php if (isset($title) && $title == 'mr') echo 'selected'; ?>>Mr</option>
                                                                    <option value="miss"<?php if (isset($title) && $title == 'miss') echo 'selected'; ?>>Miss</option>
                                                                    <option value="mrs"<?php if (isset($title) && $title == 'mrs') echo 'selected'; ?>>Mrs</option>

                                                                </select>
                                                                <div class="text-danger mt-4"><?= @$message['title'] ?></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="labels" for="first_name">First Name</label>
                                                                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="first name" value="<?= $row['FirstName'] ?>">
                                                                <span class="text-danger"><?= @$message['first_name'] ?></span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="labels" for="last_name">Last Name</label>
                                                                <input type="text" class="form-control" id="last_name " name="last_name" value="<?= $row['LastName'] ?>" placeholder="last name">
                                                                <span class="text-danger"><?= @$message['last_name'] ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">
                                                            <div class="col-md-6">
                                                                <label class="labels" for="company_name">Company Name</label>
                                                                <input type="text" class="form-control" id="company_name" name="company_name" placeholder="company name" value="<?= $row['CompanyName'] ?>">
                                                                <span class="text-danger"><?= @$message['company_name'] ?></span>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="labels" for="email">Email</label>
                                                                <input type="text" class="form-control" id="email" name="ëmail" placeholder=" email " value="<?= $row['Email'] ?>">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group col-md-4 mt-3">
                                                                <label class="labels" for="address_line1">Address Line 1</label>
                                                                <input type="text" class="form-control border border-1" name="address_line1" id="address_line1" placeholder="Address Line 1" value="<?= $row['AddressLine1'] ?>" required>
                                                                <span class="text-danger"><?= @$message['address_line1'] ?></span>
                                                            </div>
                                                            <div class="form-group col-md-4 mt-3">
                                                                <label class="labels" for="address_line2">Address Line 2</label>
                                                                <input type="text" class="form-control border border-1 " name="address_line2" id="address_line2" placeholder="Address Line 2" value="<?= $row['AddressLine2'] ?>" required>
                                                                <span class="text-danger"><?= @$message['address_line2'] ?></span>
                                                            </div>
                                                            <div class="form-group col-md-4 mt-3">
                                                                <label class="labels" for="address_line3">Address Line 3</label>
                                                                <input type="text" class="form-control border border-1 " name="address_line3" id="address_line3" placeholder="Address Line 3" value="<?= $row['AddressLine2'] ?>" required>
                                                                <span class="text-danger"><?= @$message['address_line3'] ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="row mt-3">

                                                            <div class="form-group col-md-6 mt-3">
                                                                <label for="telno">Tel. No.(Home)</label>
                                                                <input type="text" class="form-control border border-1 " name="telno" id="telno" placeholder="Tel. No." value="<?= $row['TelNo'] ?>" required>
                                                                <span class="text-danger"><?= @$message['telno'] ?></span>
                                                            </div>
                                                            <div class="form-group col-md-6 mt-3">
                                                                <label for="telno">Mobile No.</label>
                                                                <input type="text" class="form-control border border-1 " name="mobile_no" id="mobile_no" placeholder="Mobile No" value="<?= $row['MobileNo'] ?>" required>
                                                                <span class="text-danger"><?= @$message['mobile_no'] ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="form-group mt-3 col-md-6 ">
                                                                <label>Gender</label>
                                                                <div class="form-check">
                                                                    <input class="form-check-input border border-1 border-dark" type="radio" name="gender" id="male"  value="male">
                                                                    <label class="form-check-label" for="product">
                                                                        Male
                                                                    </label>


                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input border border-1 border-dark" type="radio" name="gender" id="female" value="female" >
                                                                    <label class="form-check-label" for="service">
                                                                        Female
                                                                    </label>
                                                                </div>
                                                                <div class="text-danger mt-4"><?= @$message['gender'] ?></div>
                                                            </div>


                                                        </div>
                                                        <div class="form-group mt-3">
                                                            <label for="additional_info">Add Bio</label>
                                                            <textarea class="form-control border border-1 " name="bio" id="bio" rows="3" placeholder="bio"></textarea>
                                                            <span class="text-danger"><?= @$message['bio'] ?></span>
                                                        </div>
                                                        <div class="mt-5 text-center">
                                                            <input type='text' name='supplierId' value="<?= $supplierId ?>">
                                                            <div class="text-center"><button type="submit" class="w-100 btn form-control border-secondary py-3 bg-white text-primary">Update Profile</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    </form> 
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
