<?php
include_once('connection.php');

/* displays current user */
echo('<a href="userdetails.php">');
include_once('displayuserdetails.php');
echo('</a>');

/* link to admin home if admin */
$stmt = $conn->prepare("SELECT role FROM tblusers WHERE userid = :userid");
$stmt->bindParam(':userid', $_SESSION['userid'], PDO::PARAM_INT);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row["role"] == 1) { /* link to admin home if admin */
    echo('<a href="adminhome.php">Admin Home</a><br><br>');
}

/* displays products and its separate sections */
echo('<br><br><a href="displayproducts.php">Products</a>');

?>
