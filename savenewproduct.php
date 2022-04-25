<?php
    session_start();
    if(!isset($_SESSION['adminEmail'])){
        header('Location: adminlogin.php');
    }
    
    require_once("dbmanager.php");
    $db = new dbmanager();  
    $rows = $db->getAllCategory();
    $imageName = $db->getImageName();
    $error = '';


    if(isset($_POST['submit'])){
        $tmp = explode('.', $_FILES['image']['name']);
        $file_ext=strtolower(end($tmp));
        if($file_ext!=="jpeg"){
            $error="Extension not allowed, please choose a JPEG file.";
        }else{
            move_uploaded_file($_FILES["image"]["tmp_name"], "image/" . $imageName.".jpeg");
            $db->saveNewItem($_POST['name'], $_POST['description'], $_POST['category'],$_POST['price'],$_POST['quantity']);
            $error='Successfully Saved the Item';
        }
        
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/savenewproduct.css">
    <title>Save New Product</title>
</head>
<body>
    <div class="sidenav">
        <a href="./logout.php"><h3>Logout</h3></a>
    </div>
    <div class="main-content">

            <div class="wrapper">
                <form action="savenewproduct.php" method="post" enctype="multipart/form-data">
                    <?php
                        print("<h2 style='color:red;'>".$error."<h2>");
                    ?>
                    <h1>Product Name</h1>
                    <input type="text" name="name" required> 
                    <h3>Description</h3> 
                    <textarea rows="10" cols="100" name="description" required></textarea><br>
                    <h3>Product Image</h3> 
                    <input type="file" name="image" accept=".jpeg" required>
                    <h3>Product Category</h3>
                    <select name="category">
                        <?php
                            foreach($rows as $row){
                                print("<option value='".$row['catid']."'>".$row['name']."</option>");
                            }                        
                        ?>
                    </select>
                    <h3>Product Price</h3>
                    <input type="number" name="price" required>
                    <h3>Product Quantity</h3>
                    <input type="number" name="quantity" required><br><br>
                    <input type="submit" name="submit" value="Save">
                </form>
            </div>

    </div>
</body>
</html>