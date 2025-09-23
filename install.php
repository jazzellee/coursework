<?php

$servername = 'localhost';
$username = 'root';
$password= '';

try {
 $conn = new PDO("mysql:host=$servername", $username, $password);
 $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 $sql = "CREATE DATABASE IF NOT EXISTS webshop";
 $conn->exec($sql);
 $sql = "USE webshop";
 $conn->exec($sql);
 
//creates tblusers
$stmt = $conn->prepare("DROP TABLE IF EXISTS tblusers;
CREATE TABLE tblusers 
(userid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
email VARCHAR(76) NOT NULL,
password VARCHAR(255) NOT NULL,
forename VARCHAR(255) NOT NULL,
surname VARCHAR(255) NOT NULL,
role TINYINT(1) NOT NULL)"
);
$stmt->execute();
$stmt->closeCursor();
echo("tblusers created");

//creates tblorders
$stmt = $conn->prepare("DROP TABLE IF EXISTS tblorders;
CREATE TABLE tblorders
(orderid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
userid INT(6) NOT NULL,
date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
paid TINYINT(1) NOT NULL,
status TINYINT(3) NOT NULL
)"
);
$stmt->execute();
$stmt->closeCursor();
echo("tblorders created");

//creates tblproducts
$stmt = $conn->prepare("DROP TABLE IF EXISTS tblproducts;
CREATE TABLE tblproducts 
(productid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
productname VARCHAR(255) NOT NULL,
stock INT(6) NOT NULL,
heldstock INT(6) NOT NULL,
price DECIMAL(10,2) NOT NULL,
description VARCHAR(2047) NOT NULL,
dimensions VARCHAR(255),
size VARCHAR(255))"
);
$stmt->execute();
$stmt->closeCursor();
echo("tblproducts created");


//creates tblcart
$stmt = $conn->prepare("DROP TABLE IF EXISTS tblcart;
CREATE TABLE tblcart 
(cartid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
orderid INT(6) NOT NULL,
productid INT(6) NOT NULL,
quantity INT(6) NOT NULL)"
);
$stmt->execute();
$stmt->closeCursor();
echo("tblcart created");

}
catch(PDOException $e)
{
    echo $sql . "<br>" . $e->getMessage();
}
$conn=Null;
?>