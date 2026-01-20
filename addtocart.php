<?php
session_start();
include_once("connection.php");

//creates basket if not created
if (!isset($_SESSION["item"]) || !is_array($_SESSION["item"])){
$_SESSION["item"] = array();
}



//product already in array
$found= FALSE;
foreach ($_SESSION["item"] as &$entry){
    
    if ((int)$entry["item"] === $_POST["productid"]){
        $found= TRUE;
        //increase existing quantity in cart
        $entry["quantity"]=$entry["quantity"]+ $_POST["quantity"];
        
        
    }
}


//product not in array
if ($found===FALSE){
    array_push($_SESSION["item"], array("item"=>$_POST["productid"], "quantity"=>$_POST["quantity"]));
}

//update stock
$stmt = $conn->prepare("UPDATE tblproducts SET stock=stock-:stock WHERE productid=:productid");
$stmt->bindParam(':productid', $_SESSION["item"], PDO::PARAM_INT);
$stmt->bindParam(':stock', $_SESSION["quantity"], PDO::PARAM_INT);
$stmt->execute();
$stmt->closeCursor();

header('Location: displayproducts.php');
exit();

?>

