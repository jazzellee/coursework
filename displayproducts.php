<?php
session_start();
include_once('connection.php');
include_once("navbar.php");
?>

<!DOCTYPE html>
<html>
<head>
<title>Display Products</title>
<link rel="stylesheet" href="styles.css">
<style>
	#products-banner {
		width: calc(100% + 40px);
		height: 50vh;
		margin: -70px -20px 0;
		background-image: linear-gradient(rgba(255, 255, 255, 0.35), rgba(255, 255, 255, 0.35)), url("images/content/products-banner.png");
		background-size: cover;
		background-position: center;
		background-repeat: no-repeat;
		display: flex;
		align-items: center;
		justify-content: center;
		position: relative;
	}

	.products-title {
		position: absolute;
		text-align: center;
		font-size: 60px;
		z-index: 10;
		margin: 0;
	}

</style>
</head>
<body>
<div id="products-banner">
	<h1 class="products-title">Products</h1>
</div>

<?php

$_SESSION['backURL'] = $_SERVER['REQUEST_URI'];

if (!isset($_SESSION['userid'])) //reminder to log in in order to add items to cart
{   
    echo('<br><br><a href="login.php">Log in to add items to your cart</a><br><br>');
}


	$stmt = $conn->prepare("SELECT * FROM tblproducts");
	$stmt->execute();
	echo('<div class="products-grid">');
	$returnURL = $_SERVER['REQUEST_URI'];
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{ //uses a hidden input which contains the ID of the product selected
			echo('<form action="addtocart.php" method="post" class="add-to-cart-form product-card">');
			echo('<a href="productdetails.php?productid='.$row["productid"].'" class="product-card-image-link product-details-image-link"><img src="images/'.$row["image"].'" class="product-card-image"><span class="product-details-overlay"><span class="product-details-overlay-text">See Details</span></span></a>');
			echo('<a href="productdetails.php?productid='.$row["productid"].'" class="product-card-title">'.$row["productname"].' £'.$row["price"].'</a>');

			/* different messages based on stock qty: sold out, < 5, normal*/
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

			echo('<br><br>');
			echo("</form>"); 
		}
	echo('</div>');
	$stmt->closeCursor();
?>

<!-- add / remove buttons and qty selector -->
<script>
	document.addEventListener('DOMContentLoaded', function () {
		document.querySelectorAll('.qty-selector').forEach(function (selector) {
			const qtyInput = selector.querySelector('.qty-input');
			const minusBtn = selector.querySelector('.qty-step-minus');
			const plusBtn = selector.querySelector('.qty-step-plus');

			if (!qtyInput || !minusBtn || !plusBtn) {
				return;
			}

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
	});
</script>
<br><br><a href="displayproducts.php">Back to Top</a>
</body>
</html>


