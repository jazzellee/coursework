<?php
session_start();
include_once("connection.php");
include_once("adminverify.php");
?>

<!DOCTYPE html>
<html>

<head>
	<title>Home</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>


<!-- include navbar at the top -->
<?php
include_once("navbar.php");
?>

<div id="main-content">
</div>

<h1>Admin Home</h1>

<!-- links to other pages -->
<?php
echo('<h3>Products: </h3>');
echo('<a href="adminproducts.php">All Products</a><br><br>');
echo('<a href="newproduct.php">Add New Product</a><br><br><br><br>');

echo('<h3>Orders: </h3>');
echo('<a href="adminorders.php">All Orders</a>');
?>



</body>
</html>



