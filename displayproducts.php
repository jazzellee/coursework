<!DOCTYPE html>
<html>
<title>Display Products</title>
</head>
<body>
<?php
include_once('connection.php');
session_start();

if (!isset($_SESSION['userid']))
{   
	$_SESSION['backURL'] = $_SERVER['REQUEST_URI'];
    echo '<a href="login.php">Log in to add items to your cart</a><br><br>';
}else{
	include_once("displayuserdetails.php");
	echo '<a href="viewcart.php">View Cart</a><br><br>';

	if (isset($_SESSION["item"])){
		echo 'items in cart: '.count($_SESSION["item"]);
	}
}


	$stmt = $conn->prepare("SELECT * FROM tblproducts");
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{//uses a hidden input which contains the ID of the product selected
			echo'<form action="addtocart.php" method="post">';

			if ($row["quantity"]==0){
				echo '<span style="color: red;">Out of Stock</span><br>';

			} elseif ($row["quantity"]<=5){ 
				$available = $row["quantity"];
				echo $row["productname"].' £'.$row["price"]."<br>
				<input type='number' name='qty' min='1' max='$available' value='1'>
				<input type='hidden' name='productid' value=".$row['productid']."'>";

			} else {
				echo $row["productname"].' £'.$row["price"]."<br>
				<input type='number' name='qty' min='1' max='5' value='1'>
				<input type='hidden' name='productid' value=".$row['productid']."'>";
			}
			
				
			if ($isset($_SESSION['userid'])) {
				echo '<input type="submit" value="Add to Cart">';
			} else {
				echo '<input type="button" value="Add to Cart" onclick="alert(\'Please log in to add items to your cart.\')">';
			}
			echo '<br><br>';
			echo "</form>"; 
		}
	$stmt->closeCursor();
?>
<br><br><a href="displayproducts.php">Back to Top</a>
</body>
</html>


