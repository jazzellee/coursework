<?php

session_start();
include_once('connection.php');
include_once('loginredirect.php');

/* displays current user */
include_once('displayuserdetails.php');

/* log out button */
echo('<a href="logout.php">Log out</a><br><br>');

/* link to orders */
echo('<a href="vieworders.php">Orders</a><br><br>');

/* delete account */
echo('<a href="deleteuser.php" style="color: red;">Delete Account</a><br><br>');

/* back button */
echo('<a href="homepage.php">Back</a>');


?>