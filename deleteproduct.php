<?php
session_start();
include_once("connection.php");
include_once("adminverify.php");

if (isset($_POST["productid"])) {
    array_map("htmlspecialchars", $_POST);

    /* fetches image path and deletes image from images folder */
    $imagestmt = $conn->prepare("SELECT image FROM tblproducts WHERE productid = :productid");
    $imagestmt->bindParam(":productid", $_POST["productid"]);
    $imagestmt->execute();
    $row = $imagestmt->fetch(PDO::FETCH_ASSOC);
    $image = $row["image"];

    if (!empty($image)) {
        unlink(__DIR__ . "/images/" . basename($image));
    }
    
    /* delete sql statement */
    $stmt = $conn->prepare("DELETE FROM tblproducts WHERE productid = :productid");
    $stmt->bindParam(":productid", $_POST["productid"]);
    $stmt->execute();
    
    header('Location: adminproducts.php');
    exit();

} else {
    echo("Invalid request.");
} 

$conn = null;
?>


