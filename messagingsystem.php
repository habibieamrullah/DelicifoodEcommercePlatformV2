<?php
include("config.php");
include("functions.php");
include("mailing.php");
include("uilang.php");


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
    
    if($defaultlang == "id")
        sendmail($selleremail, "Anda mendapatkan pesan baru dari" . " " . $websitename, "<p>" . "Anda mendapatkan pesan baru dari" . " " . $senderemail. ":</p><p>" .$content. "</p><p><a href='" .$baseurl. "?login'>Log in</a> ke akun " .$websitename. " untuk membalasnya.</p>");
    else
        sendmail($selleremail, "You got a new message from" . " " . $websitename, "<p>" . "You got a new message from" . " " . $senderemail. ":</p><p>" .$content. "</p><p><a href='" .$baseurl. "?login'>Log in</a> to your " . $websitename . " account to reply it from Hubby Dashboard.</p>");
    
    if($offlinemessage == 1)
        echo "<p>" . uilang("Your message has been received. The seller will contact you via email soon") . ".</p>";
    else
        echo $messageid;
}

if(isset($_POST["chatmessaging"])){

    $userid = mysqli_real_escape_string($connection, $_POST["userid"]);
    $productid = mysqli_real_escape_string($connection, $_POST["productid"]);
    $senderemail = mysqli_real_escape_string($connection, $_POST["senderemail"]);
    $content = mysqli_real_escape_string($connection, preg_replace( "/(\r|\n)/", "", $_POST["content"]));
    $timestamp = date("Y, F j, g:i a");
    $messageid = mysqli_real_escape_string($connection, $_POST["messageid"]);
    
    $fromseller = 0;
    $isread = 0;
    if(isset($_POST["selleranswer"])){
        $fromseller = 1;
        $isread = 1;
    }

    mysqli_query($connection, "INSERT INTO $tableconversations (messageid, timestamp, fromseller, isread, content) VALUES ('$messageid', '$timestamp', $fromseller, $isread, '$content')");
    
    echo $messageid;
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
                $firstmssgid = $row["messageid"];
                $msql = "SELECT * FROM $tableconversations WHERE messageid = '$firstmssgid' ORDER BY id DESC LIMIT 1";
                $mrow = mysqli_fetch_assoc(mysqli_query($connection, $msql));
                $isread = $mrow["isread"];
                $isreadstyle = "";
                $commentingo = "-o";
                if($isread == 0){
                    $isreadstyle = " style='font-weight: bold;'";
                    $commentingo = "";
                }
                ?><div onclick=\"openchatmessage('<?php echo $mrow["messageid"] ?>')\" class='chatmessageschild'<?php echo $isreadstyle ?>><div style='font-size: 10px;'><?php echo $row["senderemail"] ?> on <?php echo $mrow["timestamp"] ?></div><div><i class='fa fa-commenting<?php echo $commentingo ?>'></i> <?php echo shorten_text($mrow["content"], 20, '...', true); ?></div></div><?php
            }
            ?>")
        </script>
        <?php
    }else{
        ?>
        <script>
            $("#chatmessages").html("<div class='chatmessageschild'><?php uilang("There is no message yet.") ?></div>")
        </script>
        <?php
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

if(isset($_POST["updatechatconversation"])){
    
    $messageid = mysqli_real_escape_string($connection, $_POST["updatechatconversation"]);
    
    $sql = "SELECT * FROM $tablemessages WHERE messageid = '$messageid' AND offlinemessage = 0 ORDER BY id DESC";
    $result = mysqli_query($connection, $sql);
    if(mysqli_num_rows($result) > 0){
        
        ?>
        <script>
            $("#currentchatconversation").html("<?php
            $msql = "SELECT * FROM $tableconversations WHERE messageid = $messageid ORDER BY id ASC";
            $mresult = mysqli_query($connection, $msql);
            while($row = mysqli_fetch_assoc($mresult)){
                
                if($row["fromseller"] == 0){
                    ?><div align='right'><div class='msg'><div class='msgtimestamp'><?php echo $row["timestamp"] ?></div><div class='msgbody'><?php echo $row["content"] ?></div></div></div><?php
                }else{
                    ?><div align='left'><div class='msgthatperson'><div class='msgtimestamp'><?php echo $row["timestamp"] ?></div><div class='msgbody'><?php echo $row["content"] ?></div></div></div><?php
                }
            }
            ?>")
        </script>
        <?php
    }
    
}





?>
