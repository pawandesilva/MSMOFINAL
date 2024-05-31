<?php
ob_start();
include 'header.php';
include '../functions.php';
?>
<div class="container-fluid contact py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="row g-4">
                <div class="col-12">
                    <div class="text-center mx-auto" style="max-width: 700px;">
                        <h1 class="text-center mt-5 " style="color: #935116">MSMO</h1>
                        <h1 class="text-primary">Login</h1>
                        <p class="mb-4">The contact form is currently inactive. Get a functional and working contact form with Ajax & PHP in a few minutes. Just copy and paste the files, add a little code and you're done. <a href="https://htmlcodex.com/contact-form">Download Now</a>.</p>
                    </div>
                </div>
                <?php
                if($_SERVER['REQUEST_METHOD'] == 'POST'){
                    extract($_POST);
                    
                    $username = dataClean($username);
                    $message= array();
                    
                    if(empty($username)){
                        $message['username'] = "User Name should not be empty..!";
                        
                    }
                    if(empty($password)){
                        $message['password'] = "Password should not be empty..!";
                        
                    }
                    if(empty($message)){
                        $db = dbConn();
                        $sql = "SELECT * FROM users u INNER JOIN customers c ON c.UserId=u.UserId WHERE u.UserName='$username'";
                        $result= $db->query($sql);
                        
                        if($result->num_rows==1){
                            $row = $result->fetch_assoc();
                            
                            if(password_verify($password, $row['Password'])){
                                $_SESSION['USERID'] = $row['UserId'];
                                $_SESSION['FIRSTNAME']= $row['FirstName'];
                                
                                header("Location:dashboard.php");
                            }else{
                                $message['password'] = 'Invalid username or password..!';
                                
                            } 
                        }else{
                                $message['password']= 'Invalid username or password..!';
                            }
                        }
                    
                }
                ?>
                <div class="row">
                    <div class="col-lg-6">
                        <img class="img-fluid col-9 rounded-3 "src="assets/img/background-spices-photo-collage-pepper-spices-top-view-black-background_187166-20603.jpg" alt=""/>
                    </div>
                    <div class="col-lg-6 align-content-center   "   >

                        <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" role="form">
                            <div>
                                <input type="text" class="w-100 form-control border-0 py-3 mb-4 " name="username" id="username" placeholder="User Name" required>
                                <div>

                                    <div>
                                        <input type="password" class="w-100 form-control border-0 py-3 mb-4 " name="password" id="password" placeholder="Password" required>
                                        <div>
                                            <button class="w-100 btn form-control border-secondary py-3 bg-white text-primary " type="submit">Login</button>
                                            </form>
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