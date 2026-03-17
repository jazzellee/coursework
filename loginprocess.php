<?php
session_start();
include_once ("connection.php");
array_map("htmlspecialchars", $_POST);

$stmt = $conn->prepare("SELECT * FROM tblusers WHERE email = :email ;" );
$stmt->bindParam(':email', $_POST['email']);
$stmt->execute();

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $hashed = $row["password"]; // stored password hash
    $attempt = $_POST['passwd'];

    if (password_verify($attempt, $hashed)) {
        $_SESSION['userid'] = $row["userid"];

        if (isset($_SESSION['backURL'])) { /* backurl if there is prev. page */
            $backURL = $_SESSION['backURL'];
            unset($_SESSION['backURL']);
            header('Location: ' . $backURL);

        } elseif($row["role"] == 1) { /* admin homepage if no backurl */
            header('Location: adminhome.php');

        } else { /* user homepage if no backurl */
            header('Location: homepage.php');
        }
        
        exit();
    }
}

// Redirect to login page on failure
header('Location: login.php');
exit();
?>


