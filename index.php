<?php
    session_start();
    require_once("dbmanager.php");
    $db = new dbmanager();  
    $rows = $db->getAllItem();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/index.css">
    <title>Makeup Shop</title>
</head>
<body>
    <div class="sidenav">
        <?php if(isset($_SESSION['userEmail'])){ ?>
                <a href="./cart.php"><h3>Cart</h3></a>
                <a href="./logout.php"><h3>Logout</h3></a>
        <?php }else{ ?>
                <a href="./customerlogin.php"><h3>Login</h3></a>
        <?php } ?>
    </div>
    <div class="main-content">

        <?php for($i=0; $i<count($rows);){ ?>
            <div class="wrapper-div">
                <?php for($j=0; $j<3&&$i<count($rows);$i++,$j++){ ?>
                    <div class="product-div">
                        <a href="./viewproduct.php?id=<?php echo $rows[$i]['iid']; ?>">
                            <div class="image-div">
                                <img src="./image/<?php echo $rows[$i]['iid']; ?>.jpeg" alt="lipstick">
                            </div> 
                        </a>
                        <div class="description-div">
                            <p class="name-div"><?php echo $rows[$i]['name']; ?><p>
                            <p><?php echo $rows[$i]['description']; ?></p>
                        </div>               
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
        
    </div>
</body>
</html>