<?php
session_start();
include_once("loginredirect.php");
include_once("adminverify.php");
include_once("displayuserdetails.php");
?>


<!DOCTYPE html>
<html>
<head>
    
    <title>Products</title>
    
</head>
<body>
    <form action="addproducts.php" method="POST">
    <label for="type">Product Type:</label>
    <select name="type">
        <option value="Artwork">Artwork</option>
        <option value="Clothing">Clothing</option>
    </select><br>
    <br>
    Product Name:<input type="text" name="productname" required><br>
    Stock:<input type="number" name="stock" min="0" max="999999" required><br>
    Price: £<input type="number" name="price" min="0.00" max="99999999.99" step="0.01" required><br>
    Description:<input type="text" name="description" required value=""><br>
    Dimensions:<input type="text" name="dimensions"><br>
    <label for="size">Size:</label>
    <select name="size">
        <option value=""></option>
        <option value="S">S</option>
        <option value="M">M</option>
        <option value="L">L</option>
    </select><br>
    <input type="submit" value="Add Product">
    </form>

    
    <h2>All Products</h2>
    <?php //displays all products in the system
    include_once("connection.php");
    $stmt = $conn->prepare("SELECT * FROM tblproducts");
    $stmt->execute();
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            echo($row["productid"]." ".$row["type"]." ".$row["productname"]." ".$row["stock"]." ".$row["price"]." ".$row["description"]." ".$row["dimensions"]." ".$row["size"]."<br>");
        }

    ?>

</body>
</html>




