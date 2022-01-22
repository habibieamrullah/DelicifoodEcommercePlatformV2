<?php

//General configuration
$websitename = "Delicifood";
$websitetitle = "Delicifood Ecommerce Platform V2";
$websitetags = "ecommerce, platform, php, source code";
$baseurl = "http://localhost/ThirteeNov/Delicifood2/";
$currencysymbol = "$";
$maxgalleryimg = 100; //Maximum amount of images a user can add to the image gallery.
$maxpaginationresult = 12;
$prettyUrl = false;

//Site UI language: en (English), id (Bahasa Indonesia)
$defaultlang = "en";

//Appearance & color settings
$primarycolor = "#9503f1";
$primarycolordarker = "#7e00ce";
$bodybg = "#cbcbcb";

//Google Map API Key
$gmapapi = "YOUR_API_KEY";

//Mailing settings
$emailhost = "mail.somedomain.com";
$emailusername = "username@somedomain.com"; // Change it to yours
$emailpassword = "somepassword";

//Database connection
$host = "localhost";
$dbuser = "root";
$dbpassword = "";
$databasename = "mydatabase";
$databaseprefix = "delicifood_";
$connection = mysqli_connect($host, $dbuser, $dbpassword, $databasename);
$connection->set_charset("utf8");

//Database tables
$tableusers = $databaseprefix . "users";
$tableproducts = $databaseprefix . "products";
$tablemessages = $databaseprefix . "messages";
$tableconversations = $databaseprefix . "conversations";
$tablegallery = $databaseprefix . "gallery";
$tablecategories = $databaseprefix . "categories";

//Creating user registration table
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $tableusers (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
userid VARCHAR(50) NOT NULL,
datereg VARCHAR(50) NOT NULL,
name VARCHAR(50) NOT NULL,
email VARCHAR(50) NOT NULL,
password VARCHAR(50) NOT NULL,
phone VARCHAR(50) NOT NULL,
address VARCHAR(150) NOT NULL,
isonline INT(6),
waenabled INT(6),
lastonline VARCHAR(50) NOT NULL,
latlng VARCHAR(50) NOT NULL
)");

//Creating user products table
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $tableproducts (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
userid VARCHAR(30) NOT NULL,
productid VARCHAR(30) NOT NULL,
title VARCHAR(200) NOT NULL,
price FLOAT(6),
description VARCHAR(4000) NOT NULL,
ext VARCHAR(10) NOT NULL,
moreimages VARCHAR(500) NOT NULL,
catid INT(6),
views INT(6),
lastviewer VARCHAR(15) NOT NULL
)");


//Creating messages table
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $tablemessages (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
userid VARCHAR(50) NOT NULL,
productid VARCHAR(50) NOT NULL,
messageid VARCHAR(50) NOT NULL,
offlinemessage INT(6),
senderemail VARCHAR(50) NOT NULL
)");

//Creating conversations table
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $tableconversations (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
messageid VARCHAR(50) NOT NULL,
timestamp VARCHAR(50) NOT NULL,
fromseller INT(6),
isread INT(6),
content VARCHAR(500) NOT NULL
)");

//Creating gallery table
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $tablegallery (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
userid VARCHAR(50) NOT NULL,
imagefile VARCHAR(200) NOT NULL,
ext VARCHAR(10) NOT NULL
)");

//Creating categories table
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $tablecategories (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
category VARCHAR(50) NOT NULL,
faicon VARCHAR(20) NOT NULL
)");

//Creating upload folder
if(!file_exists("upload"))
	mkdir("upload");

//SuperAdmin credentials
$sausername = "admin";
$sapassword = "admin";

?>
