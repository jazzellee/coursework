<?php
include_once ("connection.php");
array_map("htmlspecialchars", $_POST);
$stmt = $conn->prepare("SELECT * FROM tblusers WHERE Email = email ;" );
$stmt->bindParam(':username', $_POST['Username']);
$stmt->execute();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
{ 
    
    
    $pwcomp = password_hash($_POST["passwd"], PASSWORD_BCRYPT) //password hash
    
    if($row['password']== $pw){
        if($row['role'] == 1){
            header('Location: admin.php');
        }else{
            header('Location: users.php')
        }
    }else{

        header('Location: login.php');
    }
}





