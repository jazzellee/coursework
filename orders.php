<?php
session_start(); 
include_once ("loginredirect.php");
?>


<!DOCTYPE html>
<html>
<head>
    
    <title>Orders</title>
    
</head>
<body>


<?php
include_once("connection.php");
$userid = $_SESSION["name"];
$stmt = $conn->prepare("SELECT * FROM tblorders WHERE userid=$userid");
	$stmt->execute();
	while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
            //looks up productid and displays product
            $productid = $row["productid"];

		}
	$stmt->closeCursor();

?>

</body>
</html>