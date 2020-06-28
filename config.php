<?php

//general configuration
$websitetitle = "Hubby | Home Cooks for everyone";
$baseurl = "https://alkalomeclat.com/hubby/index.php";

//appearance & color settings
$primarycolor = "#9503f1";
$primarycolordarker = "#7e00ce";
$bodybg = "#cbcbcb";

//mailing settings
$emailhost = "mail.alkalomeclat.com";
$emailusername = "alkalomnewwebsite@alkalomeclat.com"; // Change it to yours
$emailpassword = ".c;N[AcfbXMX";

//database connection
$host = "localhost";
$dbuser = "alkalome_habibie";
$dbpassword = "+mY-Eef^Ox_0";
$databasename = "alkalome_testdb";
$connection = mysqli_connect($host, $dbuser, $dbpassword, $databasename);
$connection->set_charset("utf8");

//database tables
$tableusers = "hubbyusers";
$tableproducts = "hubbyproducts";
$tablemessages = "hubbymessages";
$tableconversations = "hubbyconversations";

//creating database table for user registration
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

//creating database table for user products
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $tableproducts (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
userid VARCHAR(30) NOT NULL,
productid VARCHAR(30) NOT NULL,
title VARCHAR(100) NOT NULL,
price INT(6),
description VARCHAR(500) NOT NULL,
ext VARCHAR(10) NOT NULL
)");


//creating database table for messages
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $tablemessages (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
userid VARCHAR(30) NOT NULL,
productid VARCHAR(30) NOT NULL,
messageid VARCHAR(30) NOT NULL,
offlinemessage INT(6),
senderemail VARCHAR(30) NOT NULL
)");

//creating database table for conversations
mysqli_query($connection, "CREATE TABLE IF NOT EXISTS $tableconversations (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
messageid VARCHAR(30) NOT NULL,
timestamp VARCHAR(30) NOT NULL,
fromseller INT(6),
isread INT(6),
content VARCHAR(500) NOT NULL
)");

if(!file_exists("upload"))
	mkdir("upload");


?>