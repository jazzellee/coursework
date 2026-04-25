<?php
    session_start();
    include_once("connection.php");
?>

<!DOCTYPE html>
<html>
<head>
    
    <title>Users</title>
    <link rel="stylesheet" href="styles.css">
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

<?php
include_once("navbar.php");
?>
    <!-- form to enter signup / account details -->
    <form action="addusers.php" method="POST">
    First name:<input type="text" name="forename" required><br>
    Last name:<input type="text" name="surname" required><br>
    Email Address:<input type="text" name="email" required><br>
    Password:<input type="password" name="password" required minlength="8" maxlength="20"><br>
    Date of Birth:<input type="date" name="dob" required><br>
    <input type="submit" value="Sign Up">
    </form>

    <div class="signup-link">
            Have an account? <a href="login.php">Log In Here</a>
        </div>

    

</body>
</html>