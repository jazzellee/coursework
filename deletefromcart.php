<?php
session_start();

$entry["quantity"]=$entry["quantity"]-1;

//update stock
$stmt = $conn->prepare("UPDATE tblproducts SET quantity=quantity+1 WHERE productid=:productid");
$stmt->bindParam(':productid', $entry["item"]);
$stmt->execute();
$stmt->closeCursor(); 


if ($entry["quantity"] <= 0) {
    // Removes item from cart if quantity is zero or less
    foreach ($_SESSION["item"] as $key => $item) {
        if ($item["item"] === $entry["item"]) {
            unset($_SESSION["item"][$key]);
            break;
        }
    }
    // Reindexes the array to maintain proper indices
    $_SESSION["item"] = array_values($_SESSION["item"]);
}

header('Location: viewcart.php');

?>