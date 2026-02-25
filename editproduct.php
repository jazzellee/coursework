<?php
session_start();
include_once("loginredirect.php");
include_once("adminverify.php");
include_once("displayuserdetails.php");


if (isset($_REQUEST["productid"])) {
    $productIdParam = htmlspecialchars($_REQUEST["productid"]);
    
    $stmt = $conn->prepare("SELECT * FROM tblproducts WHERE productid = :productid");
    $stmt->bindParam(":productid", $productIdParam);
    $stmt->execute();
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $productid = $row["productid"];
            $type = $row["type"];
            $stock = $row["stock"];
            $price = $row["price"];
            $description = $row["description"];
            $dimensions = $row["dimensions"];
            $size = $row["size"];
            $productname = $row["productname"];
        }
}

?>


<!DOCTYPE html>
<html>
<head>
    
    <title>Edit Product</title>
    
</head>
<body>
    <h3><?php echo($productname); ?></h3>
    <p>Product ID: <?php echo($productid); ?></p>

    <!-- Form with pre-filled values for editing product details -->
    <form action="editprod.php" method="POST">

    <label for="type">Product Type:</label>
    <select name="type">
        <option value=""></option>
        <option value="Artwork" <?php echo ($type === 0) ? "selected" : ""; ?>>Artwork</option>
        <option value="Clothing" <?php echo ($type === 1) ? "selected" : ""; ?>>Clothing</option>
    </select><br>
    <br>
    Product Name:<input type="text" name="productname" value="<?php echo ($productname); ?>"><br>
    Stock:<input type="number" name="stock" min="0" max="999999" value="<?php echo ($stock); ?>"><br>
    Price: £<input type="number" name="price" min="0.00" max="99999999.99" step="0.01" value="<?php echo ($price); ?>"><br>
    Description:<input type="text" name="description" value="<?php echo ($description); ?>"><br>
    Dimensions:<input type="text" name="dimensions" value="<?php echo ($dimensions); ?>"><br>
    <label for="size">Size:</label>
    <select name="size">
        <option value=""></option>
        <option value="S" <?php echo ($size === "S") ? "selected" : ""; ?>>S</option>
        <option value="M" <?php echo ($size === "M") ? "selected" : ""; ?>>M</option>
        <option value="L" <?php echo ($size === "L") ? "selected" : ""; ?>>L</option>
    </select><br>
    <input type='hidden' name='productid' value="<?php echo ($productid); ?>">
    <button type='submit' title='Confirm'>Confirm</button>
    </form>

    <form action="deleteproduct.php" method="POST">
        <input type="hidden" name="productid" value="<?php echo ($productid); ?>">
        <button type="submit" onclick="return confirm('Delete product?');">Delete Product</button>
    </form>

</body>
</html>




