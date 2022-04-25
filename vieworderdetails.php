<?php
    session_start();
    if(!isset($_SESSION['adminEmail'])){
        header('Location: adminlogin.php');
    }
    
    require_once("dbmanager.php");
    $db = new dbmanager();  

    $errorMessage = '';
    $rows = [];
    $error = false;

    if(!isset($_GET['cartid'])){
        $errorMessage = 'Not Found!';
        $error = true;
    }else{
        $rows = $db->getOrderDetails($_GET['cartid']); 
    }

    $total = 0;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/cart.css">
    <title></title>
</head>
<body>
    <div class="sidenav">
        <a href="./vieworder.php"><h3>Back</h3></a>  
        <a href="./logout.php"><h3>Logout</h3></a>        
    </div>
    <div class="main-content">
        <?php if(!$error){ ?>

            <table>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>

                <?php   foreach($rows as $row){ 
                            $total = $total + $row['price'];
                ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><img src="./image/<?php echo $row['iid']; ?>.jpeg" height="50px" width="50px"></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo $row['price']; ?></td>
                            </tr>                    
                <?php   } ?>

                <tr>
                    <td></td>
                    <td></td>
                    <th>Total:</th>
                    <td><?php echo $total; ?></td>
                </tr>
                
            </table>
        <?php }else{ 
            
                print("<h2 style='color:red;'>".$errorMessage."<h2>");
                    
            } 
        ?>


    </div>
</body>
</html>