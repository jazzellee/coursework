<?php
session_start(); //prevents session bypass

include_once ("loginredirect.php");
include_once ("connection.php");
array_map("htmlspecialchars", $_POST);
$stmt = $conn->prepare("SELECT * FROM tblusers WHERE email = :email ;" );
$stmt->bindParam(':email', $_POST['email']);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{  
    $hashed = $row["password"]; //stored password hash
    $attempt = $_POST['passwd'];
    if(password_verify($attempt,$hashed)){
        $_SESSION['name']=$row["userid"];
        if (!isset($_SESSION['backURL'])){
            $backURL= "homepage.php"; //sets a default destination if no backURL set (parent directory)
        }else{
            $backURL=$_SESSION['backURL'];
        }
        unset($_SESSION['backURL']);
        header('Location: ' . $backURL);
    }else{
        header('Location: login.php');
    }

}


?>


