<?php
session_start();
include_once("connection.php");

if (!isset($_POST['productid'])) {
    header('Location: viewcart.php');
    exit();
}
$productid = (int) $_POST['productid'];

//redirects back to viewcart if no cart
if (!isset($_SESSION["item"]) || !is_array($_SESSION["item"])){
    header('Location: viewcart.php');
    exit();
}

$found = false;

//finds corresponding item in session cart and decrements quantity by 1
foreach ($_SESSION["item"] as $key => $entry) {
    if ((int)$entry["item"] === $productid) {
        $found = true;
        $newqty = (int)$entry["qty"] - 1;

        if ($newqty > 0) {
            // update session qty directly
            $_SESSION["item"][$key]["qty"] = $newqty;
        } else {
            // remove item from cart
            unset($_SESSION["item"][$key]);
        }

        // update stock in tblproducts
        $stmt = $conn->prepare("UPDATE tblproducts SET stock = stock + 1 WHERE productid = :productid");
        $stmt->bindValue(':productid', $productid, PDO::PARAM_INT);
        $stmt->execute();
        $stmt->closeCursor();

        break;
    }
}


if ($found) {
    // Reindexes the array to maintain proper indices after any unset
    $_SESSION["item"] = array_values($_SESSION["item"]);
}

    header('Location: viewcart.php');

?>