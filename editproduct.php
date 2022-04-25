<?php
    session_start();
    if(!isset($_SESSION['adminEmail'])){
        header('Location: adminlogin.php');
    }
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
    }


    if(isset($_POST['submit'])){
        $tmp = explode('.', $_FILES['image']['name']);
        $file_ext=strtolower(end($tmp));
        if($_FILES['image']['name'] === ''){
            if($db->updateItem($_GET['id'], $_POST['name'], $_POST['description'], $_POST['category'],$_POST['price'],$_POST['quantity'])){
                $errorMessage='Successfully updated the Item';
            }else{
                $errorMessage='Update failed';
            }
            
        }else{
            if($file_ext!=="jpeg"){
                $errorMessage="Extension not allowed, please choose a JPEG file.";
            }else{
                move_uploaded_file($_FILES["image"]["tmp_name"], "image/" .$_GET['id'].".jpeg");
                if($db->updateItem($_GET['id'], $_POST['name'], $_POST['description'], $_POST['category'],$_POST['price'],$_POST['quantity'])){
                    $errorMessage='Successfully updated the Item';
                }else{
                    $errorMessage='Update failed';
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
    <link rel="stylesheet" href="./css/editproduct.css">
    <title>Edit Product</title>
</head>
<body>
    <div class="sidenav">
        <a href="./logout.php"><h3>Logout</h3></a>  
    </div>
    <div class="main-content">

        <div class="wrapper">
            <?php if($error) : ?>
                <h2 style='color:red;'>Item Not Found!<h2>
            <?php else : ?>
                <form action="editproduct.php?id=<?php print($_GET['id']);?>" method="post" enctype="multipart/form-data">
                    <?php
                        print("<h2 style='color:red;'>".$errorMessage."<h2>");
                    ?>
                    <h1>Product Name</h1>
                    <input type="text" name="name" value='<?php print($itemDetails[0]['name']);?>' required> 
                    <h3>Description</h3> 
                    <textarea rows="10" cols="100" name="description" required><?php print($itemDetails[0]['description']);?></textarea><br>
                    <h3>Product Image</h3> 
                    <input type="file" name="image" accept=".jpeg">
                    <h3>Product Category</h3>
                    <select name="category">
                        <?php
                            foreach($rows as $row){
                                if($row['catid'] == $itemDetails[0]['catid'] ){
                                    print("<option value='".$row['catid']."' selected>".$row['name']."</option>");    
                                }else{
                                    print("<option value='".$row['catid']."'>".$row['name']."</option>");
                                }                                
                            }                        
                        ?>
                    </select>
                    <h3>Product Price</h3>
                    <input type="number" name="price" value='<?php print($itemDetails[0]['price']);?>' required>
                    <h3>Product Quantity</h3>
                    <input type="number" name="quantity" value='<?php print($itemDetails[0]['quantity']);?>' required><br><br>
                    <input type="submit" name="submit" value="Update Details">
                </form>
            <?php endif; ?>            
        </div>
    </div>
</body>
</html>