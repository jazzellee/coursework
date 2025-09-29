<?php
session_start();
include_once("connection.php");

    try {
        array_map("htmlspecialchars", $_POST);
        $userid = $_SESSION['name'];
        //creates order
        $stmt = $conn->prepare("INSERT INTO tblorders (orderid, userid, date, paid, status)
            VALUES (NULL, :userid, NULL, NULL, NULL)");

        $stmt->bindParam(':userid', $userid);
        $stmt->execute();
        $orderid = $conn->lastInsertId();

        header('Location: newproduct.php');
        exit();
    } catch (PDOException $e) { 
        error_log("Database error: " . $e->getMessage());
        echo "An error occurred. Please try again later.";
    }


//processes the array and adds entries to cart
foreach ($_SESSION['cart'] as $entry) {
    try {
        $stmt = $conn->prepare("INSERT INTO tblcart (cartid, orderid, productid, quantity)
            VALUES (NULL, :orderid, :productid, :quantity)");

        $stmt->bindParam(':orderid', $orderid);
        $stmt->bindParam(':productid', $productid);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->execute();
    
    } catch (PDOException $e) { 
        error_log("Database error: " . $e->getMessage());
        echo "An error occurred. Please try again later.";
    }
}

$conn = null;
?>



