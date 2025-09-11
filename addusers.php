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
			$pw = password_hash($_POST["passwd"], PASSWORD_BCRYPT); // Secure password hashing
            $stmt = $conn->prepare("INSERT INTO tblusers (userid, forename, surname, password, dob, email, role)
                VALUES (:userid, :forename, :surname, :passwd, :dob, :email, :role)");

            $stmt->bindParam(':userid', $userid);
            $stmt->bindParam(':forename', $_POST["forename"]);
            $stmt->bindParam(':surname', $_POST["surname"]);
			$stmt->bindParam(':passwd', $pw);
			$stmt->bindParam(':dob', $_POST["dob"]);
            $stmt->bindParam(':email', $_POST["email"]);
            $stmt->bindParam(':role', $role);

            $stmt->execute();
        
        echo "User added"."</br>";
        echo "Your User ID is: ",$userid."</br>";
        echo "Remember this as there will be no reminders.";
            
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