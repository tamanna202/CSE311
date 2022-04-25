<?php
    session_start();
    if(!isset($_SESSION['adminEmail'])){
        header('Location: adminlogin.php');
    }
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
    <link rel="stylesheet" href="./css/admindashboard.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="sidenav">
        <a href="./savenewproduct.php"><h3>Add New Product</h3></a>
        <a href="./vieworder.php"><h3>View Orders</h3></a>
        <a href="./logout.php"><h3>Logout</h3></a>
    </div>
    <div class="main-content">

        <div class="wrapper-div">
            <table class='product-table'>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>More</th>
                </tr>
                <?php
                    foreach($rows as $row){
                        print(
                            "<tr>
                                <td>".$row['name']."</td>
                                <td>".$row['catname']."</td>
                                <td>".$row['description']."</td>
                                <td>".$row['price']."</td>
                                <td>".$row['quantity']."</td>
                                <td><a href='editproduct.php?id=".$row['iid']."'>Edit</a></td>
                            </tr>"
                        );
                    }
                ?>    
            </table>    
        </div>
    </div>
</body>
</html>