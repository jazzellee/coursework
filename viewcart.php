<?php
session_start();
include_once("connection.php");
include_once("displayuserdetails.php");
include_once("loginredirect.php");
?>

<!DOCTYPE html>
<html>
<title>Cart</title>
    
</head>
<body>
    <h1>Cart Items:</h1>
    <table>
        <tr>
        <th>Name</th>
        <th>Qty</th>
        <th>Price</th>

    <?php
    $total=0;
    echo("<tr>");
    if (!isset($_SESSION["item"])){
        $_SESSION["item"]=array();
    }

    foreach ($_SESSION["item"] as $item){

        echo("<br>");
        $stmt = $conn->prepare("SELECT * FROM tblproducts WHERE productid=:productid");
        $stmt->bindParam(':productid', $item["item"]);
        $stmt->execute();

        if (count($_SESSION["item"])==0){
            echo("Your cart is empty");
            echo "<a href='displayproducts.php'>Fill up your cart!</a>";
        }
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                echo("<td>".$row["productname"]."</td><td> ".$item["quantity"]." </td><td>- £".number_format(($item["quantity"]*$row["price"]),2)."</td></tr>");
                $total=$total+($item["quantity"]*$row["price"]);
            }
    }
    echo("<tr><td></td><td>Total cost: </td><td>£".number_format($total,2)."</td></tr>");
    ?>
    </table>
    <a href="checkout.php">Checkout</a>
</body>
</html>