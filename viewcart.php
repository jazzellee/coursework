<?php
session_start();
include_once("connection.php");
include_once("displayuserdetails.php");
include_once("loginredirect.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <style>
        /* hover for delete button */
        .cart-row { position: relative; }
        .delete { position: relative; left: 10px; }
        .delete-button { display: none; }
        .cart-row:hover .delete-button { display: inline-block; }
    </style>
</head>
<body>
    <h1>Cart Items:</h1>
    <table>
        <tr>
        <th>Name</th>
        <th>Qty</th>
        <th>Price</th>
        <th style="visibility:hidden;">Delete</th>

    <?php
    $total=0;
    if (!isset($_SESSION["item"])){
        $_SESSION["item"]=array();
    }

    if (count($_SESSION["item"])==0){
            echo("Your cart is empty");
            echo "<a href='displayproducts.php'><br>Fill up your cart!</a>";

    }else{
        foreach ($_SESSION["item"] as $item){

            echo("<br>");
            $stmt = $conn->prepare("SELECT * FROM tblproducts WHERE productid=:productid");
            $stmt->bindParam(':productid', $item["item"]);
            $stmt->execute();

            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    echo("<tr class='cart-row'><td>".$row["productname"]."</td><td> ".$item["qty"]." </td><td> £".number_format(($item["qty"]*$row["price"]),2)."</td>"
                        ."<td>"
                        ."<form class='delete' method='post' action='deletefromcart.php'>"
                        ."<input type='hidden' name='productid' value='".$item["item"]."'>"
                        ."<button class='delete-button' type='submit' title='delete'>delete</button>"
                        ."</form>"
                        ."</td></tr>");
                    $total=$total+($item["qty"]*$row["price"]);
                }
    }
}

        
    echo("<tr><td></td><td>Total: </td><td>£".number_format($total,2)."</td></tr>");
    ?>
    </table>
    <a href="checkout.php">Checkout</a>
</body>
</html>