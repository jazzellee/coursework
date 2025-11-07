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
    First name:<input type="text" name="forename" required><br>
    Last name:<input type="text" name="surname" required><br>
    Email Address:<input type="text" name="email" required><br>
    Password:<input type="password" name="password" required><br>
    Date of Birth:<input type="date" name="dob" required><br>
    <br>
    <!--role radio button-->
    <input type="radio" name="role" value="User" checked> User<br>
    <input type="radio" name="role" value="Admin"> Admin<br>
    <input type="submit" value="Add User">
    </form>

    <div class="signup-link">
            Have an account? <a href="login.php">Log In Here</a>
        </div>

    

</body>
</html>