<?php
    require_once('koneksi.php');

    if (isset($_POST['password']) && isset($_POST['repassword']))
    {
        if ($_POST['password'] != $_POST['repassword'])
        {
            $_SESSION['error'] = "Password tidak sama!";
            header("Location: changepassword.php");
            exit;
        }
        else
        {
            if (strlen($_POST['password']) < 8)
            {                
                $_SESSION['error'] = "Password minimal 8 karakter!";
                header("Location: changepassword.php");
                exit;
            }
            else 
            {
                $username = $_SESSION['username'];
                $email = $_SESSION['email'];
                
                $hashpassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
                
                $query = "UPDATE users SET password = '$hashpassword' WHERE username = '$username' AND email = '$email'";
                $result = $koneksi->query($query);
                
                if ($result)
                {                    
                    header("Location: login.php");
                    exit;
                }
                else
                {
                    $_SESSION['error'] = "Query Error";
                    header("Location: changepassword.php");
                    exit;
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>change password</title>
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
    <form action="changepassword.php" method="POST">
        <h1>Form Change Password</h1>
        <?php
            if (isset($_SESSION['error']))
            {
                echo("
                    <p>".$_SESSION['error']."</p>            
                ");
                unset($_SESSION['error']);
            }
        ?>        
        <label>New Password</label>
        <input type="password" name="password">
        <label>Re Type Password</label>
        <input type="password" name="repassword">

        <button type="submit">Submit</button>
    </form>
</body>
</html>