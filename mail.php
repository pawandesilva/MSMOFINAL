<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

// Create a new PHPMailer instance
function sendEmail($recipient = null, $recipient_name = null, $subject = null, $message = null) {
    $mail = new PHPMailer(true);

    try {
        // Set mailer to use SMTP
        $mail->isSMTP();

        // Enable SMTP debugging (for testing)
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;

        // Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';

        // Enable TLS encryption
        $mail->SMTPSecure = 'tls';

        // Set the SMTP port (465 for SSL, 587 for TLS)
        $mail->Port = 587;

        // Set your Gmail credentials
        $mail->SMTPAuth = true;
        $mail->Username = 'pawanapsara2000@gmail.com'; // Your Gmail address
        $mail->Password = ''; // Your Gmail password
        // Set the 'from' address and recipient
        $mail->setFrom('your@gmail.com', 'Your Name');
        $mail->addAddress($recipient, $recipient_name);

        // Set email subject and body
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->isHTML(true);
        // Send the email
        $mail->send();

        echo 'Email has been sent successfully';
    } catch (Exception $e) {
        echo "Mailer Error: {$mail->ErrorInfo}";
    }
}

?>
