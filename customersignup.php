<?php
    session_start();
    if(isset($_SESSION['userEmail'])){
        header('Location: index.php');
    }

    require_once("dbmanager.php");
    $db = new dbmanager(); 
    $signupMessage = '';  

    if(isset($_POST['submit'])){
        if($db->customerSignup($_POST['email'], $_POST['password'], $_POST['phone'], $_POST['address'])){
            $signupMessage = "Signup successful!";
        }else{
            $signupMessage = "Signup failed!";
        }
    }
      
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/customersignup.css">
    <title>Customer Signup</title>
</head>

<body>
    <div class="center">
        <h3>Customer signup</h3>
        <?php
            echo "<p class='error-message'>$signupMessage</p>";
        ?>
        <form action="customersignup.php" method="post">
            <input class="form-input" type="email" name="email" id="email" placeholder="Email" required>
            <br>
            <input class="form-input" type="password" minlength="8" name="password" id="password" placeholder="Password" required>
            <br>
            <input class="form-input" type="number" minlength="11" name="phone" id="phone" placeholder="Phone" required>
            <br>
            <input class="form-input" type="address" name="address" id="address" placeholder="Address" required>
            <br>
            <input type="submit" name="submit" value="Signup">
            <p>Already Have an account? <a href="./customerlogin.php">Login Here!</a></p>
        </form>
    </div>
</body>
</html>