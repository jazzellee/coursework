<?php
session_start();
include_once("connection.php");
include_once("navbar.php");

if (!isset($_GET["productid"])) {
    header("Location: displayproducts.php");
    exit();
}

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
            gap: 48px;
            align-items: flex-start;
            padding: 0 40px;
            box-sizing: border-box;
        }

        .product-image-panel {
            width: 50%;
            flex-shrink: 0;
        }

        .product-image-panel img {
            width: 100%;
            height: auto;
            display: block;
        }

        .product-details-panel {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .pd-back {
            display: inline-block;
            font-size: 22px;
            margin-bottom: 24px;
            color: #333;
            text-decoration: none;
        }

        .pd-back:hover {
            color: #9c714e;
        }

        .product-details-panel h1 {
            margin: 0 0 10px 0;
        }

        .pd-divider {
            border: none;
            border-top: 1.5px solid #000000;
            width: 25%;
            margin: 0 0 16px 0;
        }

        .pd-price {
            font-size: 18px;
            color: #555;
            margin: 0 0 28px 0;
        }

        .pd-description-label {
            font-size: 15px;
            font-family: 'Nunito', sans-serif;
            font-weight: 700;
            border-bottom: 1.5px solid #333;
            display: inline-block;
            margin-bottom: 8px;
        }

        .pd-description-text {
            color: #555;
            margin: 0 0 28px 0;
        }

        .pd-info-box {
            display: flex;
            align-items: center;
            gap: 14px;
            border: 1.5px solid #ccc;
            border-radius: 12px;
            padding: 14px 20px;
            margin-bottom: 12px;
        }

        .pd-info-box img {
            width: 32px;
            height: auto;
            flex-shrink: 0;
        }

        .pd-info-box-text {
            font-size: 15px;
            color: #444;
        }

        .pd-info-box-label {
            font-weight: 700;
            display: block;
            margin-bottom: 2px;
        }
    </style>
</head>
<body>

<div class="product-layout">
    <div class="product-image-panel">
        <img src="images/<?php echo($row["image"]); ?>" class="product-image-rounded">
    </div>

    <div class="product-details-panel">

        <a href="displayproducts.php" class="pd-back"><img src="images/content/back-arrow.png" alt="Back" style="height: 24px; width: auto;"></a>
        <script>
            document.currentScript.previousElementSibling.addEventListener('click', function(e) {
                if (history.length > 1) { e.preventDefault(); history.back(); }
            });
        </script>

        <h1><?php echo($row["productname"]); ?></h1>
        <hr class="pd-divider">
        <p class="pd-price">£<?php echo(number_format($row["price"], 2)); ?></p>

        <!-- add to cart -->
        <form action="addtocart.php" method="post" class="add-to-cart-form">
            <?php
            $returnURL = $_SERVER['REQUEST_URI'];
            if ($row["stock"] <= 0) {
                echo('<span style="color: red;">Out of Stock</span><br>');

            } elseif ($row["stock"] <= 5) {
                $available = $row["stock"];
                echo('Only '. $available.' left!'. "<br>");
                echo('<div class="cart-controls">');
                echo('<div class="qty-selector">');
                echo('<button type="button" class="qty-step qty-step-minus" aria-label="Decrease quantity">-</button>');
                echo('<input type="number" name="qty" min="1" max="'.$available.'" value="1" class="qty-input" required>');
                echo('<button type="button" class="qty-step qty-step-plus" aria-label="Increase quantity">+</button>');
                echo('</div>');
                echo('<input type="hidden" name="productid" value="'.$row['productid'].'">');
                echo('<input type="hidden" name="returnurl" value="'.htmlspecialchars($returnURL).'">');

            } else {
                echo('<div class="cart-controls">');
                echo('<div class="qty-selector">');
                echo('<button type="button" class="qty-step qty-step-minus" aria-label="Decrease quantity">-</button>');
                echo('<input type="number" name="qty" min="1" max="5" value="1" class="qty-input" required>');
                echo('<button type="button" class="qty-step qty-step-plus" aria-label="Increase quantity">+</button>');
                echo('</div>');
                echo('<input type="hidden" name="productid" value="'.$row['productid'].'">');
                echo('<input type="hidden" name="returnurl" value="'.htmlspecialchars($returnURL).'">');
            }

            if (!isset($_SESSION['userid']) and $row["stock"] > 0) {
                echo('<input type="button" value="Add to Cart" class="add-to-cart-btn" onclick="alert(\'Please log in to add items to your cart.\')">');
            } elseif ($row["stock"] <= 0) {
                echo('<input type="button" value="Add to Cart" class="add-to-cart-btn" disabled>');
            } else {
                echo('<input type="submit" value="Add to Cart" class="add-to-cart-btn">');
            }

            if ($row["stock"] > 0) {
                echo('</div>');
            }
            ?>
        </form>

        <!-- description -->
        <div style="margin-top: 28px;">
            <span class="pd-description-label">Description</span>
            <p class="pd-description-text"><?php echo($row["description"]); ?></p>
        </div>

        <!-- dimensions / size info boxes -->
        <?php
            if ($row["dimensions"] != "") {
                echo('<div class="pd-info-box">');
                echo('<img src="images/content/dimensions-icon.png" alt="Dimensions">');
                echo('<div class="pd-info-box-text"><span class="pd-info-box-label">Dimensions</span>'.$row["dimensions"].'</div>');
                echo('</div>');
            }

            if ($row["size"] != "") {
                echo('<div class="pd-info-box">');
                echo('<img src="images/content/size-icon.png" alt="Size">');
                echo('<div class="pd-info-box-text"><span class="pd-info-box-label">Size</span>'.$row["size"].'</div>');
                echo('</div>');
            }
        ?>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const qtyInput = document.querySelector('.qty-input');
        const minusBtn = document.querySelector('.qty-step-minus');
        const plusBtn = document.querySelector('.qty-step-plus');

        if (!qtyInput || !minusBtn || !plusBtn) return;

        minusBtn.addEventListener('click', function () {
            const min = parseInt(qtyInput.min || '1', 10);
            const current = parseInt(qtyInput.value || '1', 10);
            qtyInput.value = Math.max(min, current - 1);
        });

        plusBtn.addEventListener('click', function () {
            const max = parseInt(qtyInput.max || '1', 10);
            const current = parseInt(qtyInput.value || '1', 10);
            qtyInput.value = Math.min(max, current + 1);
        });
    });
</script>

</body>
</html>
