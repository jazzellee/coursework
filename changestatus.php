<?php
session_start();
include_once("connection.php");
include_once("adminverify.php");

/* sql statement to update status if orderid and status are set an status is not blank */
if (isset ($_POST["orderid"], $_POST["status"]) && ($_POST["status"] !== "")) {
    $orderid = $_POST["orderid"];
    $status = $_POST["status"];

    $stmt = $conn->prepare("UPDATE tblorders SET status = :status WHERE orderid = :orderid");
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->bindParam(':orderid', $orderid, PDO::PARAM_INT);
    $stmt->execute();

    header("Location: adminorders.php");
    exit();

} else { /* no orderid or status set -> redirect link */
    echo "Invalid request";
    echo "<br><a href='adminorders.php'>Back to All Orders</a>";
    exit();
}
?>