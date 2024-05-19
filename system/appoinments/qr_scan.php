<?php
ob_start();
session_start();
include_once '../init.php';

$link = "Appointments Management";
$breadcrumb_item = "Appointments";
$breadcrumb_item_active = "Scan QR";

extract($_GET);
if(!empty($appoinmentid)){
    $db = dbConn();
    $sql = "Select appoinments.id, customers.FirstName,customers.LastName,customers.Email,customers.MobileNo,appoinments.date,appoinments.startTime,appoinments.endTime FROM appoinments INNER JOIN customers ON appoinments.CustomerId=customers.CustomerId WHERE appoinments.id='$appoinmentid'";
    $result = $db->query($sql);
}
?> <!-- link qr scan library -->
<script src="../../qr_scanner/instascan.min.js" type="text/javascript"></script>
<div class="row">
    <div class="col-4">
        <!-- play camera -->
        <video id="scan_job" height="200" width="285" class="border border-1 border-black"></video>
        <br>
        <!-- start and stop scaning -->
        <button type="button" class="btn btn-success align" onclick="scanjob()">Start Scan</button>
        <button type="button" class="btn btn-warning " onclick="stopscan()">Stop Scan</button>







    </div>
    <div class="col-md-8">
        
        <?php
        //@ used to check anything theres in the result
        if(@$result){
            $row = $result->fetch_assoc();
            ?>
        <table class="table table-striped text-nowrap">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Mobile No</th>
                    <th>App.date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $row['FirstName']?></td>
                    <td><?= $row['LastName'] ?></td>
                    <td><?= $row['Email'] ?></td>
                    <td><?= $row['MobileNo']?></td>
                    <td><?= $row['date'] ?></td>
                    <td><?= $row['startTime']?></td>
                    <td><?= $row['endTime']?></td>
                </tr>
            </tbody>
        </table>
        <?php
        }
        ?>
    </div>
</div>
<?php
$content = ob_get_clean();
include '../layouts.php';
?>
<script>
    
    function scanjob(){
        //pass the video tag and create a new object --scaner object 
        let scanner = new Instascan.Scanner({video:document.getElementById('scan_job')});
        //trigger the camera and do scan process(check qr pattern )
        scanner.addListener('scan',function(content){
           findAppointment(content);// display content 
            
        });
        Instascan.Camera.getCameras().then(function (cameras) {
            if (cameras.length > 0) {
                scanner.start(cameras[0]);
            } else {
                console.error('No cameras found.');
            }
             }).catch(function (e) {
            console.error(e);
        });
    }
    
        
    //stop the camera
    function stopscan(){
        const video = document.querySelector('video');
        const mediaStream = video.srcObject;
        const tracks = mediaStream.getTracks();// check the no of camera
        tracks[0].stop();//stop the relavant camera
        tracks.forEach(track => track.stop())
    }
    
    //pass the scanned content from qr using find appointment function
    
        function findAppointment(appointmentid){
        window.location.href ="http://localhost/MSMOFINAL/system/appointments/qr_scan.php?appointmentid="+appoinmentid
    }
      
</script>
