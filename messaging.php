//the seller is offline

var senderemail

$("#messaging").html("<p>The seller is <span style='color: red;'>offline</span>. You will get the response by email.</p><div><input id='senderemail' type='email' placeholder='Email' value='<?php
if(isset($_SESSION["email"]))
    echo $_SESSION["email"];
?>'><button style='margin-bottom: 0px;' onclick='checksendermail()'>Continue</button></div>")

function checksendermail(){
    senderemail = $("#senderemail").val()
    if(senderemail.indexOf("@") > -1 && senderemail.indexOf(".") > -1 && senderemail !=  ""){
        $("#messaging").html("<textarea id='messagetext' placeholder='Type your message here...'></textarea><button onclick='sendmessage()' style='margin-bottom: 0px;'>Send</button>")
    }else{
        alert("Invalid email address.")
    }
}

function sendmessage(){
    var message = $("#messagetext").val()
    if(message != ""){
        $.post("messagingsystem.php", {
            "userid" : "<?php echo $sellerid ?>",
            "offlinemessage" : 1,
            "senderemail" : senderemail,
            "content" : message
        }, function(data){
            $("#messaging").html(data)
        })
    }else{
        alert("Write something first.")
    }
}