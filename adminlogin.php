<?php

    session_start();
    if(isset($_SESSION['adminEmail'])){
        header('Location: admindashboard.php');
    }
    require_once("dbmanager.php");
    $db = new dbmanager();  
    $loginMessage = '';  

    if(isset($_POST['submit'])){
        if($db->adminLogin($_POST['email'],$_POST['password'])){
            $_SESSION['adminEmail'] = $_POST['email'];
            header('Location: admindashboard.php');
        }else{
            $loginMessage = 'Wrong username or password!';
        }
    }
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/adminlogin.css">
    <title>Admin Login</title>
</head>
<body>
    <div class="center">
        <h3>Admin Login</h3>
        <?php
            echo "<p class='error-message'>$loginMessage</p>";
        ?>
        <form action="adminlogin.php" method="post">
            <input class="form-input" type="email" name="email" id="email" placeholder="Email">
            <br>
            <input class="form-input" type="password" name="password" id="password" placeholder="Password">
            <br>
            <input type="submit" name="submit" value="Login">
        </form>
    </div>
</body>
</html>