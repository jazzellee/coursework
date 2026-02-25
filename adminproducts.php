<?php
session_start();
include_once("connection.php");
include_once("loginredirect.php");
include_once("displayuserdetails.php");
include_once("adminverify.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Product Display</title>
    <style>
        /* hover for edit button */
        .product-row { position: relative; }
        .edit { position: relative; left: 10px; }
        .edit-button { display: none; }
        .product-row:hover .edit-button { display: inline-block; }
    </style>
</head>
<body>

    <h1>Product Details (Admin):</h1>
    <table>
        <tr>
        <th>Name</th>
        <th>Price</th>
        <th>Stock</th>
        <th style="visibility:hidden;">Edit</th>

    <?php
    $stmt = $conn->prepare("SELECT * FROM tblproducts");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            echo("<tr class='product-row'><td>".$row["productname"]."</td><td> £".number_format($row["price"],2)."</td><td> ".$row["stock"]." </td>"
                ."<td>"
                ."<form class='edit' method='post' action='editproduct.php'>"
                ."<input type='hidden' name='productid' value='".$row["productid"]."'>"
                ."<button class='edit-button' type='submit' title='edit'>edit</button>"
                ."</form>"
                ."</td></tr>");
        }
    $stmt->closeCursor(); 
    ?>
</body>
</html>


