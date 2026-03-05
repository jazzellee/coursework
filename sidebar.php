<?php

session_start();
include_once('connection.php');

/* displays current user */
include_once('displayuserdetails.php');

/* displays products and its separate sections */
echo '<a href="displayproducts.php">Products</a>'

?>