<!DOCTYPE html>
<html>
<head>
    
    <title>Orders</title>
    
</head>
<body>
    <form action="addorders.php" method="POST">
    User ID: <input type="text" name="userid"><br>
    Date Ordered:<input type="date" name="date"><br>
    <br>
    <!--radio buttons-->
    <input type="radio" name="paid" value="User" checked> User<br>
    <input type="radio" name="paid" value="Admin"> Admin<br>
    <input type="submit" value="Add User">

    <input type="radio" name="status" value="User" checked> User<br>
    <input type="radio" name="status" value="Admin"> Admin<br>
    <input type="radio" name="status" value="Admin"> Admin<br>
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