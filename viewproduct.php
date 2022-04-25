<?php
    session_start();

    require_once("dbmanager.php");
    $db = new dbmanager();
    $rows = $db->getAllCategory();  
    $itemDetails = null;
    $errorMessage = '';
    $error = true;

    if(isset($_GET['id'])){
        $itemDetails = $db->getItem($_GET['id']);
        if(!empty($itemDetails)){
            $error = false;
        }
        if(isset($_POST['submit'])){
            if(!isset($_SESSION['userEmail'])){
                header('Location: customerlogin.php');
            }else{
                if($db->addCartItems($_SESSION['userEmail'], $_GET['id'], $_POST['quantity'])){
                    $errorMessage = 'Added to cart!';
                }else{
                    $errorMessage = 'Failed to add to cart!';
                }
            }            
        }
    }

    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/viewproduct.css">
    <title>View Product</title>
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

            <div class="wrapper">
                <h2 style='color:red;'><?php echo $errorMessage; ?></h2>
                <?php if($error) : ?>
                    <h2 style='color:red;'>Item Not Found!<h2>
                <?php else : ?>                
                    <img width='200px' height='200px' src="./image/<?php echo $itemDetails[0]['iid'];?>.jpeg" alt="">
                    <h3><?php echo $itemDetails[0]['name'];?></h3>
                    <?php
                        foreach($rows as $row){
                            if($row['catid'] == $itemDetails[0]['catid'] ){
                                print("<p><b>Category:</b>".$row['name']."</p>");    
                            }                                
                        }                        
                    ?>
                    
                    <p><b>Description:</b> <?php echo $itemDetails[0]['description'];?></p>
                    <p><b>Price:</b> <?php echo $itemDetails[0]['price'];?> TK</p>
                    <p><b>Quantity Left:</b> <?php echo $itemDetails[0]['quantity'];?></p>
                    <form action="./viewproduct.php?id=<?php echo $itemDetails[0]['iid'];?>" method="post">
                        <input type="number" placeholder="Add quantity" name='quantity' min="1" max="<?php echo $itemDetails[0]['quantity'];?>"  required>
                        <input type="submit" name='submit' value="Add to cart">
                    </form>
                <?php endif; ?>            
                
            </div>
    </div>
</body>
</html>