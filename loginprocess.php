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
        $_SESSION['name'] = $row["userid"];
        $backURL = isset($_SESSION['backURL']) ? $_SESSION['backURL'] : "homepage.php"; // sets a default destination if no backURL set
        unset($_SESSION['backURL']);
        header('Location: ' . $backURL);
        exit();
    }
}

// Redirect to login page on failure
header('Location: login.php');
exit();
?>


