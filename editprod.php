<?php
session_start();
include_once("connection.php");

if (isset($_POST['productid'])) {
    array_map("htmlspecialchars", $_POST);


    switch ($_POST["type"]) {
    case "Artwork":
        $type = 0;
        break;
    case "Clothing":
        $type = 1;
        break;
    default:
        $type = null;
} 

    
/* Partial SQL statement to update only fields that were submitted */
    try {
        $update = [];
        $params = [':productid' => $_POST["productid"]];

        foreach (['productname', 'stock', 'price', 'description', 'dimensions', 'size'] as $field) {
            if (!empty($_POST[$field])) {
                $update[] = "$field = :$field";
                $params[":$field"] = $_POST[$field];
            }
        }

        if (!empty($_POST["type"])) {
            $update[] = "type = :type";
            $params[':type'] = $type;
        }

        if (!empty($update)) {
            $sql = "UPDATE tblproducts SET " . implode(", ", $update) . " WHERE productid = :productid";
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);

            header('Location: editproduct.php?productid=' . $_POST["productid"]);
            exit();
        } else {
            echo "No fields to update.";
        }

    } catch (PDOException $e) { 
        error_log("Database error: " . $e->getMessage());
        echo "An error occurred. Please try again later.";
    }

} else {
    echo "No productid provided.";
    echo '<br><br> <a href="adminproducts.php">Back to Products</a>';
}

$conn = null;
?>
