<?php
session_start();
include_once("connection.php");

if (isset($_POST["productid"])) {
    array_map("htmlspecialchars", $_POST);
    
    $stmt = $conn->prepare("DELETE FROM tblproducts WHERE productid = :productid");
    $stmt->bindParam(":productid", $_POST["productid"]);
    $stmt->execute();
    
    header('Location: displayproducts.php');
    exit();

} else {
    echo "Invalid request.";
} 

$conn = null;
?>


