<?php
include_once("adminverify.php");
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
        <option value="Clothing">Clothing</option>
        <option value="Artwork">Artwork</option>
    </select><br>
    <br>
    Product Name:<input type="text" name="surname"><br>
    Stock:<input type="number" name="stock" min="0" max="999999"><br>
    Price: £<input type="number" name="price" min="0.00" max="99999999.99" step="0.01"><br>
    Description:<input type="text" name="description"><br>
    <input type="submit" value="Add Product">
    </form>
    <h2>All Products</h2>
    <?php
    include_once("connection.php");
    $stmt = $conn->prepare("SELECT * FROM tblproducts");
    $stmt->execute();
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            echo($row["productid"]." ".$row["productname"]." ".$row["stock"]." ".$row["price"]." ".$row["description"]." ".$row["dimensions"]." ".$row["size"]."<br>");
        }

    ?>

</body>
</html>

