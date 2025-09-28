<!DOCTYPE html>
<html>
<title>Display Products</title>
    
</head>
<body>
<?php
include_once('connection.php');
session_start();
if (!isset($_SESSION['name']))
{   
    echo '<a href="login.php">Log in</a>';
}else{
    include_once("displayuserdetails.php");

}


	$stmt = $conn->prepare("SELECT * FROM tblproducts");
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{//uses a hidden input which contains the ID of the product selected
			echo'<form action="addtocart.php" method="post">';
			echo($row["productname"].' '.$row["price"].' '.$row["Quantity"]."<input type='number' name='qty' min='1' max='5' value='1'>
			<input type='submit' value='Add To Cart'><input type='hidden' name='productid' value=".$row['productid']."><br></form>");
		}
?>   
<a href="checkout.php">Checkout</a>
</body>
</html>