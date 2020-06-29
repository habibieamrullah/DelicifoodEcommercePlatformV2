var senderemail
var sellerisonline

$("#messaging").html("<p id='sellerstatus'><!--The seller is <span style='color: red;'>offline</span>. -->You will get the response by email.</p><div><input id='senderemail' type='email' placeholder='Enter your email address...' value='<?php
if(isset($_SESSION["email"]))
    echo $_SESSION["email"];
?>'><button style='margin-bottom: 0px;' onclick='checksendermail()'>Continue</button></div>")

function checksendermail(){
    senderemail = $("#senderemail").val()
    if(senderemail.indexOf("@") > -1 && senderemail.indexOf(".") > -1 && senderemail !=  ""){
        $("#messaging").html("<textarea id='messagetext' placeholder='Type your message here...' style='margin-bottom: 0px; margin-top: 20px;'></textarea><button id='chatsendbutton' onclick='sendmessage()' style='margin-bottom: 0px;'>Send</button>")
    }else{
        alert("Invalid email address.")
    }
}

function sendmessage(){
    var message = $("#messagetext").val()
    if(message != ""){
        var messagingtype = 1
        
        if(sellerisonline)
            messagingtype = 0
        
        $.post("messagingsystem.php", {
            "userid" : "<?php echo $sellerid ?>",
            "productid" : "<?php echo $productid ?>",
            "offlinemessage" : messagingtype,
            "senderemail" : senderemail,
            "selleremail" : "<?php echo mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM $tableusers WHERE userid = '$sellerid'"))["email"] ?>",
            "content" : message,
        }, function(data){
            if(!sellerisonline){
                $("#messaging").html(data)
            }else{
                $("#currentchatconversation").html("Sending...")
                $("#messagetext").val("").focus()
                $("#chatsendbutton").attr({ "onclick" : "sendonlinemessage()" })
                
                clearInterval(chatupdateinterval)
                chatupdateinterval = setInterval(function(){
                    updatechatconversation(data)
                }, 1500)
            }
        })
    }else{
        alert("Write something first.")
    }
}


function sendonlinemessage(){
    
    var message = $("#messagetext").val()
    if(message != ""){
        var messagingtype = 0
        $.post("messagingsystem.php", {
            "userid" : "<?php echo $sellerid ?>",
            "productid" : "<?php echo $productid ?>",
            "offlinemessage" : messagingtype,
            "senderemail" : senderemail,
            "content" : message,
            "messageid" : chatmessageid,
            "chatmessaging" : "yes"
        }, function(data){
            $("#currentchatconversation").append("Sending...")
            $("#messagetext").val("").focus()
            $("#chatsendbutton").attr({ "onclick" : "sendonlinemessage()" })
            clearInterval(chatupdateinterval)
            chatupdateinterval = setInterval(function(){
                updatechatconversation(data)
            }, 1500)
        })
    }else{
        alert("Write something first.")
    }
    
}

$.post("messagingsystem.php", { "isselleronline" : "<?php echo $sellerid ?>" }, function(data){
    if(data != "0"){
        var d = new Date()
        d = d.getTime()
        var lastonline = parseInt(data)
        if(d - lastonline < 10000){
            $("#sellerstatus").html("The seller is <span style='color: green;'>online</span>. Enter your email to continue.")
            sellerisonline = true
        }
    }
} )
