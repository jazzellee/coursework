<?php
session_start();
include_once("connection.php");
include_once("adminverify.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Orders Display</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
include_once("navbar.php");
?>
   <!-- table to dsplay all orders -->
    <h1>All Orders</h1>
    <table>
        <tr>
        <th>Order No.</th>
        <th>User ID</th>
        <th>Items</th>
        <th>Order Date</th>
        <th>Price</th>
        <th>Status</th>
        </tr>

    <!-- nested while loops to fetch all order details from linked database tables -->
    <?php
    $stmt = $conn->prepare("SELECT * FROM tblorders");
    $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $orderid = $row["orderid"];
            $date = $row["date"];
            $userid = $row["userid"];
            $status = $row["status"];
        

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

            /* outputting table */

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
                ."<td>".$userid."</td>"
                ."<td>".$total." items</td>"
                ."<td>".$date."</td>"
                ."<td>£".number_format($totalprice,2)."</td>"
                ."<td>"
                ."<form method='post' action='changestatus.php'>"
                ."<input type='hidden' name='orderid' value='".$orderid."'>"
                ."<select name='status'>"
                ."<option value=''></option>"
                ."<option value= 0 " . (($status === 0) ? "selected" : "") . ">Processing</option>"
                ."<option value= 1  " . (($status === 1) ? "selected" : "") . ">Dispatched</option>"
                ."<option value= 2 " . (($status === 2) ? "selected" : "") . ">Out for Delivery</option>"
                ."<option value= 3 " . (($status === 3) ? "selected" : "") . ">Delivered</option>"
                ."<option value= 4 " . (($status === 4) ? "selected" : "") . ">Cancelled</option>"
                ."</select>"
                ."<button class='hover-button' type='submit'>Update Status</button>"
                ."</form>"
                ."</td></tr>");
        }   
            


    $stmt->closeCursor(); 
    ?>
    </table>
</body>
</html>