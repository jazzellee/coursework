<?php
session_start();
include_once("connection.php");
include_once("loginredirect.php");

if (isset($_POST["orderid"], $_POST["date"], $_POST["status"], $_POST["total"], $_POST["totalprice"])) {
    array_map("htmlspecialchars", $_POST);
} else {
    header("Location: vieworders.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
include_once("navbar.php");
?>

    <?php

    $status = "Unknown";

    /* convert to display status */
    if ($_POST["status"] == 0) {
        $status = "Processing";

    } else if ($_POST["status"] == 1) {
        $status = "Dispatched";

    } else if ($_POST["status"] == 2) {
        $status = "Out for Delivery";

    } else if ($_POST["status"] == 3) {
        $status = "Delivered";

    } else if ($_POST["status"] == 4) {
        $status = "Cancelled";
    }

    ?>


    <h3>Order #<?php echo($_POST["orderid"]); ?></h3>
    <p>Order Placed: <?php echo($_POST["date"]); ?></p>
    <p>Status: <?php echo($status); ?></p>

    <table>
        <tr>
        <th>Product Name</th>
        <th>Measurements</th>
        <th>Quantity</th>
        <th>Price</th>
        </tr>

    <?php
    /* gets products and quantity then calculates price */
    $stmt = $conn->prepare("SELECT productid, quantity FROM tblcart WHERE orderid = ?");
    $stmt->bindParam(1, $_POST['orderid'], PDO::PARAM_INT);
    $stmt->execute();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        
        {
            $productid = $row["productid"];
            $qty = $row["quantity"];

            $stmt2 = $conn->prepare("SELECT * FROM tblproducts WHERE productid = ?");
            $stmt2->bindParam(1, $productid, PDO::PARAM_INT);
            $stmt2->execute();

            while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
                {
                    $productname = $row2["productname"];
                    $price = $row2["price"];

                    if (($row2["dimensions"]) != "") {
                        $measurements = $row2["dimensions"];
                    } elseif (($row2["size"]) != "") {
                        $measurements = $row2["size"];
                    } else {
                        $measurements = "";
                    }

                    /* displays order details in table */
                    echo("<tr class='product-row'><td><a class='product-details-image-link' href='productdetails.php?productid=".$productid."'><img src='images/".$row2["image"]."'><span class='product-details-overlay'><span class='product-details-overlay-text'>See Details</span></span></a> <a href='productdetails.php?productid=".$productid."'>".$productname."</a></td>"
                    ."<td>".$measurements."</td>"
                    ."<td>".$qty."</td>"
                    ."<td>£".number_format($price * $qty,2)."</td></tr>");

                }
        }

        /* final totals row for order */
        echo("<tr><td></td>"
            ."<td></td>"
            ."<td>Total: ".$_POST['total']."</td>"
            ."<td>Total: £".number_format($_POST['totalprice'],2)."</td></tr>");

    $stmt->closeCursor(); 
    ?>
    </table>

    <br><br>
    <form method="post" action="vieworders.php">
        <button type="submit">Back to Orders</button>
    </form>
    
</body>
</html>