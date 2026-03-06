<?php
session_start();
include_once("connection.php");
include_once("adminverify.php");
?>

<!DOCTYPE html>
<html>

<head>
	<title>Home</title>
</head>
<body>


<?php
include_once("navbar.php");
?>

<div id="main-content">
</div>


<h1>Admin Home</h1>

<?php
include_once("navbar.php");
echo('<a href="adminproducts.php">All Products</a><br><br>');
echo('<a href="adminorders.php">All Orders</a>');
?>



</body>
</html>



