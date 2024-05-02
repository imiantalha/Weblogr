<?php

// Initialize PHPMailer
        $phpmailer = new PHPMailer\PHPMailer\PHPMailer();
        
        // Set up SMTP
        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Username = 'c967935afc36bb';
        $phpmailer->Password = 'fd93a5bc041467';
        $phpmailer->Port = 2525;

        // Set email parameters
        $phpmailer->setFrom('talhaarshad427@gmail.com', 'Weblogr');
        $phpmailer->addAddress($email);
        $phpmailer->Subject = 'Weblogr - OTP Verification';
        $phpmailer->Body = "Your OTP for Weblogr registration/password reset is: $otp";

        // Send email
        if ($phpmailer->send()) {
            header("Location: otp_verification.php?email=$email&reset=$reset");
            exit;
        } else {
            // Handle email sending failure
            echo "Failed to send OTP. Please try again.";
        }
