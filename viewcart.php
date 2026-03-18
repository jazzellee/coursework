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
        echo("<br><form method='get' action='displayproducts.php' style='display:inline;'>");
        echo("<button type='submit'>Fill up your cart</button>");
        echo("</form>");
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
                echo("<tr class='product-row'><td><a href='productdetails.php?productid=".$row["productid"]."'><img src='images/".$row["image"]."'></a> <a href='productdetails.php?productid=".$row["productid"]."'>".$row["productname"]."</a></td><td><span class='cart-qty-wrap'><span class='cart-qty-value'>".$item["qty"]."</span>"
                    ."<a class='cart-delete-link' href='deletefromcart.php?productid=".$item["item"]."' title='delete'>"
                    ."<img class='cart-delete-icon' src='images/content/delete-icon.png' alt='Delete' style='width: 24px; height: auto; margin-left:12px;'>"
                    ."</a>"
                    ."</td><td> £".number_format(($item["qty"] * $row["price"]),2)."</td></tr>");
                $total = $total + ($item["qty"] * $row["price"]);
            }
        }

        echo("<tr><td></td><td>Total: </td><td>£".number_format($total,2)."</td></tr>");
    ?>
    </table>
    <form method="get" action="checkout.php" style="display:inline-block; margin-top: 14px;">
        <button type="submit">Checkout</button>
    </form>
    <?php
    }
    ?>
</body>
</html>