<?php
    require_once('koneksi.php');

    if (isset($_POST['kode']))
    {
        if ($_POST['kode'] != $_SESSION['kode'])
        {
            $_SESSION['error'] = "Kode aktivasi salah! Cek email";
            header("Location: activationaccount.php");
            exit;
        }
        else
        {
            $username = $_SESSION['username'];
            $email = $_SESSION['email'];
            $registerdate = $_SESSION['registerdate'];
            $hashpassword = $_SESSION['hashpassword'];
    
            $query = "INSERT INTO users (username, password, email, registerdate) VALUES ('$username', '$hashpassword', '$email', '$registerdate')";
            $result = $koneksi->query($query);
            
            if ($result) {
                header("Location: login.php");
                exit;
            } else {
                header("Location: register.php");
                exit;
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>activation account</title>
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
    <form action="activationaccount.php" method="POST">
        <h1>Form Activation Account</h1>
        <?php
            if (isset($_SESSION['error']))
            {
                echo("
                    <p>".$_SESSION['error']."</p>            
                ");
                unset($_SESSION['error']);
            }
        ?>        
        <label>Verifikasi Kode</label>
        <input type="text" name="kode">

        <button type="submit">Submit</button>
    </form>
</body>
</html>