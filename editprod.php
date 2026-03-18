<?php
session_start();
include_once("connection.php");
include_once("adminverify.php");

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
            if (($_POST[$field])!=="") {
                $update[] = "$field = :$field";
                $params[":$field"] = $_POST[$field];
            }
        }

        if (!empty($_POST["type"])) {
            $update[] = "type = :type";
            $params[':type'] = $type;
        }

        if (isset($_FILES["image"])  && !empty($_FILES["image"]["name"])) {
            $target_dir = "images/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $update[] = "image = :image";
                $params[':image'] = $_FILES["image"]["name"];

                if (!empty($_POST["current_image"]) && $_POST["current_image"] !== $_FILES["image"]["name"]) {
                    $old_image = $target_dir . basename($_POST["current_image"]);
                    if (file_exists($old_image)) {
                        unlink($old_image);
                    }
                }
            } else {
                echo("Image upload failed.");
                exit();
            }
        }

        if (!empty($update)) {
            $sql = "UPDATE tblproducts SET " . implode(", ", $update) . " WHERE productid = :productid";
            $stmt = $conn->prepare($sql);
            $stmt->execute($params);

            header('Location: editproduct.php?productid=' . $_POST["productid"]);
            exit();
        } else {
            echo("No fields to update.");
        }

    } catch (PDOException $e) { 
        error_log("Database error: " . $e->getMessage());
        echo("An error occurred. Please try again later.");
    }

} else {
    echo("No productid provided.");
    echo('<br><br> <a href="adminproducts.php">Back to Products</a>');
}

$conn = null;
?>
