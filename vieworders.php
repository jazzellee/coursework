<?php
session_start();
include_once("connection.php");
include_once("loginredirect.php");
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

echo("<h1>" . $forename . "'s Orders</h1>");
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
    $stmt = $conn->prepare("SELECT * FROM tblorders WHERE userid = ?");
    $stmt->bindParam(1, $_SESSION['userid'], PDO::PARAM_INT);
    $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $orderid = $row["orderid"];
            $date = $row["date"];
            
            if ($row["status"] == 0) {
                $status = "Processing";

            } else if ($row["status"] == 1) {
                $status = "Dispatched";

            } else if ($row["status"] == 2) {
                $status = "Out for Delivery";

            } else if ($row["status"] == 3) {
                $status = "Delivered";

            } else if ($row["status"] == 4) {
                $status = "Cancelled";
            }

        $stmt2 = $conn->prepare("SELECT * FROM tblcart WHERE orderid = ?");
        $stmt2->bindParam(1, $orderid, PDO::PARAM_INT);
        $stmt2->execute();

        $total = 0;
        $totalprice = 0;
        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC))
            {
                $productid = $row2["productid"];
                $qty = $row2["quantity"];
                $total += $qty;

                $stmt3 = $conn->prepare("SELECT * FROM tblproducts WHERE productid = ?");
                $stmt3->bindParam(1, $productid, PDO::PARAM_INT);
                $stmt3->execute();

                while ($row3 = $stmt3->fetch(PDO::FETCH_ASSOC))
                    {
                        $price = $row3["price"];
                        $totalprice += ($price * $qty);
                    }
            }
            echo("<tr class='product-row'><td>".$orderid
                ."<form method='post' action='orderdetails.php'>"
                ."<input type='hidden' name='orderid' value='".$orderid."'>"
                ."<input type='hidden' name='status' value='".$status."'>"
                ."<input type='hidden' name='total' value='".$total."'>"
                ."<input type='hidden' name='date' value='".$date."'>"
                ."<input type='hidden' name='totalprice' value='".$totalprice."'>"
                ."<button class='hover-button' type='submit' title='Details'>View Details</button>"
                ."</form>"
                ."</td>"
                ."<td>".$total." items</td>"
                ."<td>".$date."</td>"
                ."<td>£".number_format($totalprice,2)."</td>"
                ."<td>".$status."</td></tr>");
        }   
            


    $stmt->closeCursor(); 
    ?>
    </table>
</body>
</html>


