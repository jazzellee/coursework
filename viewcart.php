<?php
session_start();
include_once("connection.php");
include_once("loginredirect.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
include_once("navbar.php");
?>

    <h1>Cart Items:</h1>

    <?php
    $total = 0;
    if (!isset($_SESSION["item"])) {
        $_SESSION["item"] = array();
    }

    if (count($_SESSION["item"]) == 0) {
        echo("Your cart is empty");
        echo("<a href='displayproducts.php'><br>Fill up your cart!</a>");
    } else {
    ?>
    <table>
        <tr>
            <th>Name</th>
            <th>Qty</th>
            <th>Price</th>
        </tr>
    <?php
        foreach ($_SESSION["item"] as $item) {
            $stmt = $conn->prepare("SELECT * FROM tblproducts WHERE productid=:productid");
            $stmt->bindParam(':productid', $item["item"]);
            $stmt->execute();

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo("<tr class='product-row'><td><a href='productdetails.php?productid=".$row["productid"]."'><img src='images/".$row["image"]."'></a> <a href='productdetails.php?productid=".$row["productid"]."'>".$row["productname"]."</a></td><td> ".$item["qty"]." "
                    ."<form class='hover' method='post' action='deletefromcart.php' style='display:inline;'>"
                    ."<input type='hidden' name='productid' value='".$item["item"]."'>"
                    ."<button class='hover-button' type='submit' title='delete'>delete</button>"
                    ."</form>"
                    ."</td><td> £".number_format(($item["qty"] * $row["price"]),2)."</td></tr>");
                $total = $total + ($item["qty"] * $row["price"]);
            }
        }

        echo("<tr><td></td><td>Total: </td><td>£".number_format($total,2)."</td></tr>");
    ?>
    </table>
    <a href="checkout.php">Checkout</a>
    <?php
    }
    ?>
</body>
</html>