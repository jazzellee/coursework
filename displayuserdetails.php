<!DOCTYPE html>
<html>
<head>
    
    <title>User Details</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        .user-details {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-details h2 {
            margin: 0;
        }
    </style>

</head>
<body>
    <div class="user-details">
    <img src="images/content/user-icon.png" style="width: 20px; height: auto;">
    <h2>
    <?php
    //displays name of the user that is currently logged in
    if (isset($_SESSION['userid'])) {
        $userid = $_SESSION['userid'];
    }else{
        echo('<a href="login.php">Log In</a><br><br>');
    }


    /* fetch name using session userid */
    include_once("connection.php");
    $stmt = $conn->prepare("SELECT forename, surname FROM tblusers WHERE userid = ?");
    $stmt->bindParam(1, $userid, PDO::PARAM_INT);
    $stmt->execute();
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            echo($row["forename"]." ".$row["surname"]);
        }
    ?></h2>
    </div>
    <br><br>

</body>
</html>

