<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

function sendActivationEmail($email, $firstName, $activationToken) {
    $mail = new PHPMailer(true);

    try {
        // PHPMailer server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Change to SMTP::DEBUG_SERVER for verbose debug output
        $mail->isSMTP();
        $mail->Host = 'mail.karbenjyle.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'cicto-admin@karbenjyle.com';
        $mail->Password = 'Karl_jasper1231'; // Use a secure password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        // Sender and recipient settings
        $mail->setFrom('cicto-admin@karbenjyle.com', 'CICTO Admin');
        $mail->addAddress($email, $firstName);

        // Email content for the welcome and activation email
        $mail->isHTML(true);
        $mail->Subject = 'Welcome to CICTO! Account Activation Required';
        $mail->Body = <<<END
        <h1>Welcome, $firstName!</h1>
        <p>Thank you for signing up. Your email address <b>$email</b> has been successfully registered with us.</p>
        <p>Click <a href="https://karbenjyle.com/cicto/administrator/account/activate-account.php?token=$activationToken">HERE</a> 
        to activate your account. The link will expire in 30 minutes.</p>
        END;
        $mail->AltBody = "Welcome, $firstName! Thank you for signing up. Your email address $email has been successfully registered with us. Click the following link to activate your account: https://karbenjyle.com/activate-account.php?token=$activationToken";

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return 'Mailer error: ' . $mail->ErrorInfo;
    }
}
?>
