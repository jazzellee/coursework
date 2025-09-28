<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
  
   <title>Login</title>
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

<form action="loginprocess.php" method= "POST">
 Email:<input type="text" name="email" required><br>
 Password:<input type="password" name="passwd" required><br>
  <input type="submit" value="Login">
</form>

<div class="signup-link">
            Don't have an account? <a href="users.php">Sign Up Here</a>
        </div>
</form>


</body>
</html


