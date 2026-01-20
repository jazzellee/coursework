<?php
session_start();
include_once("connection.php");

//adds the held stock back into the database
foreach ($_SESSION['item'] as $entry) {
    try {
        $stmt = $conn->prepare("UPDATE tblproducts SET stock = stock +:qty WHERE productid=:productid");

        $stmt->bindParam(':productid', $entry["item"]);
        $stmt->bindParam(':quantity', $entry["quantity"]);
        $stmt->execute();
        $stmt->closeCursor();

    
    } catch (PDOException $e) { 
        error_log("Database error: " . $e->getMessage());
        echo "An error occurred. Please try again later.";
    }
}

unset($_SESSION["item"]);

?>