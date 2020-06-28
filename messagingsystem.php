<?php
include("config.php");
include("functions.php");
include("mailing.php");


if(isset($_POST["offlinemessage"]) && !isset($_POST["chatmessaging"])){
    
    $userid = mysqli_real_escape_string($connection, $_POST["userid"]);
    $selleremail = mysqli_real_escape_string($connection, $_POST["selleremail"]);
    $productid = mysqli_real_escape_string($connection, $_POST["productid"]);
    $senderemail = mysqli_real_escape_string($connection, $_POST["senderemail"]);
    $offlinemessage = mysqli_real_escape_string($connection, $_POST["offlinemessage"]);
    $content = mysqli_real_escape_string($connection, preg_replace( "/(\r|\n)/", "", $_POST["content"]));
    $timestamp = date("Y, F j, g:i a");
    $messageid = getRandomNumbers();
    
    mysqli_query($connection, "INSERT INTO $tablemessages (messageid, productid, userid, senderemail, offlinemessage) VALUES ('$messageid', '$productid', '$userid', '$senderemail', '$offlinemessage')");
    mysqli_query($connection, "INSERT INTO $tableconversations (messageid, timestamp, fromseller, isread, content) VALUES ('$messageid', '$timestamp', 0, 0, '$content')");
    
    sendmail($selleremail, "You got new message from Hubby", "<p>You got a new message from " .$senderemail. ":</p><p>" .$content. "</p><p>Log in to your Hubby account to reply it from Hubby Dashboard.</p>");
    
    if($offlinemessage == 1)
        echo "<p>Your message has been received. The seller will contact you via email soon.</p>";
    else
        echo "<div align='right'><div class='msg'><div class='msgtimestamp'>" .$timestamp. "</div><div class='msgbody'>" .$content. "</div></div></div><script>var chatmessageid = '" .$messageid. "'</script>";
}

if(isset($_POST["chatmessaging"])){

    $userid = mysqli_real_escape_string($connection, $_POST["userid"]);
    $productid = mysqli_real_escape_string($connection, $_POST["productid"]);
    $senderemail = mysqli_real_escape_string($connection, $_POST["senderemail"]);
    $content = mysqli_real_escape_string($connection, preg_replace( "/(\r|\n)/", "", $_POST["content"]));
    $timestamp = date("Y, F j, g:i a");
    $messageid = mysqli_real_escape_string($connection, $_POST["messageid"]);

    mysqli_query($connection, "INSERT INTO $tableconversations (messageid, timestamp, fromseller, isread, content) VALUES ('$messageid', '$timestamp', 0, 0, '$content')");
    
    echo "<div align='right'><div class='msg'><div class='msgtimestamp'>" .$timestamp. "</div><div class='msgbody'>" .$content. "</div></div></div>";
}


if(isset($_POST["offlinereply"]) && !isset($_POST["chatmessaging"])){
    
    $userid = mysqli_real_escape_string($connection, $_POST["userid"]);
    $sellername = mysqli_real_escape_string($connection, $_POST["sellername"]);
    $senderemail = mysqli_real_escape_string($connection, $_POST["senderemail"]);
    $offlinemessage = 1;
    $content = mysqli_real_escape_string($connection, preg_replace( "/(\r|\n)/", "", $_POST["content"]));
    $timestamp = date("Y, F j, g:i a");
    $messageid = mysqli_real_escape_string($connection, $_POST["messageid"]);
    
    sendmail($senderemail, "Your message has been replied", "<p>" .$sellername. " from Hubby replied to your message:</p><p>" .$content. "</p>");
    
    mysqli_query($connection, "INSERT INTO $tableconversations (messageid, timestamp, fromseller, isread, content) VALUES ('$messageid', '$timestamp', 1, 1, '$content')");
    
    echo "Message has been replied.";
}

if(isset($_POST["selleroffline"])){
    $email = mysqli_real_escape_string($connection, $_POST["selleroffline"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);
    mysqli_query($connection, "UPDATE $tableusers SET isonline = 0 WHERE email = '$email' AND password = '$password'");
}

if(isset($_POST["sol"])){
    $userid = mysqli_real_escape_string($connection, $_POST["sol"]);
    $password = mysqli_real_escape_string($connection, $_POST["password"]);
    $lastonline = mysqli_real_escape_string($connection, $_POST["lastonline"]);
    mysqli_query($connection, "UPDATE $tableusers SET isonline = 1, lastonline = '$lastonline' WHERE userid = '$userid' AND password = '$password'");
    
    $sql = "SELECT * FROM $tablemessages WHERE userid = '$userid' AND offlinemessage = 0 ORDER BY id DESC";
    $result = mysqli_query($connection, $sql);
    if(mysqli_num_rows($result) > 0){
        ?>
        <script>
            $("#chatmessages").html("<?php
            while($row = mysqli_fetch_assoc($result)){
                ?><div class='chatmessageschild'><?php echo $row["senderemail"] ?></div><?php
            }
            ?>")
        </script>
        <?php
    }else{
        echo "<p>No chat message yet.</p>";
    }
    
}

if(isset($_POST["isselleronline"])){
    $userid = mysqli_real_escape_string($connection, $_POST["isselleronline"]);
    $sql = "SELECT * FROM $tableusers WHERE userid = '$userid'";
    $result = mysqli_query($connection, $sql);
    if(mysqli_num_rows($result) > 0){
        echo mysqli_fetch_assoc($result)["lastonline"];
    }else{
        echo "0";
    }
}
?>