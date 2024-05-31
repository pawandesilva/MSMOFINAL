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
                    <div class="text-center mx-auto mt-4" style="max-width: 700px; color: #935116">
                        <h1 class="text-center  " style="color: #935116">Supplier Registration</h1>
                        <hr class="col-6 offset-md-3 mb-4 ">
                    </div>
                </div>

                <div class="col-lg-12">
                    <?php
                    if ($_SERVER['REQUEST_METHOD'] == 'POST') { //to check data submit in the POST method
                        extract($_POST);
                        $first_name = dataClean($first_name);
                        $last_name = dataClean($last_name);
                        $company_name = dataClean($company_name);
                        $address_line1 = dataClean($address_line1);
                        $address_line2 = dataClean($address_line2);
                        $address_line3 = dataClean($address_line3);
                        $area_of_expertise = dataClean($area_of_expertise);
                        $certifications_qualifications = dataClean($certifications_qualifications);
                        $additional_info = dataClean($additional_info);

                        //required validation-----------------------------------------
                        if (empty($first_name)) {
                            $message['first_name'] = "The first name should not be blank..!";
                        }
                        if (empty($last_name)) {
                            $message['last_name'] = "The last name should not be blank..!";
                        }
                        if (empty($company_name)) {
                            $message['company_name'] = "The company name should not be blank..!";
                        }
                        if (empty($business_type)) {
                            $message['business_type'] = "Business Type is required..!";
                        }
                        if (empty($area_of_expertise)) {
                            $message['area_of_expertise'] = "Area of expertise  is required..!";
                        
                        
                            
                        }if (empty($reg_date)) {
                            $message['reg_date'] = "Date  is required..!";
                            
                        }
                        if (empty($user_name)) {
                            $message['user_name'] = "User name is required..!";
                        }
                        if (empty($password)) {
                            $message['password'] = "Password is required..!";
                        }


                        //Advanced validation----------------------------------------------------

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
                        if (!empty($user_name)) {
                            $db = dbConn();
                            $sql = "SELECT * FROM users WHERE UserName='$user_name'";
                            $result = $db->query($sql);

                            if ($result->num_rows > 0) {
                                $message['user_name'] = "User Name already exists..!";
                            }
                        }

                        //validate password strength----------------------

                        if (!empty($password)) {
                            $uppercase = preg_match('@[A-Z]@', $password);
                            $lowercase = preg_match('@[a-z]@', $password);
                            $number = preg_match('@[0-9]@', $password);
                            $specialChars = preg_match('@[^\w]@', $password);

                            if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                                $message['password'] = 'Password should be at least 8 characters in length and should include at least one uppercase letter, one lowercase letter, one number, and one special character.';
                            }
                        }

                        if (empty($message)) {
                            //use bcrypt hashing algorithm
                            $pw = password_hash($password, PASSWORD_DEFAULT);
                            $db = dbConn();
                            $sql = "INSERT INTO users(UserName,Password,UserType) VALUES('$user_name','$pw','supplier')"; //supplier login with supplier register form                            $db->query($sql);
                            $user_id = $db->insert_id;

                            //generate registrationno
                            $reg_number =   date('Y') . date('m') . date('d') . $user_id;
                            $_SESSION['RNO'] = $reg_number;
                            echo $sql = "INSERT INTO `suppliers`( `FirstName`, `LastName`, `CompanyName`, `Email`, `AddressLine1`, `AddressLine2`, `AddressLine3`, `TelNo`, `MobileNo`, `BusinessType`, `DistrictId`, `AreaOfExpertise`, `CertificationsQualifications`, `AdditionalInformation`, `RegDate`, `RegNo`, `UserId`)"
                                    . " VALUES ('$first_name','$last_name','$company_name','$email','$address_line1','$address_line2','$address_line3','$telno','$mobile_no','$business_type','$district','$area_of_expertise','$certifications_qualifications','$additional_info','$reg_date','$reg_number','$user_id')";
                            $db->query($sql);
                            $msg = "<h1>SUCCESS</h1>";
                            $msg = "<h1>Congratulations!!</h1>";
                            $msg = "<p>Your account has been successfully created.</p>";

                            header("location:register_success.php");
                        }
                    }
                    ?>
                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form" class="php-email-form" novalidate>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="first_name">First Name</label>
                                <input type="text" name="first_name" class="form-control border border-1 border-dark" id="first_name" value="<?= @$first_name ?>" placeholder="First Name" required>
                                <span class="text-danger"><?= @$message['first_name'] ?></span>
                            </div>
                            <div class="form-group col-md-6 mt-3 mt-md-0">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control border border-1 border-dark" name="last_name" id="last_name" placeholder="Last Name" required>
                                <span class="text-danger"><?= @$message['last_name'] ?></span>
                            </div>
                        </div>
                        <div class="form-group col-md-6 mt-3 ">
                            <label for="first_name">Company Name</label>
                            <input type="text" name="company_name" class="form-control border border-1 border-dark" id="company_name" value="<?= @$company_name ?>" placeholder="company Name" required>
                            <span class="text-danger"><?= @$message['company_name'] ?></span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="email">Email</label>
                            <input type="text" class="form-control border border-1 border-dark" name="email" id="email" placeholder="Email" required>
                            <span class="text-danger"><?= @$message['email'] ?></span>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4 mt-3">
                                <label for="address_line1">Address Line 1</label>
                                <input type="text" class="form-control border border-1 border-dark" name="address_line1" id="address_line1" placeholder="Address Line 1" required>
                            </div>
                            <div class="form-group col-md-4 mt-3">
                                <label for="address_line2">Address Line 2</label>
                                <input type="text" class="form-control border border-1 border-dark" name="address_line2" id="address_line2" placeholder="Address Line 2" required>
                            </div>
                            <div class="form-group col-md-4 mt-3">
                                <label for="address_line3">Address Line 3</label>
                                <input type="text" class="form-control border border-1 border-dark" name="address_line3" id="address_line3" placeholder="Address Line 3" required>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="telno">Tel. No.(Home)</label>
                            <input type="text" class="form-control border border-1 border-dark" name="telno" id="telno" placeholder="Tel. No." required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="telno">Mobile No.</label>
                            <input type="text" class="form-control border border-1 border-dark" name="mobile_no" id="mobile_no" placeholder="Mobile No" required>
                        </div>
                        <div class="row">
                        <div class="form-group mt-3 col-md-6">
                            <label>Business Type</label>
                            <div class="form-check">
                                <input class="form-check-input border border-1 border-dark" type="radio" name="business_type" id="material"  value="material">
                                <label class="form-check-label" for="product">
                                    Material Supplier
                                </label>
                                
                                
                            </div>
                            <div class="form-check">
                                <input class="form-check-input border border-1 border-dark" type="radio" name="business_type" id="service" value="service" >
                                <label class="form-check-label" for="service">
                                    Service Supplier
                                </label>
                            </div>
                            <div class="text-danger mt-4"><?= @$message['business_type'] ?></div>
                            </div>
                            
                        
                        </div> 
                        <div class="form-group mt-3">
                            <?php
                            $db = dbConn();
                            $sql = "SELECT * FROM  districts";
                            $result = $db->query($sql);
                            ?>
                            <label for="telno">District</label>
                            <select name="district" id="district"  class="form-select form-select-lg mb-3 border border-1 border-dark" aria-label="Large select example">
                                <option value="" >--</option>
                                <?php
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <option value="<?= $row['Id'] ?>"><?= $row['Name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group mt-3">
                            <label for="area_of_expertise">Area of Expertise(Organic farming,Bulk Material,packaging materials etc.)</label>
                            <input type="text" class="form-control border border-1 border-dark" name="area_of_expertise" id="area_of_expertise" placeholder="Area of Expertise" required>
                        </div>



                        <div class="form-group mt-3">
                            <label for="certifications_qualifications">Certifications/Qualifications</label>
                            <input type="text" class="form-control border border-1 border-dark" name="certifications_qualifications" id="certifications_qualifications" placeholder="Certifications/Qualifications" required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="additional_info">Additional Information</label>
                            <textarea class="form-control border border-1 border-dark" name="additional_info" id="additional_info" rows="3" placeholder="Additional Information"></textarea>
                        </div>
                        <div class="form-group col-md-4 mt-3">
                                <label for="last_name">Register Date</label>
                                <input type="date" class="form-control border border-1 border-dark" name="reg_date" id="reg_date" placeholder="Register Date" required>
                                <span class="text-danger"><?= @$message['reg_date'] ?></span>
                            </div>
                        <div class="form-group mt-3">
                            <label for="user_name">User Name</label>
                            <input type="text" class="form-control border border-1 border-dark" name="user_name" id="user_name" placeholder="Username" required>
                            <span class="text-danger"><?= @$message['user_name'] ?></span>
                        </div>
                        <div class="form-group mt-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control border border-1 border-dark" name="password" id="password" placeholder="Password" required>
                            <span class="text-danger"><?= @$message['password'] ?></span>
                        </div>
                        <!--<div class="form-group mt-3">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" class="form-control border border-1 border-dark" name="confirm_password" id="confirm_password" placeholder="Retype Password" required>
                            <span class="text-danger"><?= @$message['confirm_password'] ?></span>
                        </div>-->

                        <div class="my-3">
                            <div class="loading">Loading</div>
                            <div class="error-message"></div>
                            <div class="sent-message">Your message has been sent. Thank you!</div>
                        </div>
                        <div class="text-center"><button type="submit" class="w-100 btn form-control border-secondary py-3 bg-white text-primary">Submit</button></div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>




<?php
include 'footer.php';
ob_end_flush();
?>