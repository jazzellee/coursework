<?php
session_start();
include_once("connection.php");
include_once("navbar.php");

if (!isset($_GET["productid"])) {
    header("Location: displayproducts.php");
    exit();
}

$_SESSION['backURL'] = $_SERVER['REQUEST_URI'];

array_map("htmlspecialchars", $_GET);

$stmt = $conn->prepare("SELECT * FROM tblproducts WHERE productid = :productid");
$stmt->bindParam(':productid', $_GET["productid"]);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Product Details</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .product-layout {
            display: flex;
            width: 100%;
            gap: 24px;
            align-items: flex-start;
        }

        .product-image-panel,
        .product-details-panel {
            width: 50%;
        }

        .product-image-panel img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>

<div class="product-layout">
    <div class="product-image-panel">
        <img src="images/<?php echo($row["image"]); ?>">
    </div>

    <div class="product-details-panel">

        <!-- product name, price, and description -->
        <?php
            echo('<h1>'.$row["productname"].'</h1>');
            echo('<p>£'.number_format($row["price"],2).'</p>');
            echo('<p>'.$row["description"].'</p>');
        ?>

        <!-- add to cart -->
        <form action="addtocart.php" method="post">
            <?php
            if ($row["stock"] <= 0) {
                echo('<span style="color: red;">Out of Stock</span><br>');

            } elseif ($row["stock"] <= 5) {
                $available = $row["stock"];
                echo('Only '. $available.' left!'. "<br>
                <input type='number' name='qty' min='1' max='$available' value='1'>
                <input type='hidden' name='productid' value=".$row['productid']."'>");

            } else {
                echo("<input type='number' name='qty' min='1' max='5' value='1'>
                <input type='hidden' name='productid' value=".$row['productid'].">");
            }

            if (!isset($_SESSION['userid']) and $row["stock"] > 0) {
                echo('<input type="button" value="Add to Cart" onclick="alert(\'Please log in to add items to your cart.\')">');
            } elseif ($row["stock"] <= 0) {
                echo('<input type="button" value="Add to Cart" disabled>');
            } else {
                echo('<input type="submit" value="Add to Cart">');
            }
            ?>
        </form>

        <!-- displays either dimensions or size -->
        <?php
            if ($row["dimensions"] != "") {
                echo('<p>Dimensions: '.$row["dimensions"].'</p>');
            }

            if ($row["size"] != "") {
                echo('<p>Size: '.$row["size"].'</p>');
            }
        ?>

    </div>
</div>

</body>
</html>
