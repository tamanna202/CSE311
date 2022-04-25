<?php
    session_start();
    if(isset($_SESSION['adminEmail'])){
        session_destroy();
        header('Location: adminlogin.php');
    }else{
        session_destroy();
        header('Location: customerlogin.php');
    }
    
?>