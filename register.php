<?php
    require_once('koneksi.php');
    require_once('mailer.php');

    if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password']))
    {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if (strlen($password) < 8)
        {
            $_SESSION['error'] = "Password kurang dari 8 karakter";
            header("Location: register.php");
            exit;
        }
        else 
        {
            header("Location: activationaccount.php");
            $_SESSION['kode'] = $randomNumber = str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
            $mail = new Email();
            $mail->sendEmail($_ENV['MAIL_ADDRESS'], $_ENV['MAIL_PASSWORD'], $email, "Aktivasi akun", $_SESSION['kode']);
            $_SESSION['username'] = $_POST['username'];
            $_SESSION['email'] = $_POST['email'];
            $_SESSION['registerdate'] = date("Y-m-d H:i:s");
            $_SESSION['hashpassword'] = password_hash($password, PASSWORD_BCRYPT);            
        }
    }
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>regist</title>
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
    <form action="register.php" method="POST">
        <h1>Form Register</h1>
        <?php
            if (isset($_SESSION['error']))
            {
                echo("
                    <p>".$_SESSION['error']."</p>            
                ");
                unset($_SESSION['error']);
            }
        ?>
        <label>Username</label>
        <input type="text" name="username">

        <label>Email</label>
        <input type="email" name="email">

        <label>Password</label>
        <input type="password" name="password">
        <a href="login.php">Sudah punya akun? Login disini</a>
        <button type="submit">Regist</button>
    </form>
</body>
</html>