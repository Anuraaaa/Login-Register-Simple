<?php
    require_once('koneksi.php');
    require_once('mailer.php');

    if (isset($_POST['email']))
    {
        $email = $_POST['email'];
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = $koneksi->query($query);

        if ($result->num_rows > 0)
        {
            $data = $result->fetch_assoc();
            $_SESSION['email'] = $email;
            $_SESSION['username'] = $data['username'];
            $_SESSION['kode'] = $randomNumber = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            header("Location: verifikasiforgotpassword.php");
            $mail = new Email();
            $mail->sendEmail($_ENV['MAIL_ADDRESS'], $_ENV['MAIL_PASSWORD'], $email, "Verifikasi Forgot Password", $_SESSION['kode']);
        }
        else 
        {
            $_SESSION['error'] = "Akun tidak ditemukan";
            header("Location: forgotpassword.php");
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>forgot password</title>
    <style>
        body {
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin: 15% 24rem 0px 24rem;
            justify-content: center;
            background-color: #d1d5db;
            padding: 2rem;
        }
        form h1 {
            text-align: center;
            font-size: 20px;
        }
        form p {
            text-align: center;
            font-size: 20px;
            color: red;
        }        
        form button {
            padding: 12px;
            margin-top: 2rem;
            border: none;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            font-size: 16px;
        }
        form input {
            padding: 8px;
            border-radius: 10px;
            border: none;
        }
        form a {
            text-align: end;
        }
    </style>
</head>
<body>
    <form action="forgotpassword.php" method="POST">
        <h1>Form Forgot Password</h1>
        <?php
            if (isset($_SESSION['error']))
            {
                echo("
                    <p>".$_SESSION['error']."</p>            
                ");
                unset($_SESSION['error']);
            }
        ?>        
        <label>Email</label>
        <input type="email" name="email">
        <button type="submit">Send Email</button>
    </form>
</body>
</html>