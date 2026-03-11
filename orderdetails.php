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

    <h3>Order #<?php echo($_POST["orderid"]); ?></h3>
    <p>Order Placed: <?php echo($_POST["date"]); ?></p>
    <p>Status: <?php echo($_POST["status"]); ?></p>

    <table>
        <tr>
        <th>Product Name</th>
        <th>Measurements</th>
        <th>Quantity</th>
        <th>Price</th>
        </tr>

    <?php
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


                    echo("<tr class='product-row'><td>".$productname."</td>"
                    ."<td>".$measurements."</td>"
                    ."<td>".$qty."</td>"
                    ."<td>£".number_format($price * $qty,2)."</td></tr>");

                }
        }

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