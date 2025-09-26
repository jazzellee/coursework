<?php
session_start(); 
include_once ("loginredirect.php");
?>


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
    <input type="radio" name="paid" value="Unpaid" checked> Unpaid<br>
    <input type="radio" name="paid" value="Paid"> Paid<br>
    <br>

    <input type="radio" name="status" value="Preparing" checked> Preparing<br>
    <input type="radio" name="status" value="Dispatched "> Dispatched<br>
    <input type="radio" name="status" value="Out For Delivery"> Out for Delivery<br>
    <input type="radio" name="status" value="Delivered"> Delivered<br>
    <input type="submit" value="Submit">

    </form>
    <h2>Your Orders</h2>
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