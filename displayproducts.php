<?php
session_start();
include_once('connection.php');
include_once("navbar.php");
?>

<!DOCTYPE html>
<html>
<title>Display Products</title>
</head>
<body>
<h1>Products:</h1>

<?php

$_SESSION['backURL'] = $_SERVER['REQUEST_URI'];

if (!isset($_SESSION['userid'])) //reminder to log in in order to add items to cart
{   
    echo('<a href="login.php">Log in to add items to your cart</a><br><br>');
}


	$stmt = $conn->prepare("SELECT * FROM tblproducts");
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{ //uses a hidden input which contains the ID of the product selected
			echo('<form action="addtocart.php" method="post">');
			echo('<a href="productdetails.php?productid='.$row["productid"].'"><img src="images/'.$row["image"].'" style="max-width: 200px; max-height: 200px; width: auto; height: auto;"></a><br>');
			echo('<a href="productdetails.php?productid='.$row["productid"].'">'.$row["productname"].' £'.$row["price"].'</a><br>');

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

			echo('<br><br>');
			echo("</form>"); 
		}
	$stmt->closeCursor();
?>
<br><br><a href="displayproducts.php">Back to Top</a>
</body>
</html>


