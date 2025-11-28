<?php
include_once("connection.php");
include_once("loginredirect.php");
if (isset($_SESSION['userid'])) {
$userid = $_SESSION['userid'];
}

$stmt = $conn->prepare("SELECT role FROM tblusers WHERE userid=?");
$stmt->bindParam(1, $userid, PDO::PARAM_INT);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if (($row["role"] != 1))
{   
    echo "Invalid Credentials";
    echo '<br><br><a href="login.php">Log in with an admin account</a>';
    exit();
}
?>


