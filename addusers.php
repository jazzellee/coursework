<?php
include_once("connection.php");


if (
    isset($_POST["forename"], $_POST["surname"], $_POST["email"], $_POST["password"], $_POST["email"], $_POST["role"])
) {
    array_map("htmlspecialchars", $_POST);

    $useridhash = hash("sha256",($_POST["surname"] . $_POST["forename"]));
    $useridhash16 = hexdec(substr($useridhash, 0, 8));
    $useridhash16 = str_pad($useridhash16, 6, '0', STR_PAD_LEFT);
    $userid = substr($useridhash16, 0, 6);
    
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
		print_r($_POST,"\n");
			$pw = password_hash($_POST["password"], PASSWORD_BCRYPT); // Password hashing
            $stmt = $conn->prepare("INSERT INTO tblusers (userid, forename, surname, email, password, role)
                VALUES (:userid, :forename, :surname, :email, :password, :role)");

            $stmt->bindParam(':userid', $userid);
            $stmt->bindParam(':forename', $_POST["forename"]);
            $stmt->bindParam(':surname', $_POST["surname"]);
            $stmt->bindParam(':email', $_POST["email"]);
            $stmt->bindParam(':password', $pw);
            $stmt->bindParam(':role', $role);

            $stmt->execute();
        
        echo "User added"."</br>";
        echo "Your User ID is: ",$userid."</br>";
            
           header('Location: users.php');
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