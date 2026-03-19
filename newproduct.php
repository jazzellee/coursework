<?php
session_start();
include_once("loginredirect.php");
include_once("adminverify.php");
?>


<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php
include_once("navbar.php");
?>

    <form action="addproducts.php" method="POST" enctype="multipart/form-data"> <!-- enctype to make files work -->

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
    <label for="image">Product Image:</label>
    <input type="file" name="image" accept="image/*" required><br>
    <input type="submit" value="Add Product">
    </form>


    <h2><a href="adminproducts.php">All Products</a></h2>
    <table>
        <tr>
            <th>Name</th>
            <th>Type</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Description</th>
            <th>Dimensions</th>
            <th>Size</th>
        </tr>
    <?php //displays all products in the system
    include_once("connection.php");
    $stmt = $conn->prepare("SELECT * FROM tblproducts");
    $stmt->execute();
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            if ($row["type"] == 0) {
                $row["type"] = "Artwork";

            } else if ($row["type"] == 1) {
                $row["type"] = "Clothing";
            }
            
            echo("<tr><td><a class='product-details-image-link' href='productdetails.php?productid=".$row["productid"]."'><img src='images/".$row["image"]."'><span class='product-details-overlay'><span class='product-details-overlay-text'>See Details</span></span></a><br><a href='productdetails.php?productid=".$row["productid"]."'>".$row["productname"]."</a></td><td>".$row["type"]."</td><td>£".number_format($row["price"],2)."</td><td>".$row["stock"]."</td><td>".$row["description"]."</td><td>".$row["dimensions"]."</td><td>".$row["size"]."</td></tr>");
        }
    $stmt->closeCursor();
    ?>
    </table>

</body>
</html>




