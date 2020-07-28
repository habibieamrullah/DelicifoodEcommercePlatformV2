<?php

include("config.php");
include("functions.php");

if(isset($_POST["productid"])){
    $productid = mysqli_real_escape_string($connection, $_POST["productid"]);
    $currentviewer = get_client_ip();
    $sql = "SELECT * FROM $tableproducts WHERE productid = '$productid' AND lastviewer = '$currentviewer'";
    $result = mysqli_query($connection, $sql);
    
    if(mysqli_num_rows($result) == 0){
        $currentview = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM $tableproducts WHERE productid = '$productid'"))["views"];
        $currentview++;
        mysqli_query($connection, "UPDATE $tableproducts SET views = $currentview, lastviewer = '$currentviewer' WHERE productid = '$productid'");
    }
    
    echo "Viewed " . $productid . " by " . $currentviewer;
}