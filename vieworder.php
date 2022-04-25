<?php
    session_start();
    if(!isset($_SESSION['adminEmail'])){
        header('Location: adminlogin.php');
    }
    require_once("dbmanager.php");
    $db = new dbmanager();  

    if(isset($_POST['submit'])){
        $db->deliverOrder($_POST['oid']);
    }

    $rows = $db->getAllOrder();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/vieworder.css">
    <title>Order List</title>
</head>
<body>
    <div class="sidenav">
        <a href="./admindashboard.php"><h3>Dashboard</h3></a>
        <a href="./logout.php"><h3>Logout</h3></a>
        
    </div>
    <div class="main-content">

    <?php if(empty($rows)){?>
            <h2 style='color:red;'>No order placed yet!</h2>
        <?php }else{ ?>

            <table>
                <tr>
                    <th>Order ID</th>
                    <th>Ordered By</th>
                    <th>Delivery status</th>
                    <th>View Details</th>
                    <th>Mark</th>
                </tr>

                <?php   foreach($rows as $row){ ?>
                            <tr>
                                <td><?php echo $row['oid']; ?></td>
                                <td><?php echo $row['email']; ?></td>
                                <td>
                                    <?php 
                                        if($row['delivered']){
                                            echo "YES";
                                        } else{
                                            echo "NO";
                                        }
                                    ?>
                                </td>
                                <td>
                                    <form action="./vieworderdetails.php" method="get">
                                        <input type="hidden" name="cartid" value="<?php echo $row['cartid'];?>"> 
                                        <input type="submit" name="submit" value="view details">
                                    </form>
                                </td>
                                <td>
                                    <form action="vieworder.php" method="post">
                                        <input type="hidden" name="oid" value="<?php echo $row['oid'];?>"> 
                                        <input type="submit" name="submit" value="Mark Delivered">
                                    </form>
                                </td>
                            </tr>                    
                <?php   } ?>               
                
            </table>
        <?php } ?>      
        

   

    </div>
</body>
</html>