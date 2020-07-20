<?php

//General configuration
$websitename = "Delicifood";
$websitetitle = "Delicifood Ecommerce Platform V2";
$websitetags = "ecommerce, platform, php, source code";
$baseurl = "https://localhost/delicifood/index.php";
$currencysymbol = "$";
$maxgalleryimg = 100; //Maximum amount of images a user can add to the image gallery.

//Site UI language: en (English), id (Bahasa Indonesia)
$defaultlang = "en";

//Appearance & color settings
$primarycolor = "#9503f1";
$primarycolordarker = "#7e00ce";
$bodybg = "#cbcbcb";

//Mailing settings
$emailhost = "mail.somedomain.com";
$emailusername = "username@somedomain.com"; // Change it to yours
$emailpassword = "somepassword";

//Database connection
$host = "localhost";
$dbuser = "root";
$dbpassword = "xxx";
$databasename = "somedatabase";
$databaseprefix = "delicifood_";
$connection = mysqli_connect($host, $dbuser, $dbpassword, $databasename);
$connection->set_charset("utf8");

//Database tables
$tableusers = $databaseprefix . "users";
$tableproducts = $databaseprefix . "products";
$tablemessages = $databaseprefix . "messages";
$tableconversations = $databaseprefix . "conversations";
$tablegallery = $databaseprefix . "gallery";

//Creating user registration table
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $tableusers (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
userid VARCHAR(30) NOT NULL,
datereg VARCHAR(30) NOT NULL,
name VARCHAR(30) NOT NULL,
email VARCHAR(30) NOT NULL,
password VARCHAR(30) NOT NULL,
phone VARCHAR(30) NOT NULL,
address VARCHAR(150) NOT NULL,
isonline INT(6),
waenabled INT(6),
lastonline VARCHAR(50) NOT NULL
)");

//Creating user products table
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $tableproducts (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
userid VARCHAR(30) NOT NULL,
productid VARCHAR(30) NOT NULL,
title VARCHAR(100) NOT NULL,
price INT(6),
description VARCHAR(500) NOT NULL,
ext VARCHAR(10) NOT NULL,
moreimages VARCHAR(500) NOT NULL
)");


//Creating messages table
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $tablemessages (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
userid VARCHAR(30) NOT NULL,
productid VARCHAR(30) NOT NULL,
messageid VARCHAR(30) NOT NULL,
offlinemessage INT(6),
senderemail VARCHAR(30) NOT NULL
)");

//Creating conversations table
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $tableconversations (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
messageid VARCHAR(30) NOT NULL,
timestamp VARCHAR(30) NOT NULL,
fromseller INT(6),
isread INT(6),
content VARCHAR(500) NOT NULL
)");

//Creating gallery table
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $tablegallery (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
userid VARCHAR(30) NOT NULL,
imagefile VARCHAR(200) NOT NULL,
ext VARCHAR(10) NOT NULL,
)");

//Creating upload folder
if(!file_exists("upload"))
	mkdir("upload");


?>