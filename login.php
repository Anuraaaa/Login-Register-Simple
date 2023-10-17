<?php
    require_once('koneksi.php');

    if (isset($_POST['username']) && isset($_POST['password']))
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = "SELECT * FROM users WHERE username = '$username'";
        $result = $koneksi->query($query);

        if ($result -> num_rows > 0)
        {
            $data = $result->fetch_assoc();
            
            if (password_verify($password, $data['password']))
            {
                $_SESSION['userid'] = $data['ID'];
                header('Location: dashboard.php');
                exit;
            }
            else 
            {
                $_SESSION['error'] = 'Username atau Password salah';
                header('Location: login.php');
                exit;
            }
        }
        else 
        {
            $_SESSION['error'] = "Data tidak ditemukan";
            header('Location: login.php');
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
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
    <form action="login.php" method="POST">
        <h1>Form Login</h1>
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
        
        <label>Password</label>
        <input type="password" name="password">
        <div style="display: flex; justify-content:space-between">            
            <a href="forgotpassword.php" style="text-align: start;">Lupa password?</a>
            <a href="register.php">Belum punya akun? register disini</a>
        </div>
        <button type="submit">Masuk</button>
    </form>
</body>
</html>