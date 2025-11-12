<!DOCTYPE html>
<html>
<head>
    
    <title>User Details</title>

</head>
<body>
    <h2>Current User:
    <?php
    //displays name of the user that is currently logged in
    if (isset($_SESSION['name'])) {
        $userid = $_SESSION['name'];
    }else{
        echo('<a href="login.php">Log In</a><br><br>');
    }

    include_once("connection.php");
    $stmt = $conn->prepare("SELECT forename, surname FROM tblusers WHERE userid = ?");
    $stmt->bindParam(1, $userid, PDO::PARAM_INT);
    $stmt->execute();
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            echo($row["forename"]." ".$row["surname"]."<br>");
        }
    ?></h2>


</body>
</html>

