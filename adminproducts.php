<?php
session_start();
include_once("connection.php");
include_once("adminverify.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Product Display</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
include_once("navbar.php");
?>

    <h1>Product Details (Admin):</h1>
    <table>
        <tr>
        <th>Name</th>
        <th>Type</th>
        <th>Price</th>
        <th>Stock</th>
        <th>Description</th>
        <th>Dimensions</th>
        <th>Size</th>
        <th style="visibility:hidden;">Edit</th>
        </tr>

    <?php
    $stmt = $conn->prepare("SELECT * FROM tblproducts");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            if ($row["type"] == 0) {
                $row["type"] = "Artwork";
                
            } else if ($row["type"] == 1) {
                $row["type"] = "Clothing";
            }

            echo("<tr class='product-row'><td><a href='productdetails.php?productid=".$row["productid"]."'><img src='images/".$row["image"]."'></a><a href='productdetails.php?productid=".$row["productid"]."'>".$row["productname"]."</a></td><td>".$row["type"]."</td><td> £".number_format($row["price"],2)."</td>"
                /* stock and update stock */
                ."<td>"
                ."<form method='post' action='updatestock.php'>"
                ."<input type='hidden' name='productid' value='".$row["productid"]."'>"
                ."<input type='number' name='stock' min='0' max='999999' step='1' value='".$row["stock"]."'>"
                ."<button class='hover-button' type='submit'>Update Stock</button>"
                ."</form>"
                ."</td><td>".$row["description"]."</td><td>".$row["dimensions"]."</td><td>".$row["size"]."</td><td>"
                /* edit product button */
                ."<form class='hover' method='post' action='editproduct.php'>"
                ."<input type='hidden' name='productid' value='".$row["productid"]."'>"
                ."<button class='hover-button' type='submit' title='edit'>Edit Product</button>"
                ."</form>"
                ."</td></tr>");
        }
    $stmt->closeCursor(); 
    ?>
    </table>
</body>
</html>


