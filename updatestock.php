<?php
session_start();
include_once("connection.php");
include_once("adminverify.php");

if (isset($_POST['productid'])) {
    array_map("htmlspecialchars", $_POST);

    if ($_POST['stock'] !== ""){
        $stmt = $conn->prepare("UPDATE tblproducts SET stock = :stock WHERE productid = :productid");
        $stmt->bindParam(":productid", $_POST["productid"]);
        $stmt->bindParam(":stock", $_POST["stock"]);
        $stmt->execute();
    }
    
    header('Location: adminproducts.php');
    exit();

} else {
    echo "No productid provided.";
    echo '<br><br> <a href="adminproducts.php">Back to Products</a>';
}

$conn = null;
?>
