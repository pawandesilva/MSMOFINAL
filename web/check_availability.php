<?php
ob_start();
include 'header.php';
include '../functions.php';
?>
<main id="main" class="mt-5">
    <div class=" mt-5">
        <img src="assets/img/still-life-with-various-spices.jpg" class="container-fluid mt-5" height="50px" alt=""/>
    </div>
    <!<!-- check availability us section -->
    <section id="check_availability" class="check_availability">
        <div class="container mt-5" data-aos="fade-up">
            <div class="section-title mt-5">
                <h2>Appoinments</h2>
                <p>Availability</p>
            </div>
            <?php
            extract($_POST);
            $db= dbConn();
            $time_duration='01:00:00';
            $sql="SELECT * FROM appoinments WHERE date= '$date' AND ((startTime >='$start_time' AND startTime < ADDTIME('$start_time','$time_duration')) OR (startTime <='$start_time' AND endTime>= ADDTIME('$start_time','$time_duration')))";
            $result = $db->query($sql);
            if($result->num_rows > 0){
                echo "<h1 class='text-warning'>Slot is not available for $date at $start_time. Please check another time slot</h2>";
            
            }else{
                echo "<h2 class='text-success'>Slot is available for $date at $start_time</h2>";
                
                $_SESSION['action']='booking';
                $_SESSION['date']= $date;
                $_SESSION['time']=$start_time;
                
                if (isset($_SESSION['USERID'])){
                    echo "Book Now..!";
                    
                }else{
                    echo "<a href='login.php'>Please login before make booking</a>";
                }
            }
            ?>
        </div>
    </section>
</main>

<?php
include 'footer.php';
ob_end_flush();
?>
