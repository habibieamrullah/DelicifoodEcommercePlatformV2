<?php
include("config.php");
include("functions.php");
if(isset($_POST["senderemail"])){
    $userid = mysqli_real_escape_string($connection, $_POST["userid"]);
    $senderemail = mysqli_real_escape_string($connection, $_POST["senderemail"]);
    $offlinemessage = mysqli_real_escape_string($connection, $_POST["offlinemessage"]);
    $content = mysqli_real_escape_string($connection, preg_replace( "/(\r|\n)/", "", $_POST["content"]));
    $timestamp = date("Y, F j, g:i a");
    $messageid = getRandomNumbers();
    
    mysqli_query($connection, "INSERT INTO $tablemessages (messageid, userid, senderemail, offlinemessage) VALUES ('$messageid', '$userid', '$senderemail', '$offlinemessage')");
    mysqli_query($connection, "INSERT INTO $tableconversations (messageid, timestamp, fromseller, isread, content) VALUES ('$messageid', '$timestamp', 1, 0, '$content')");
    
    echo "<p>Your message has been received. The seller will contact you via email soon.</p>";
}

if(isset($_POST["offlinereply"])){
    
    $userid = mysqli_real_escape_string($connection, $_POST["userid"]);
    $senderemail = mysqli_real_escape_string($connection, $_POST["senderemail"]);
    $offlinemessage = 1;
    $content = mysqli_real_escape_string($connection, preg_replace( "/(\r|\n)/", "", $_POST["content"]));
    $timestamp = date("Y, F j, g:i a");
    $messageid = mysqli_real_escape_string($connection, $_POST["messageid"]);
    
    mysqli_query($connection, "INSERT INTO $tableconversations (messageid, timestamp, fromseller, isread, content) VALUES ('$messageid', '$timestamp', 0, 1, '$content')");
    
    echo "Message has been replied.";
}
?>