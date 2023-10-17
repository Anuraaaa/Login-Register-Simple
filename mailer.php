<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions

class Email {
    
    public function __construct()
    {

    }

    public function sendEmail($username, $password, $torecipt, $subject, $kode)
    {        
        try {
            $mail = new PHPMailer(true);
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = $username;                     //SMTP username
            $mail->Password   = $password;                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            //Recipients
            $mail->setFrom($username, 'Mailer');
            $mail->addAddress($torecipt);               //Name is optional
            $mail->addReplyTo($username, 'Information');
                
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body    = 
            "
                    <?php
                        require_once('koneksi.php');
                    ?>
                    
                    <!DOCTYPE html>
                    <html lang='en'>
                    <head>
                        <meta charset='UTF-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                        <title>Verifikasi Kode</title>
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f3f3f3;
                                margin: 0;
                                padding: 0;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                height: 100vh;
                            }
                    
                            .container {
                                background-color: #fff;
                                padding: 20px;
                                border-radius: 5px;
                                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                                text-align: center;
                            }
                    
                            h1 {
                                color: #333;
                            }
                    
                            p {
                                color: #777;
                            }
                    
                            .verification-code {
                                font-size: 24px;
                                font-weight: bold;
                                margin-top: 10px;
                                color: #333;
                            }
                        </style>
                    </head>
                    <body>
                        <div class='container'>
                            <h1>Informasi Kode Verifikasi</h1>
                            <p>Kode verifikasi yang telah dikirimkan ke email Anda adalah:</p>
                            <div class='verification-code'>
                                ".$kode."
                            </div>
                        </div>
                    </body>
                    </html>
                    
            "
            ;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

?>