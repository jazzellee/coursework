<?php
session_start();
include_once("connection.php");

//creates cart if not created
if (!isset($_SESSION["item"]) || !is_array($_SESSION["item"])) {
    $_SESSION["item"] = array();
}


//product already in array
$found=FALSE;


foreach ($_SESSION["item"] as &$entry){
    
    if ($entry["item"] === $_POST["productid"]){
        $found = TRUE;
        //increase existing qty in cart
        $entry["qty"] = $entry["qty"] + $_POST["qty"];
        
        
    }
}


//product not in array
if ($found === FALSE){
    array_push($_SESSION["item"],array("item"=>$_POST["productid"],"qty"=>$_POST["qty"]));
}

//update stock
$stmt = $conn->prepare("UPDATE tblproducts SET stock = stock-:qty WHERE productid=:productid");
$stmt->bindParam(':productid', $_POST["productid"]);
$stmt->bindParam(':qty', $_POST["qty"]);
$stmt->execute();
$stmt->closeCursor();

header('Location: displayproducts.php');
exit();

?>

