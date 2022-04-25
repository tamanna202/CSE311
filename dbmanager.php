<?php
    require_once('connectionsingleton.php');
    
    class dbmanager{
        private $con = null;

        public function __construct(){
            $this->con = connectionSingleton::getConnection();
        }

        //------------------------------ADMIN---------------------------------

        function adminLogin($email,$password){
            $qry = "SELECT pass FROM admin WHERE email = '$email'";
            $isValid = FALSE;
            $result = $this->con->query($qry);
            $row = $result->fetch_assoc();
            if($row != NULL){   
                if($row['pass'] == $password){
                    $isValid = TRUE;
                }
            }          
            
            return $isValid;
        }

        //---------------------------------CUSTOMER----------------------------------

        function customerLogin($email,$password){
            $qry = "SELECT pass FROM customer WHERE email = '$email'";
            $isValid = FALSE;
            $result = $this->con->query($qry);
            $row = $result->fetch_assoc();

            if($row != NULL){
                if($row['pass'] == $password){
                    $isValid = TRUE;
                }
            }

            return $isValid;
        }

        function customerSignup($email, $pasword, $phone, $address){
            $sql = "INSERT INTO customer (email, pass, phone, address) VALUES ('$email', '$pasword', $phone, '$address')";
        
            if($this->con->query($sql)){
                return TRUE;
            } 
            else{
                return FALSE;
            }

        }

        //----------------------------------ITEM-------------------------------------

        function saveNewItem($name, $description, $catid, $price, $quantity){
            $sql = "INSERT INTO item (name, description, catid, price, quantity) VALUES ('$name', '$description', $catid, $price, $quantity)";
        
            if($this->con->query($sql)){
                return TRUE;
            } 
            else{
                return FALSE;
            }

        }

        function updateItem($iid, $name, $description, $catid, $price, $quantity){
            $sql = "UPDATE item SET name = '$name', description = '$description', catid = $catid, price = $price, quantity = $quantity WHERE iid = $iid";
        
            if($this->con->query($sql)){
                return TRUE;
            } 
            else{
                return FALSE;
            }

        }

        function getAllItem(){
            $qry = "SELECT A.iid,A.catid,A.name,A.description,A.price,A.quantity,B.name AS catname FROM item AS A INNER JOIN category AS B ON A.catid = B.catid";

            $result = $this->con->query($qry);
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            return $rows;
        }

        function getItem($iid){
            $qry = "SELECT * FROM item WHERE iid = $iid";

            $result = $this->con->query($qry);
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            return $rows;
        }

        function getImageName(){
            $qry = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'makeup' AND TABLE_NAME   = 'item'";
            $result = $this->con->query($qry);
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            return $rows[0]['AUTO_INCREMENT'];
        }

        //---------------------------------------Category----------------------------------------

        function getAllCategory(){
            $qry = "SELECT * FROM category";

            $result = $this->con->query($qry);
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            return $rows;
        }

        //---------------------------------------Cart----------------------------------------

        function getCartItems($email){
            $qry = "SELECT A.iid,A.catid,A.name,A.description,A.price*B.quantity AS price, B.quantity 
                    FROM (SELECT * FROM item) AS A 
                    INNER JOIN (SELECT * FROM cartitem WHERE cartid = (SELECT cartid FROM cart WHERE custid = (SELECT custid FROM customer WHERE email = '$email') AND active = TRUE)) AS B 
                    ON A.iid = B.iid";
            $result = $this->con->query($qry);
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            return $rows;
        }

        function deleteCartItems($email, $iid){
            $qry = "DELETE FROM `cartitem` WHERE iid = $iid AND cartid = (SELECT cartid FROM cart WHERE custid = (SELECT custid FROM customer WHERE email = '$email'))";
            if($this->con->query($qry)){
                return TRUE;                        
            }else{
                return FALSE;
            }
        }

        function addCartItems($email, $iid, $quantity){

            $qry = "SELECT quantity FROM cartitem WHERE cartid = (SELECT cartid FROM cart WHERE custid = (SELECT custid  FROM customer WHERE email = '$email') AND active = TRUE) AND iid = $iid";
            $result = $this->con->query($qry);
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            $cartquantity = 0;
            if(!empty($rows)){$cartquantity = $rows[0]['quantity'];}
            
            $cartquantity = $cartquantity+$quantity;

            $qry = "SELECT quantity FROM item WHERE iid = $iid";
            $result = $this->con->query($qry);
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }

            $availableQuantity = $rows[0]['quantity'];
            print($availableQuantity);
            print($cartquantity);
            if($availableQuantity>=$cartquantity){
                $qry = "SELECT cartid FROM cart WHERE custid = (SELECT custid FROM customer WHERE email = '$email') AND active = true";
                $result = $this->con->query($qry);
                $rows = array();
                foreach ($result as $row) {
                    $rows[] = $row;
                }

                // If cart doesnt exist
                if(empty($rows)){

                    $qry = "INSERT INTO cart(custid) VALUES ((SELECT custid FROM customer WHERE email = '$email'))";      

                    //Create a cart
                    if($this->con->query($qry)){
                        
                        $qry = "SELECT cartid FROM cart WHERE custid = (SELECT custid FROM customer WHERE email = '$email') AND active = true";
                        $result = $this->con->query($qry);
                        $rows = array();
                        foreach ($result as $row) {
                            $rows[] = $row;
                        }

                        $qry = "SELECT * FROM cartitem WHERE cartid = {$rows[0]['cartid']} AND iid = $iid";
                        $result = $this->con->query($qry);
                        $rows1 = array();
                        foreach ($result as $row) {
                            $rows1[] = $row;
                        }

                        //If item doesnt exist
                        if(empty($rows1)){
                            $qry = "INSERT INTO cartitem(cartid, iid, quantity) VALUES ({$rows[0]['cartid']}, $iid, $quantity)";

                            if($this->con->query($qry)){
                                return TRUE;                        
                            }else{
                                return FALSE;
                            }
                        
                        //If item exists
                        }else{
                            $qry = "UPDATE cartitem SET quantity = quantity+$quantity WHERE cartid = {$rows[0]['cartid']} AND iid = $iid";

                            if($this->con->query($qry)){
                                return TRUE;                        
                            }else{
                                return FALSE;
                            }

                        }

                    }else{
                        return FALSE;
                    }

                //If cart exists
                }else{

                    $qry = "SELECT quantity FROM cartitem WHERE cartid = {$rows[0]['cartid']} AND iid = $iid";

                    $result = $this->con->query($qry);
                    $rows1 = array();
                    foreach ($result as $row) {
                        $rows1[] = $row;
                    }

                    //If item doesnt exist
                    if(empty($rows1)){
                        
                        $qry = "INSERT INTO cartitem(cartid, iid, quantity) VALUES ({$rows[0]['cartid']}, $iid, $quantity)";

                        if($this->con->query($qry)){
                            return TRUE;                        
                        }else{
                            return FALSE;
                        }
                    
                    //If item exists
                    }else{
                        $qry = "UPDATE cartitem SET quantity = quantity+$quantity WHERE cartid = {$rows[0]['cartid']} AND iid = $iid";

                        if($this->con->query($qry)){
                            return TRUE;                        
                        }else{
                            return FALSE;
                        }

                    }
                    
                }

            }else{
                return FALSE;
            }

            
        }

        //----------------------------------------Order-----------------------------------------

        function placeOrder($email){
            $qry = "INSERT INTO `orderr`(`cartid`, `orderby`) 
            VALUES (
                (SELECT cartid FROM cart WHERE custid = (SELECT custid FROM customer WHERE email = '$email') AND active = TRUE),
                (SELECT custid FROM customer WHERE email = '$email')
                )";
            if($this->con->query($qry)){
                $qry = "UPDATE item
                    INNER JOIN (SELECT iid,quantity FROM cartitem WHERE cartid = (SELECT cartid FROM cart WHERE custid = (SELECT custid FROM customer WHERE email = '$email') AND active = TRUE)) AS A ON item.iid = A.iid
                    SET item.quantity = item.quantity - A.quantity";
                
                if($this->con->query($qry)){
                    $qry = "UPDATE cart SET active = false WHERE cartid = (SELECT cartid FROM cart WHERE custid = (SELECT custid FROM customer WHERE email = '$email') AND active = TRUE)";
                    if($this->con->query($qry)){
                        return TRUE;                        
                    }else{
                        return FALSE;
                    }                        
                }else{
                    return FALSE;
                }     
            }else{
                return FALSE;
            }           
        }

        function getAllOrder(){
            $qry = "SELECT orderr.*, customer.email FROM orderr INNER JOIN customer on orderr.orderby = customer.custid";

            $result = $this->con->query($qry);
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            return $rows;
        }

        function getOrderDetails($cartid){
            $qry = "SELECT A.iid,A.catid,A.name,A.description,A.price*B.quantity AS price, B.quantity 
            FROM (SELECT * FROM item) AS A 
            INNER JOIN (SELECT * FROM cartitem WHERE cartid = $cartid) AS B 
            ON A.iid = B.iid";

            $result = $this->con->query($qry);
            $rows = array();
            foreach ($result as $row) {
                $rows[] = $row;
            }
            return $rows;
        }

        function deliverOrder($oid){
            $qry = "UPDATE orderr SET delivered = true WHERE oid = $oid";

            if($this->con->query($qry)){
                return TRUE;                        
            }else{
                return FALSE;
            }
        }
    }
?>