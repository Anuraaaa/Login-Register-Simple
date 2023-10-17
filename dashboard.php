<?php
    require_once('koneksi.php');

    if (isset($_POST['logout']))
    {
        unset($_SESSION['userid']);
        header('Location: dashboard.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>dashboard</title>
    <style>
        * {
            padding: 0;
            margin: 0;
        }
        nav {
            display: flex;
            flex-direction: row;
            justify-content: space-around;
            align-items: center;
            background-color: #0891b2;
            padding: 24px;
        }
        nav ul {
            display: flex;
            flex-direction: row;
            gap: 24px;
        }
        nav ul li {
            list-style: none;
        }
        form button {
            background: none;
            border: none;
        }
        form button:hover {
            cursor: pointer;
        }
        li a {
            text-decoration: none;
            color: black;
            padding: 8px;
            background-color: chocolate;
            border-radius: 10px;
        }
    </style>
</head>
<body>
    <nav>
        <h1>Brand</h1>
        <ul>
            <li>Home</li>
            <li>About</li>
            <li>Service</li>
            <?php
                if (isset($_SESSION['userid']))
                {
                    echo("
                    <li>
                    <form action='dashboard.php' method='POST'>
                    <button type='submit' name='logout'>Logout</button>
                    </form>
                    </li>
                    ");                    
                }
                else
                {
                    echo("
                        <li><a href='login.php'>Login</a></li>
                    ");
                }
            ?>
        </ul>
    </nav>
    <article>
        Dashboard
    </article>
</body>
</html>