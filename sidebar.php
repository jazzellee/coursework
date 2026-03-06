<?php

include_once('connection.php');

/* displays current user */
echo('<a href="userdetails.php">');
include_once('displayuserdetails.php');
echo('</a>');

/* displays products and its separate sections */
echo('<a href="displayproducts.php">Products</a>');

?>
