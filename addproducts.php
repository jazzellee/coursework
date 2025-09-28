<?php
include_once("connection.php");


if (
    isset($_POST["type"], $_POST["productname"], $_POST["stock"], $_POST["price"], $_POST["description"], $_POST["dimensions"], $_POST["size"])
) {
    array_map("htmlspecialchars", $_POST);
}


try {
    $stmt = $conn->prepare("INSERT INTO tblproducts (productid, type, productname, stock, price, description, dimensions, size)
        VALUES (NULL, :type, :productname, :stock, :price, :description, dimensions, size)");

    $stmt->bindParam(':type', $_POST["type"]);
    $stmt->bindParam(':productname', $_POST["productname"]);
    $stmt->bindParam(':stock', $_POST["stock"]);
    $stmt->bindParam(':price', $_POST["price"]);
    $stmt->bindParam(':description', $_POST["description"]);
    $stmt->bindParam(':dimensions', $_POST["dimensions"]);
    $stmt->bindParam(':size', $_POST["size"]);
    $stmt->execute();
  
    header('Location: newproduct.php');
    exit();
} catch (PDOException $e) { 
    error_log("Database error: " . $e->getMessage());
    echo "An error occurred. Please try again later.";
}

$conn = null;
?>



