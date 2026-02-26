<?php
session_start();
include_once("displayuserdetails.php");

link to homepage


link to products


/* shows no. of items in cart */
if (isset($_SESSION["item"])){
    $total = 0;
    foreach ($_SESSION["item"] as $item){

        echo("<br>");
        $stmt = $conn->prepare("SELECT * FROM tblproducts WHERE productid=:productid");
        $stmt->bindParam(':productid', $item["item"]);
        $stmt->execute();
        
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $total=$total+($item["qty"]);
            }
        }
    
        echo '<a href="viewcart.php> Cart: '.$total.'</a><br><br>';
} else {
    echo '<a href="viewcart.php">Cart: 0</a><br><br>';
}



?>

