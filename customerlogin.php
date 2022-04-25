<?php
    session_start();
    if(isset($_SESSION['userEmail'])){
        header('Location: index.php');
    }
    require_once("dbmanager.php");
    $db = new dbmanager();  
    $loginMessage = '';    

    if(isset($_POST['submit'])){
        if($db->customerLogin($_POST['email'],$_POST['password'])){
            $_SESSION['userEmail'] = $_POST['email'];
            header('Location: index.php');
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
    <link rel="stylesheet" href="./css/customerlogin.css">
    <title>Customer Login</title>
</head>
<body>
    <div class="center">
        <h3>Customer Login</h3>
        <?php
            echo "<p class='error-message'>$loginMessage</p>";
        ?>
    
        <form action="customerlogin.php" method="post">
            <input class="form-input" type="email" name="email" id="email" placeholder="Email">
            <br>
            <input class="form-input" type="password" name="password" id="password" placeholder="Password">
            <br>
            <input type="submit" name="submit" value="Login">
            <p>Don't Have an account? <a href="./customersignup.php">Click Here!</a></p>
        </form>
    </div>
</body>
</html>