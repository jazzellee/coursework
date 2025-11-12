<?php
session_start();
include_once("connection.php");

 
if (
    isset($_POST["forename"], $_POST["surname"], $_POST["email"], $_POST["password"], $_POST["email"], $_POST["role"])
) {
    array_map("htmlspecialchars", $_POST);

    switch ($_POST["role"]) {
        case "User":
            $role = 0;
            break;
        case "Admin":
            $role = 1;
            break;
        default:
            $role = null;
    } 

    if ($role !== null) {
        try {
			$pw = password_hash($_POST["password"], PASSWORD_BCRYPT); // Password hashing
            $stmt = $conn->prepare("INSERT INTO tblusers (userid, forename, surname, email, password, role)
                VALUES (NULL, :forename, :surname, :email, :password, :role)");

            $stmt->bindParam(':forename', $_POST["forename"]);
            $stmt->bindParam(':surname', $_POST["surname"]);
            $stmt->bindParam(':email', $_POST["email"]);
            $stmt->bindParam(':password', $pw);
            $stmt->bindParam(':role', $role);

            $stmt->execute();
            
           header('Location: login.php');
            exit();
        } catch (PDOException $e) {
            
            error_log("Database error: " . $e->getMessage());
            echo "An error occurred. Please try again later.";
        }
    } else {
        echo "Invalid role provided.";
    }
} else {
    echo "Incomplete form submission.";
}

$conn = null;
?>