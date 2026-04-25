<?php
session_start();
include_once("connection.php");

/* return url to return to page where user added the product to cart */
function resolveReturnUrl($candidate) {
    if (!is_string($candidate) || $candidate === "") {
        return NULL;
    }

    if (strpos($candidate, "\r") !== FALSE || strpos($candidate, "\n") !== FALSE) {
        return NULL;
    }

    $parts = parse_url($candidate);
    if ($parts === FALSE) {
        return NULL;
    }

    if (isset($parts['scheme']) || isset($parts['host'])) {
        return NULL;
    }

    $path = $parts['path'] ?? "";
    if ($path === "" || !preg_match('/^[A-Za-z0-9_\-\.\/]+$/', $path)) {
        return NULL;
    }

    return $candidate;
}

//creates cart if not created
if (!isset($_SESSION["item"]) || !is_array($_SESSION["item"])) {
    $_SESSION["item"] = array();
}


//product already in array
$found = FALSE;


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

$backURL = 'displayproducts.php';

$postedReturnUrl = resolveReturnUrl($_POST['returnurl'] ?? '');
if ($postedReturnUrl !== NULL) {
    $backURL = $postedReturnUrl;
} else {
    $sessionReturnUrl = resolveReturnUrl($_SESSION['backURL'] ?? '');
    if ($sessionReturnUrl !== NULL) {
        $backURL = $sessionReturnUrl;
    }
}

header("Location: $backURL");
exit();

?>

