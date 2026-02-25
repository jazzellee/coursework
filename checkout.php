<?php
session_start();
include_once("connection.php");

    try {
        array_map("htmlspecialchars", $_POST);
        $userid = $_SESSION['userid'];
        //creates order
        $stmt = $conn->prepare("INSERT INTO tblorders (orderid, userid, date)
            VALUES (NULL, :userid, NULL)");

        $stmt->bindParam(':userid', $userid);
        $stmt->execute();
        $lastorderid = $conn->lastInsertId();

    } catch (PDOException $e) { 
        error_log("Database error: " . $e->getMessage());
        echo "An error occurred. Please try again later.";
    }


//processes the array and adds entries to checkout basket, then updates stock
foreach ($_SESSION['item'] as $entry) {
    try {
        $stmt = $conn->prepare("INSERT INTO tblcart (cartid, orderid, productid, quantity)
            VALUES (NULL, :orderid, :productid, :quantity)");

        $stmt->bindValue(':orderid', $lastorderid, PDO::PARAM_INT);
        $stmt->bindValue(':productid', $entry['item'], PDO::PARAM_INT);
        $stmt->bindValue(':quantity', $entry['qty'], PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

    
    } catch (PDOException $e) { 
        error_log("Database error: " . $e->getMessage());
        echo "An error occurred. Please try again later.";
    }
}


$conn = null;
unset($_SESSION["item"]);
header('Location: homepage.php');
exit();
?>



