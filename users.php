<!DOCTYPE html>
<html>
<head>
    
    <title>Users</title>
    
</head>
<body>
    <form action="addusers.php" method="POST">
    First name:<input type="text" name="forename"><br>
    Last name:<input type="text" name="surname"><br>
    Email Address:<input type="text" name="email"><br>
    Password:<input type="password" name="password"><br>
    Date of Birth:<input type="date" name="dob"><br>
    <br>
    <!--role radio button-->
    <input type="radio" name="role" value="User" checked> User<br>
    <input type="radio" name="role" value="Admin"> Admin<br>
    <input type="submit" value="Add User">
    </form>
    <h2>Current users</h2>
    <?php
    include_once("connection.php");
    $stmt = $conn->prepare("SELECT * FROM tblusers");
    $stmt->execute();
    while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            #print_r($row);
            echo($row["forename"]." ".$row["surname"]."<br>");
        }

    ?>

</body>
</html>