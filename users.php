<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Users</title>
   <style>
        .signup-link {
            margin-top: 25px;
            font-size: 14px;
            color: #555;
        }

        .signup-link a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .signup-link a:hover {
            color: #0056b3;
            text-decoration: underline;
        }
   </style>
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

    <div class="signup-link">
            Have an account? <a href="login.php">Log In Here</a>
        </div>

    </form>

</body>
</html>