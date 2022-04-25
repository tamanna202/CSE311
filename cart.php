<?php
    session_start();
    if(!isset($_SESSION['userEmail'])){
        header('Location: customerlogin.php');
    }

    require_once("dbmanager.php");
    $db = new dbmanager();  

    if(isset($_POST['submit1'])){
        $db->deleteCartItems($_SESSION['userEmail'], $_POST['iid']);
    }

    $successMessage = '';

    if(isset($_POST['submit2'])){
        if($db->placeOrder($_SESSION['userEmail'])){
            $successMessage = 'Order Successfully Placed!';
        }
    }
    
    $errorMessage = '';
    $rows = $db->getCartItems($_SESSION['userEmail']);  
    $total = 0;

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/cart.css">
    <title>Edit Product</title>
</head>
<body>
    <div class="sidenav">
        <a href="./index.php"><h3>Home</h3></a>  
        <a href="./logout.php"><h3>Logout</h3></a>        
    </div>
    <div class="main-content">
        <?php if(empty($rows)){?>
        <?php    if($successMessage == ''){ ?>
                <h2 style='color:red;'>Cart is empty!</h2>
        <?php    }else{ ?>
                <h2 style='color:red;'>Order Successfully Placed!</h2>
        <?php    } ?>
            
        <?php }else{ ?>

            <table>
                <tr>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Cancel</th>
                </tr>

                <?php   foreach($rows as $row){ 
                            $total = $total + $row['price'];
                ?>
                            <tr>
                                <td><?php echo $row['name']; ?></td>
                                <td><img src="./image/<?php echo $row['iid']; ?>.jpeg" height="50px" width="50px"></td>
                                <td><?php echo $row['quantity']; ?></td>
                                <td><?php echo $row['price']; ?></td>
                                <td>
                                    <form action="cart.php" method="post">
                                        <input type="hidden" name="iid" value="<?php echo $row['iid'];?>"> 
                                        <input type="submit" name="submit1" value="X">
                                    </form>
                                </td>
                            </tr>                    
                <?php   } ?>

                <tr>
                    <td></td>
                    <td></td>
                    <th>Total:</th>
                    <td><?php echo $total; ?></td>
                    <td>
                        <form action="cart.php" method="post">
                            <input type="submit" name="submit2" value="Place order">
                        </form>
                    </td>
                </tr>
                
                
            </table>
        <?php } ?>

    </div>
</body>
</html>