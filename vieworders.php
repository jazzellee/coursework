<?php
session_start();
include_once("connection.php");
include_once("loginredirect.php");

function getOrderStatusLabel($status)
{
    switch ((int)$status) {
        case 0:
            return "Processing";
        case 1:
            return "Dispatched";
        case 2:
            return "Out for Delivery";
        case 3:
            return "Delivered";
        case 4:
            return "Cancelled";
        default:
            return "Unknown";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Orders</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
$stmt = $conn->prepare("SELECT forename FROM tblusers WHERE userid = ?");
$stmt->bindParam(1, $_SESSION['userid'], PDO::PARAM_INT);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);
$forename = $row["forename"];
$stmt->closeCursor();

echo("<h1>" . htmlspecialchars($forename) . "'s Orders</h1>");
?>

    <table>
        <tr>
        <th>Order No.</th>
        <th>Items</th>
        <th>Order Date</th>
        <th>Price</th>
        <th>Status</th>
        </tr>

    <?php
    $stmt = $conn->prepare("SELECT orderid, date, status FROM tblorders WHERE userid = ? ORDER BY date DESC");
    $stmt->bindParam(1, $_SESSION['userid'], PDO::PARAM_INT);
    $stmt->execute();

    $hasorders = FALSE;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $hasorders = TRUE;

        $orderid = $row["orderid"];
        $date = $row["date"];
        $status = getOrderStatusLabel($row["status"]);
        $items = [];
        $total = 0;

        $stmt2 = $conn->prepare("SELECT productid, quantity FROM tblcart WHERE orderid = ? ORDER BY cartid ASC");
        $stmt2->bindParam(1, $orderid, PDO::PARAM_INT);
        $stmt2->execute();

        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
            $productid = $row2["productid"];
            $qty = $row2["quantity"];

            $stmt3 = $conn->prepare("SELECT productname, price FROM tblproducts WHERE productid = ?");
            $stmt3->bindParam(1, $productid, PDO::PARAM_INT);
            $stmt3->execute();

            while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC)) {
                $productname = $row3["productname"];
                $price = $row3["price"];

                $items[] = $productname . " x " . $qty;
                $total += ($price * $qty);
            }

            $stmt3->closeCursor();
        }
        $stmt2->closeCursor();

        $itemText = empty($items) ? "-" : implode(", ", $items);

        echo("<tr>");
        echo("<td>" . $orderid . "</td>");
        echo("<td>" . htmlspecialchars($itemText) . "</td>");
        echo("<td>" . $date . "</td>");
        echo("<td>£" . number_format($total, 2) . "</td>");
        echo("<td>" . $status . "</td>");
        echo("</tr>");
    }

    $stmt->closeCursor();

    if (!$hasorders) {
        echo('<tr><td colspan="5">No orders found.</td></tr>');
    }
    ?>
    </table>
</body>
</html>


