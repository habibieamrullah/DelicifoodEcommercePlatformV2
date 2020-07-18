<?php
    session_start();
    include("config.php");
    include("uilang.php");
    include("functions.php");
    include("mailing.php");
?>


<!DOCTYPE html>
<html>
    <head>
        
        <?php
        if(isset($_GET["product"])){
            
            $productid = mysqli_real_escape_string($connection, $_GET["product"]);
            $sql = "SELECT * FROM $tableproducts WHERE productid = '$productid'";
            $result = mysqli_query($connection, $sql);
            
            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);
                ?>
                <title><?php echo $row["title"] ?> | <?php echo $websitename ?></title>
                <meta name="description" content="<?php echo shorten_text($row["description"], 180, '', true) ?>">
                <?php
            }
        }else if(isset($_GET["user"])){
            
            $userid = mysqli_real_escape_string($connection, $_GET["user"]);
            $sql = "SELECT * FROM $tableusers WHERE userid = '$userid'";
            $result = mysqli_query($connection, $sql);
            
            if(mysqli_num_rows($result) > 0){
                $row = mysqli_fetch_assoc($result);
                ?>
                <title><?php uilang("Products added by") ?> <?php echo $row["name"] ?> | <?php echo $websitename ?></title>
                <meta name="description" content="<?php echo $websitetitle ?>">
                <?php
            }
        }else if(isset($_GET["about"])){
            ?>
            <title><?php uilang("About"); echo " " . $websitename; ?></title>
            <meta name="description" content="<?php echo $websitetitle ?>">
            <?php
        }else{
            
            ?>
            <title><?php echo $websitename ?> | <?php echo $websitetitle ?></title>
            <meta name="description" content="<?php echo $websitetitle ?>">
            <?php
            
        }
        
        ?>
        
        <meta name="keywords" content="<?php echo $websitetags ?>">
        
        <meta charset="utf-8">
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        
        <scriptsrc="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
        <script
          src="https://code.jquery.com/jquery-3.4.1.min.js"
          integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
          crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300&display=swap" rel="stylesheet">
        
        <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
		<link rel="icon" href="favicon.ico" type="image/x-icon">
        
        
        <style>
            <?php
            include("style1.php");
            ?>
        </style>
        
        <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
        <script type="text/javascript" src="slick/slick.min.js"></script>
        
        
        <script>
            var onlineinterval
            var chatupdateinterval
            function stoponlinechat(e, p){
                $("#chats").html("Getting online. Please wait a moment...")
                clearInterval(onlineinterval)
                clearInterval(chatupdateinterval)
                $("#onlinestatus").html("Offline")
                $("#onlinestatus").css({
                    "background-color" : "gray"
                })
                $.post("messagingsystem.php", {
                    "selleroffline" : e,
                    "password" : p
                })
            }
        </script>
        
        <?php include("adscriptheader.php"); ?>
    </head>
    <body>
        
        <div class="invisibleblock">
            <h1><?php echo $websitename ?></h1>
            <p><?php echo $websitetitle ?></p>
        </div>
        
        <div id="appbar">
            <div style="display: inline-block;">
                <a href="<?php echo $baseurl ?>"><img src="images/weblogo.png" width="200px"></a>
            </div>
            <div id="mobilebutton" class="mobilevisible" onclick="toggleDrawer()"><i class="fa fa-bars"></i></div>
            <div id="appbarmenu">
                <div class="ablink mobilevisible" onclick="toggleDrawer()" style="padding: 40px;"><i class="fa fa-times"></i></div>
                <a href="<?php echo $baseurl ?>"><div class="ablink"><?php uilang("Home"); ?></div></a>
                <?php 
                if(isset($_SESSION["email"])){
                    ?>
                    <a href="<?php echo $baseurl ?>?dashboard"><div class="ablink"><?php uilang("Dashboard"); ?></div></a>
                    <a href="<?php echo $baseurl ?>?logout"><div class="ablink"><?php uilang("Logout"); ?></div></a>
                    <?php
                }else{
                    ?>
                    <a href="<?php echo $baseurl ?>?login"><div class="ablink"><?php uilang("Login"); ?></div></a>
                    <a href="<?php echo $baseurl ?>?register"><div class="ablink"><?php uilang("Register"); ?></div></a>
                    <?php
                }
                ?>
                <a href="<?php echo $baseurl ?>?about"><div class="ablink"><?php uilang("About"); ?></div></a>
                <a href="<?php echo $baseurl ?>?search"><div class="ablink"><i class="fa fa-search"></i></div></a>
                
            </div>
        </div>
        <div id="mainbanner">
            <h2><?php echo $websitename ?></h2><h4><?php echo $websitetitle ?></h4>
        </div>
        <div class="middle">
            
            
            <?php
            
            
                if(isset($_GET["login"])){
                    ?>
                    <div class="middlebox">
                        <?php
                        if(isset($_POST["login"])){
                            
                            $email = mysqli_real_escape_string($connection, $_POST["email"]);
                            $password = mysqli_real_escape_string($connection, $_POST["password"]);
                            
                            $result = mysqli_query($connection, "SELECT * FROM $tableusers WHERE email = '$email' AND password = '$password'");
                            if(mysqli_num_rows($result) > 0){
                                $_SESSION["email"] = $email;
                                $_SESSION["password"] = $password;
                                $_SESSION["userid"] = mysqli_fetch_assoc($result)["userid"];
                                ?>
                                <p><?php uilang("Welcome!"); ?></p>
                                <script>
                                    setTimeout(function(){
                                        location.href = "<?php echo $baseurl ?>?dashboard"
                                    }, 1000)
                                </script>
                                <?php
                            }else{
                                ?>
                                <p><?php uilang("Incorrect email and/or password!"); ?></p>
                                <?php
                            }
                        }else{
                            ?>
                            <h2><?php uilang("Login"); ?></h2>
                            <form method="post" action="<?php echo $baseurl ?>?login">
                                <label>Email</label>
                                <input name="email" type="email" placeholder="Email">
                                <label>Password</label>
                                <input name="password" type="password" placeholder="Password">
                                <input name="login" type="submit" value="<?php uilang("Login"); ?>" class="submitbutton"> 
                            </form>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }else if(isset($_GET["register"])){
                    ?>
                    <div class="middlebox">
                        <?php
                        if(isset($_POST["register"])){
                            
                            $date = date("Y/m/d");
                            $time = date("h:i:sa");
                            $datereg = $date . " " . $time;
                            $email = mysqli_real_escape_string($connection, $_POST["email"]);
                            $password = mysqli_real_escape_string($connection, $_POST["password"]);
                            $name = mysqli_real_escape_string($connection, $_POST["name"]);
                            $phone = mysqli_real_escape_string($connection, $_POST["phone"]);
                            $address = mysqli_real_escape_string($connection, $_POST["address"]);
                            $userid = getRandomNumbers();
                            
                            if($email != "" && $password != "" && $name != "" && $phone != "" && $address != ""){
                                
                                if(mysqli_num_rows(mysqli_query($connection, "SELECT * FROM $tableusers WHERE email = '$email'")) > 0){
                                    ?>
                                    <p><?php uilang("This email address is already registered. Try to use another email."); ?></p>
                                    <?php
                                }else{
                                    mysqli_query($connection, "INSERT INTO $tableusers (datereg, email, password, name, phone, address, userid, isonline) VALUES ('$datereg', '$email', '$password', '$name', '$phone', '$address', '$userid', 0)");
                                    ?>
                                    <p><?php uilang("Thank you for registering!"); ?></p>
                                    <script>
                                        setTimeout(function(){
                                            location.href = "<?php echo $baseurl ?>?dashboard"
                                        }, 1000)
                                    </script>
                                    <?php
                                    $_SESSION["email"] = $email;
                                    $_SESSION["userid"] = $userid;
                                    $_SESSION["password"] = $password;
                                }
                            }else{
                                ?>
                                <p><p><?php uilang("You did not fill all the fields. Please try again."); ?></p></p>
                                <?php
                            }

                        }else{
                            ?>
                            <h2><?php uilang("Register"); ?></h2>
                            <form method="post" action="<?php echo $baseurl ?>?register">
                                <label>Email</label>
                                <input name="email" type="email" placeholder="Email">
                                <label>Password</label>
                                <input name="password" type="password" placeholder="Password">
                                <label><?php uilang("Name/Nickname"); ?></label>
                                <input name="name" type="text" placeholder="Your name or nickname">
                                <label><?php uilang("Phone Number"); ?></label>
                                <p><?php uilang("*Include your country code before your phone number like this: 6590611234"); ?></p>
                                <input name="phone" type="number" placeholder="<?php uilang("Phone Number"); ?>">
                                <label><?php uilang("Address"); ?></label>
                                <input name="address" type="text" placeholder="<?php uilang("Address"); ?>">
                                <input name="register" type="submit" value="<?php uilang("Register"); ?>" class="submitbutton">
                            </form>
                            <?php
                        }
                    
                        ?>
                        
                    </div>
                    <?php
                }else if(isset($_GET["logout"])){
                    ?>
                    <p align="center"><?php uilang("Good bye!"); ?></p>
                    <script>
                        setTimeout(function(){
                            location.href = "<?php echo $baseurl ?>"
                        }, 1000)
                    </script>
                    <?php
                    session_destroy();
                }else if(isset($_GET["dashboard"])){
                    
                    ?>
                    <div class="middlebox">
                        <?php
                        
                        if(isset($_SESSION["email"])){
                            
                            include("thumbnailgenerator.php");
                            
                            $email = $_SESSION["email"];
                            $userid = $_SESSION["userid"];
                            $waenabled = 0;
                            $name = "";
                            $phone = "";
                            $address = "";
                            
                            $sql = "SELECT * FROM $tableusers WHERE email = '$email'";
                            $result = mysqli_query($connection, $sql);
                            
                            while($row = mysqli_fetch_assoc($result)){
                                $name = $row["name"];
                                $phone = $row["phone"];
                                $address = $row["address"];
                                $waenabled = $row["waenabled"];
                            }
                            ?>
                            
                            
                            
                            <div class="dashboardcontentholder">
                                
                                <div class="dashboardcell dbcleft">
                                    <div class="dashboardleftbutton" onclick="dbpage(1)"><i class="fa fa-plus" style="width: 20px;"></i> <?php uilang("Add") ?></div>
                                    <div class="dashboardleftbutton" onclick="dbpage(2)"><i class="fa fa-cutlery" style="width: 20px;"></i> <?php uilang("Products") ?></div>
                                    <div class="dashboardleftbutton" onclick="dbpage(3)"><i class="fa fa-user" style="width: 20px;"></i> <?php uilang("Profile") ?></div>
                                    <div class="dashboardleftbutton" onclick="dbpage(4)"><i class="fa fa-envelope" style="width: 20px;"></i> <?php uilang("Messages") ?> <span id="messagescount"></span></div>
                                    <div class="dashboardleftbutton" onclick="dbpage(5)"><i class="fa fa-commenting" style="width: 20px;"></i> <?php uilang("Chats") ?> <span id="onlinestatus">Offline</span></div>
                                </div>
                                <div class="dashboardcell dbcright">
                                    <div class="dbp dbp1">
                                        <h3><?php uilang("Add"); ?></h3>
                                        <form method="post" action="<?php echo $baseurl ?>?dashboard" enctype="multipart/form-data">
                                            <input name="title" placeholder="<?php uilang("Title"); ?>">
                                            <input name="price" type="number" placeholder="<?php uilang("Price"); ?>">
                                            <textarea name="description" placeholder="<?php uilang("Description"); ?>"></textarea>
                                            <p><?php uilang("Choose your product photo:"); ?></p>
                                            <input type="file" name="productimage" accept="image/*">
                                            <input name="addnew" type="submit" value="<?php uilang("Submit"); ?>" class="submitbutton">
                                        </form>
                                    </div>
                                    <div class="dbp dbp2">
                                        <h3><?php uilang("Products"); ?></h3>
                                        <?php
                                        $sql = "SELECT * FROM $tableproducts WHERE userid = '$userid' ORDER BY id DESC";
                                        $result = mysqli_query($connection, $sql);
                                        if(mysqli_num_rows($result) > 0){
                                            ?>
                                            <p><?php uilang("Click to edit one of your published products.") ?></p>
                                            <?php
                                            while($productrow = mysqli_fetch_assoc($result)){
                                                
                                                ?>
                                                <a href="<?php echo $baseurl ?>?dashboard&edit=<?php echo $productrow["productid"] ?>">
                                                    
                                                    <div class="productthumbnail">
                                                        <div class="thumbnailimage" style="margin-bottom: 10px; background: url(upload/<?php echo $productrow["productid"] ?>-thumb.<?php echo $productrow["ext"] ?>) no-repeat center center; background-size: cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;">
                                                            <div style="display: inline-block;">
                                                                <div class="pricetag"><i class="fa fa-tag"></i> <?php echo $currencysymbol . $productrow["price"] ?></div>
                                                            </div>
                                                        </div>
                                                        
                                                        <h3 style="margin: 0px;"><?php echo $productrow["title"] ?></h3>
                                                        
                                                        <h5 style="margin: 0px;"><i class="fa fa-user"></i> <?php echo $name ?></h5>
                                                        <div class="shorttext">
                                                            <?php echo $productrow["description"] ?>
                                                        </div>
                                                    </div>
                                                    
                                                </a>
                                                <?php
                                                
                                            }
                                        }else{
                                            ?>
                                            <p align="center"><?php uilang("You don't have any product yet.") ?></p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    
                                    <div class="dbp dbp3">
                                        <h3><?php uilang("Profile") ?></h3>
                                        <form action="<?php echo $baseurl ?>?dashboard" method="post">
                                            <label><?php uilang("Name/Nickname") ?></label>
                                            <input name="name" type="text" placeholder="<?php uilang("Name/Nickname") ?>" value="<?php echo $name ?>">
                                            <label><?php uilang("Phone Number") ?></label>
                                            <p><?php uilang("*Include your country code before your phone number like this: 6590611234"); ?></p>
                                            <input name="phone" type="number" placeholder="<?php uilang("Phone Number") ?>" value="<?php echo $phone ?>">
                                            <label><?php uilang("Address") ?></label>
                                            <input name="address" type="text" placeholder="<?php uilang("Address") ?>" value="<?php echo $address ?>">
                                            <label><?php uilang("Are you willing to be contacted via WhatsApp chat?") ?></label>
                                            <p style="font-size: 12px;"><?php uilang("This option will enable WhatsApp chat button on your products.") ?></p>
                                            <select name="waenabled">
                                                <?php
                                                if($waenabled){
                                                    ?>
                                                    <option value=1><?php uilang("Yes") ?></option>
                                                    <option value=0><?php uilang("No") ?></option>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <option value=0><?php uilang("No") ?></option>
                                                    <option value=1><?php uilang("Yes") ?></option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                            <input name="updateprofile" type="submit" value="<?php uilang("Update") ?>" class="submitbutton">
                                        </form>
                                    </div>
                                    <div class="dbp dbp4">
                                        <h3><?php uilang("Messages") ?></h3>
                                        <?php
                                        $unreadcount = 0;
                                        if(isset($_GET["readmessage"])){
                                            
                                            $messageid = mysqli_real_escape_string($connection, $_GET["readmessage"]);
                                            $sql = "SELECT * FROM $tablemessages WHERE userid = '$userid' AND messageid = '$messageid'";
                                            $result = mysqli_query($connection, $sql);
                                            $row = mysqli_fetch_assoc($result);
                                            
                                            if(mysqli_num_rows($result) > 0){
                                                $msql = "SELECT * FROM $tableconversations WHERE messageid = '$messageid' AND fromseller = 0";
                                                $mresult = mysqli_query($connection, $msql);
                                                $mrow = mysqli_fetch_assoc($mresult);
                                                mysqli_query($connection, "UPDATE $tableconversations SET isread = 1 WHERE messageid = '$messageid'");
                                                ?>
                                                <script>
                                                    setTimeout(function(){
                                                        $("#messagestable").hide()
                                                        $("#messagecontent").show().html("<div><div onclick='backToMessages()' class='textlink'><i class='fa fa-arrow-left'></i> <?php uilang("Back") ?></div><div style='padding: 20px; font-size: 12px;'><p style='font-size: 12px;'><?php uilang("Message ID") ?>: <? echo $row["messageid"] ?></p><p><b><?php uilang("Sender") ?>:</b> <?php echo $row["senderemail"] ?><br><b><?php uilang("Date") ?>:</b> <?php echo $mrow["timestamp"] ?><br><b><?php uilang("Product ID") ?>:</b> <a class='textlink' href='<?php echo $baseurl ?>?product=<?php echo $row["productid"] ?>'><?php echo $row["productid"] ?></a></p><div align='right'><div class='msg'><div class='msgtimestamp'><?php echo $mrow["timestamp"] ?></div><div class='msgbody'><?php echo $mrow["content"] ?></div></div></div></div><div id='replies'></div><textarea id='offlinereplyinput' style='margin-bottom: 0px; margin-top: 20px;'></textarea><p style='font-size: 12px;'>*<?php uilang("Your reply message will be mailed to") ?>: <?php echo $row["senderemail"] ?></p><button class='submitbutton' onclick='offlinereply()'><?php uilang("Send Message") ?></button></div>")
                                                    }, 500)
                                                    
                                                    
                                                    <?php
                                                
                                                    $repliessql = "SELECT * FROM $tableconversations WHERE messageid = '$messageid' AND fromseller = 1";
                                                    
                                                    $repliesresult = mysqli_query($connection, $repliessql);
                                                    if(mysqli_num_rows($repliesresult) > 0){
                                                        while($repliesrow = mysqli_fetch_assoc($repliesresult)){
                                                            ?>
                                                            setTimeout(function(){
                                                                $("#replies").append("<div align='left'><div class='msgthatperson'><div class='msgtimestamp'>You replied on <?php echo $repliesrow["timestamp"] ?>:</div><div class='msgbody'><?php echo preg_replace( "/(\r|\n)/", "", nl2br($repliesrow["content"])) ?></div></div></div>")
                                                            }, 1000)
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                    
                                                    function offlinereply(){
                                                        var replyinput = $("#offlinereplyinput").val()
                                                        if(replyinput != ""){
                                                            $.post("messagingsystem.php", {
                                                                "messageid" : "<?php echo $messageid ?>",
                                                                "userid" : "<?php echo $userid ?>",
                                                                "senderemail" : "<?php echo $_SESSION["email"] ?>",
                                                                "content" : replyinput,
                                                                "sellername" : "<?php echo $name ?>",
                                                                "offlinereply" : "yes",
                                                            }, function(data){
                                                                //location.href = "<?php echo $baseurl ?>?dashboard&readmessage=<?php echo $messageid ?>#4"
                                                                location.reload()
                                                            })
                                                        }
                                                    }
                                                </script>
                                                <?php
                                            }else{
                                                ?>
                                                <script>
                                                    setTimeout(function(){
                                                        $("#messagestable").hide()
                                                        $("#messagecontent").show().html("<div><div onclick='backToMessages()' class='textlink'><i class='fa fa-arrow-left'></i> <?php uilang("Back") ?></div><p>You are not authorized to view this message.</p></div>")
                                                    }, 500)
                                                </script>
                                                <?php
                                            }
                                            
                                            
                                            ?>
                                            <script>
                                                
                                                function backToMessages(){
                                                    /*$("#messagestable").show()
                                                    $("#messagecontent").hide()*/
                                                    location.href = "<?php echo $baseurl ?>?dashboard#4"
                                                }
                                            </script>
                                            <?php
                                            
                                        }
                                        
                                        $sql = "SELECT * FROM $tablemessages WHERE userid = '$userid' AND offlinemessage = 1 ORDER BY id DESC";
                                        $result = mysqli_query($connection, $sql);
                                        
                                        if(mysqli_num_rows($result) > 0){
                                        
                                            ?>
                                            <div id="messagecontent"></div>
                                            <div id="messagestable">
                                                <table style="width=100%">
                                                    <tr>
                                                        <th>
                                                            <i class="fa fa-envelope"></i>
                                                        </th>
                                                        <th>
                                                            <?php uilang("Date") ?>
                                                        </th>
                                                        <th>
                                                            <?php uilang("Sender") ?>
                                                        </th>
                                                        <th>
                                                            <?php uilang("Messages") ?>
                                                        </th>
                                                    </tr>
                                                    <?php
                                                    
                                                    while($row = mysqli_fetch_assoc($result)){
                                                        
                                                        $messageid = $row["messageid"];
                                                        $msql = "SELECT * FROM $tableconversations WHERE messageid = '$messageid'";
                                                        $mresult = mysqli_query($connection, $msql);
                                                        while($mrow = mysqli_fetch_assoc($mresult)){
                                                            if($mrow["fromseller"] == 0){
                                                                if($mrow["isread"] == 0){
                                                                    $unreadcount++;
                                                                }
                                                                ?>
                                                                    <tr<?php if($mrow["isread"] == 0){ echo " style='font-weight: bold;' "; } ?> onclick=openlink("<?php echo $baseurl ?>?dashboard&readmessage=<?php echo $messageid ?>#4")>
                                                                        <td style="text-align: center;">
                                                                            <?php
                                                                            if($mrow["isread"] == 1){
                                                                                ?>
                                                                                <i class="fa fa-envelope-open-o"></i>
                                                                                <?php
                                                                            }else{
                                                                                ?>
                                                                                <i class="fa fa-envelope"></i>
                                                                                <?php
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $mrow["timestamp"] ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo $row["senderemail"] ?>
                                                                        </td>
                                                                        <td>
                                                                            <?php echo shorten_text($mrow["content"], 30, '...', true); ?>
                                                                        </td>
                                                                    </tr>
                                                                <?php
                                                            }
                                                        }
                                                    }
                                                    ?>
                                                </table>
                                            </div>
                                            
                                            <script>
                                                $("#messagescount").html(" <?php if($unreadcount > 0){ echo $unreadcount; } ?>")
                                                <?php
                                                if($unreadcount > 0){
                                                    ?>
                                                    $("#messagescount").css({
                                                        "background-color": "green",
                                                        "color": "white",
                                                        "padding": "3px 5px 3px 5px",
                                                        "border-radius": "20px",
                                                        "font-size" : "10px",
                                                    })
                                                    <?php
                                                }
                                                ?>
                                            </script>
                                            <?php
                                        }else{
                                            ?>
                                            <script>
                                                $(".dbp4").append("<p><?php uilang("There is no message yet.") ?></p>")
                                            </script>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    
                                    
                                    <?php
                            
                                    if(isset($_POST["addnew"])){
                                        
                                        ?>
                                        <div class="dbp dbp0">
                                        <?php
                                        
                                        $productid = getRandomNumbers();
                                        $title = mysqli_real_escape_string($connection, $_POST["title"]);
                                        $price = mysqli_real_escape_string($connection, $_POST["price"]);
                                        $description = mysqli_real_escape_string($connection, $_POST["description"]);
                                    
                                        $maxsize = 2097152;
                                        if(($_FILES['productimage']['size'] >= $maxsize)){
                                            ?>
                                            <p>Uploaded image is too big. Try to upload different image.</p>
                                            <?php
                                        }else if($_FILES["productimage"]["size"] == 0){
                                            /*
                                            ?>
                                            <p>Uploaded image is file is invalid. Try to upload different image.</p>
                                            <?php
                                            */
                                        }else{
                                        	if($_FILES['productimage']['error'] > 0) { 
                                        	    ?>
                                        	    <p>Error during uploading new picture. Try again later.</p>
                                        	    <?php
                                        	}
                                        	$extsAllowed = array( 'jpg', 'jpeg', 'png' );
                                        	$uploadedfile = $_FILES["productimage"]["name"];
                                        	$extension = pathinfo($uploadedfile, PATHINFO_EXTENSION);
                                        	if (in_array($extension, $extsAllowed) ) { 
                                        	    $newppic = $productid;
                                            	$name = "upload/" . $newppic .".". $extension;
                                            	$result = move_uploaded_file($_FILES['productimage']['tmp_name'], $name);
                                            	createThumbnail($name, "upload/" . $newppic ."-thumb." . $extension, 256);
                                            	
                                            	//success!
                                            	mysqli_query($connection, "INSERT INTO $tableproducts (userid, productid, title, price, description, ext) VALUES ('$userid', '$productid', '$title' ,'$price', '$description', '$extension')");
                                            	?>
                                            	<p>Great! New product has been added.</p>
                                            	<script>
                                                setTimeout(function(){
                                                    location.href = "<?php echo $baseurl ?>?dashboard"
                                                }, 1000)
                                            </script>
                                            	<?php
                                        	} else {
                                        	    ?>
                                        	    <p>Incomplete information. Please try again.</p>
                                        	    <?php
                                        	}
                                        }
                                    
                                        
            
                                        ?>
                                        </div>
                                        <?php
                                    }
                                    
                                    if(isset($_POST["updateprofile"])){
                                        ?>
                                        <div class="dbp dbp0">
                                        <?php
                                        $name = mysqli_real_escape_string($connection, $_POST["name"]);
                                        $phone = mysqli_real_escape_string($connection, $_POST["phone"]);
                                        $address = mysqli_real_escape_string($connection, $_POST["address"]);
                                        $waenabled = mysqli_real_escape_string($connection, $_POST["waenabled"]);
                                        
                                        if($name != "" && $phone != "" && $address != ""){
                                            
                                            mysqli_query($connection, "UPDATE $tableusers SET name='$name', phone='$phone', address='$address', waenabled = $waenabled WHERE userid = '$userid'");
                                            
                                            ?>

                                            <p>Your profile has been updated.</p>
                                            <script>
                                                setTimeout(function(){
                                                    location.href = "<?php echo $baseurl ?>?dashboard"
                                                }, 1000)
                                            </script>

                                            <?php
                                        }else{
                                            ?>
                                            <p>Incomplete information!</p>
                                            <?php
                                        }
                                        ?>
                                        </div>
                                        <?php
                                    }
                                    
                                    if(isset($_GET["edit"])){
                                        ?>
                                        <div class="dbp dbp0">
                                        <?php
                                        
                                        $productid = mysqli_real_escape_string($connection, $_GET["edit"]);
                                        
                                        $sql = "SELECT * FROM $tableproducts WHERE productid = '$productid'";
                                        $row = mysqli_fetch_assoc(mysqli_query($connection, $sql));

                                        ?>
                                        <h3><? uilang("Edit Product") ?></h3>
                                        
                                        <?php 
                                        if(isset($_POST["updateproduct"])){
                                            $newtitle = mysqli_real_escape_string($connection, $_POST["title"]);
                                            $newprice = mysqli_real_escape_string($connection, $_POST["price"]);
                                            $newdescription = mysqli_real_escape_string($connection, $_POST["description"]);

                                            if($newtitle != "" && $newprice != "" && $newdescription != ""){
                                                
                                                if($userid == mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM $tableproducts WHERE productid='$productid' "))["userid"]){
                                                    mysqli_query($connection, "UPDATE $tableproducts SET title = '$newtitle', price = '$newprice', description = '$newdescription' WHERE productid = '$productid' AND userid = '$userid'");
                                                
                                                    $maxsize = 2097152;
                                                    if(($_FILES['productimage']['size'] >= $maxsize)){
                                                        ?>
                                                        <p>Uploaded image is too big. Try to upload different image.</p>
                                                        <?php
                                                    }else if($_FILES["productimage"]["size"] == 0){
                                                        /*
                                                        ?>
                                                        <p>Uploaded image is file is invalid. Try to upload different image.</p>
                                                        <?php
                                                        */
                                                    }else{
                                                    	if($_FILES['productimage']['error'] > 0) { 
                                                    	    ?>
                                                    	    <p>Error during uploading new picture. Try again later.</p>
                                                    	    <?php
                                                    	}
                                                    	$extsAllowed = array( 'jpg', 'jpeg', 'png' );
                                                    	$uploadedfile = $_FILES["productimage"]["name"];
                                                    	$extension = pathinfo($uploadedfile, PATHINFO_EXTENSION);
                                                    	if (in_array($extension, $extsAllowed) ) { 
                                                    	    $newppic = $productid;
                                                        	$name = "upload/" . $newppic .".". $extension;
                                                        	$result = move_uploaded_file($_FILES['productimage']['tmp_name'], $name);
                                                        	createThumbnail($name, "upload/" . $newppic ."-thumb." . $extension, 256);
                                                        	
                                                        	?>
                                                        	<p>Great! New photo has been added.</p>
                                                        	<?php
                                                    	}
                                                    }
                                                    
                                                    ?>
                                                    <p><?php uilang("Product has been successfully updated") ?>.</p>
                                                    <script>
                                                        setTimeout(function(){
                                                            location.href = "<?php echo $baseurl ?>?dashboard"
                                                        }, 1000)
                                                    </script>
                                                    <?php
                                                }else{
                                                    ?>
                                                    <p>You are not authorized!</p>
                                                    <?php
                                                }
                                                
                                                
                                            }else{
                                                ?>
                                                <p>Incomplete information!</p>
                                                <?php
                                            }
                                        }else{
                                            ?>
                                            
                                            <form method="post" action="<?php echo $baseurl ?>?dashboard&edit=<?php echo $productid ?>" enctype="multipart/form-data">
                                                <label><?php uilang("Title") ?></label>
                                                <input name="title" placeholder="<?php uilang("Title") ?>" value="<?php echo $row["title"] ?>">
                                                <label><?php uilang("Price") ?></label>
                                                <input name="price" type="number" placeholder="<?php uilang("Price") ?>" value="<?php echo $row["price"] ?>">
                                                <label><?php uilang("Description") ?></label>
                                                <textarea name="description" placeholder="<?php uilang("Description") ?>"><?php echo $row["description"] ?></textarea>
                                                <p>Current product photo (Click if you want to replace it):</p>
                                                <img src="upload/<?php echo $productid ?>.<?php echo $row["ext"] ?>" width="100%" style="cursor: pointer; border-radius: 10px;" onclick="$('#productimageupdate').click()">
                                                <input type="file" name="productimage" accept="image/*" id="productimageupdate" style="display: none;">
                                                <input  name="updateproduct" type="submit" value="Update" class="submitbutton">
                                            </form>
                                            
                                            <p><i class="fa fa-link"></i> <?php uilang("Click") ?> <a class="textlink" href="<?php echo $baseurl ?>?product=<?php echo $productid ?>"><?php uilang("here") ?></a> <?php uilang("to view this product") ?>.</p>
                                            <p style="color: red"><i class="fa fa-trash"></i> <?php uilang("Click") ?> <a class="textlink" href="<?php echo $baseurl ?>?dashboard&delete=<?php echo $productid ?>"><?php uilang("here") ?></a> <?php uilang("to delete it") ?>.</p>
                                            
                                            
                                            
                                            <?php
                                            
                                        }
                                        ?>
                                        </div>
                                        <?php
                                    }
                                    
                                    if(isset($_GET["delete"])){
                                        ?>
                                        <div class="dbp dbp0">
                                        <?php
                                        $productid = mysqli_real_escape_string($connection, $_GET["delete"]);
                                        
                                        $ext = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM $tableproducts WHERE productid='$productid' "))["ext"];
                                        
                                        if($userid == mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM $tableproducts WHERE productid='$productid' "))["userid"]){

                                            if(file_exists("upload/" . $productid . "." . $ext))
                                                unlink("upload/" . $productid . "." . $ext);
                                            if(file_exists("upload/" . $productid . "-thumb" . "." . $ext))
                                                unlink("upload/" . $productid . "-thumb" . "." . $ext);
                                                
                                            mysqli_query($connection, "DELETE FROM $tableproducts WHERE productid = '$productid' AND userid = '$userid'");
                                            
                                            ?>
                                            <p><?php uilang("Product has been successfully deleted") ?>.</p>
                                            <script>
                                                setTimeout(function(){
                                                    location.href = "<?php echo $baseurl ?>?dashboard"
                                                }, 1000)
                                            </script>
                                            <?php
                                            
                                        }else{
                                            ?>
                                            <p>You are not authorized!</p>
                                            <?php
                                        }
                                        
                                        ?>
                                        </div>
                                        <?php
                                    }
                                    
                                    ?>
                                    
                                    <div class="dbp dbp5">
                                        <h3><?php uilang("Chats") ?></h3>
                                        <div id="chats"></div>
                                        <div id="chatsupdatecripts"></div>
                                    </div>
                                </div>
                                
                            </div>
                            
                            
                            <script>
                                
    
                                function dbpage(num){
                                    $(".dbp").hide()
                                    $(".dbp" + num).show()
                                    if(num == 5){
                                        $("#chats").html("<div id='chatmessages'><p align='center' style='margin: 20px;'><?php uilang("Loading") ?>...</p></div><div id='chatconversations'><p><i class='fa fa-info'></i> <?php uilang("To start replying chat messages, click one of items on the left panel") ?>.</p></div>")
                                        onlineinterval = setInterval(function(){startonlinechat()},3000)
                                    }else{
                                        stoponlinechat("<?php echo $_SESSION["email"] ?>", "<?php echo $_SESSION["password"] ?>")
                                    }
                                }
                                
                                dbpage(1)
    
                                
                                <?php
                                if(isset($_POST["addnew"]) || isset($_POST["updateprofile"]) || isset($_GET["edit"]) || isset($_GET["delete"])){
                                    ?>
                                    dbpage(0)
                                    <?php
                                }
                                ?>
                                
                                if(location.href.indexOf("#") > -1){
                                    if(location.href.split("#")[0] != ""){
                                        dbpage(location.href.split("#")[1])
                                    }
                                }
                                
                                function startonlinechat(){
                                    $("#onlinestatus").html("Online")
                                    $("#chats").css({ "height" : (innerHeight - 300) + "px" })
                                    $("#chatmessages").css({ "box-sizing" : "border-box", "height" : "100%", "overflow" : "auto" })
                                    $("#onlinestatus").css({
                                        "background-color" : "<?php echo $primarycolor ?>"
                                    })
                                    var d = new Date()
                                    d = d.getTime()
                                    $.post("messagingsystem.php", { "sol" : "<?php echo $userid ?>", "password" : "<?php echo $_SESSION["password"] ?>", "lastonline" : d }, function(data){
                                        $("#chatsupdatecripts").html(data)
                                    })
                                }
                                
                                
                                function openchatmessage(n){
                                    $("#chatconversations").html("<div id='currentchatconversation'><p><?php uilang("Loading chat") ?> ID " + n + ". <?php uilang("Loading") ?>...</p></div><textarea id='currentchatreplyinput' placeholder='<?php uilang("Type your message here") ?>...' style='margin-top: 20px; margin-bottom: 5px;'></textarea><button onclick=replycurrentchat('"+n+"')><?php uilang("Send Message") ?></button>")
                                    
                                    clearInterval(chatupdateinterval)
                                    chatupdateinterval = setInterval(function(){
                                        updatechatconversation(n)
                                    }, 1500)
                                    
                                    setTimeout(function(){
                                        $("#currentchatconversation").scrollTop($('#currentchatconversation')[0].scrollHeight);
                                    }, 2000)
                                    
                                    $('html,body').animate({
                                        scrollTop: $("#chats").offset().top - 100
                                    }, 'slow');
                                }

                                
                            </script>
                            <?php
                            
                            
                        }else{
                            
                            ?>
                            <p align="center">You must login first to access this page.</p>
                            <?php
                        }
                        
                        ?>
                    </div>
                    <?php
                }else if(isset($_GET["product"])){
                    
                    include("adscript.php");
                    
                    $productid = mysqli_real_escape_string($connection, $_GET["product"]);
                    $sql = "SELECT * FROM $tableproducts WHERE productid = '$productid'";
                    $result = mysqli_query($connection, $sql);
                    
                    if(mysqli_num_rows($result) > 0){
                        $row = mysqli_fetch_assoc($result);
                        $sellerid = $row["userid"];
                        $sellerinfo = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM $tableusers WHERE userid = '$sellerid'"));
                        
                        ?>
                        <div class="middlebox">
                            <div class="singleproductholder">
                                <div class="singleproductrow sprleft">
                                    <div class="bigproductimage">
                                        <img src="upload/<?php echo $row["productid"] ?>.<?php echo $row["ext"] ?>" width="100%">
                                    </div>
                                </div>
                                <div class="singleproductrow">
                                    <div class="sprright">
                                        <h1><?php echo $row["title"] ?> <span style="font-size: 14px;"><?php uilang("Just for") ?></span> <span style="color: <?php echo $primarycolor ?>"><i class="fa fa-tag"></i><?php echo $currencysymbol . $row["price"] ?></span></h1>
                                        <h4><span style="font-size: 12px;"><?php uilang("Added by") ?></span> <a class="textlink" href="<?php echo $baseurl ?>?user=<?php echo $sellerid ?>"><i class="fa fa-user"></i> <?php echo $sellerinfo["name"] ?></a> <span style="font-size: 12px;"><?php uilang("from") ?></span> <i class="fa fa-map-marker"></i> <?php echo $sellerinfo["address"] ?></h4>
                                        <p><?php echo $row["description"] ?></p>
                                        
                                        <?php
                                        
                                        //if($_SESSION["userid"] != $sellerid){
                                            if(isset($_GET["chat"])){
                                                ?>
                                                <div class="messaging">
                                                    <h3><?php uilang("Messaging") ?></h3>
                                                    <p style="font-size: 12px;"><?php uilang("You are sending a message to") ?> <a class="textlink" href="<?php echo $baseurl ?>?user=<?php echo $sellerid ?>"><i class="fa fa-user"></i> <?php echo $sellerinfo["name"] ?></a>.</p>
                                                    <div id="currentchatconversation"></div>
                                                    <div id="messaging"></div>
                                                    <script>
                                                        <?php
                                                        include("messaging.php");
                                                        ?>
                                                    </script>
                                                </div>
                                                <?php
                                            }else{
                                                
                                                if($sellerinfo["waenabled"] == 1){
                                                    ?>
                                                    <a href="https://wa.me/<?php echo $sellerinfo["phone"] ?>?text=<?php uilang("Hi, I came across this link")?> <?php echo $baseurl . "?product=" . "$productid" ?> <?php uilang("and I want to ask some questions") ?>..."><div class="chatbutton" style="margin-right: 20px;"><i class="fa fa-whatsapp"></i> <?php uilang("Chat on WhatsApp") ?></div></a>
                                                    <?php
                                                }
                                                
                                                ?>
                                                <a href="<?php echo $baseurl ?>?product=<?php echo $productid ?>&chat=<?php echo $sellerid ?>"><div class="chatbutton" id="onlinechatbutton"><i class="fa fa-envelope"></i> <?php uilang("Send Message") ?></div></a>
                                                
                                                <script>
                                                    $.post("messagingsystem.php", { "isselleronline" : "<?php echo $sellerid ?>" }, function(data){
                                                        if(data != "0"){
                                                            var d = new Date()
                                                            d = d.getTime()
                                                            var lastonline = parseInt(data)
                                                            if(d - lastonline < 10000)
                                                                $("#onlinechatbutton").html("<i class='fa fa-commenting'></i> <?php uilang("Chat Now") ?>")
                                                        }
                                                    } )
                                                </script>
                                                <?php
                                            }
                                        //}
                                        
                                        ?>
                                        <div style="width: 100%; overflow: auto; box-sizing: border-box;">
                                            <br><br><br>
                                            <div id="fb-root"></div>
                                            <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&amp;version=v5.0&amp;appId=569420283509636&amp;autoLogAppEvents=1"></script>
                                             
                                            <div class="fb-comments" data-href="<?php echo $baseurl ?>?product=<?php echo $productid ?>" data-width="100%" style="width: 100%; box-sizing: border-box;" data-numposts="5"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        
                    }else{
                        ?>
                        <p align="center">There is nothing here, sir.</p>
                        <?php
                    }
                }else if(isset($_GET["user"])){
                    
                    include("adscript.php");
                    
                    $userid = mysqli_real_escape_string($connection, $_GET["user"]);
                    $sql = "SELECT * FROM $tableusers WHERE userid = '$userid'";
                    $result = mysqli_query($connection, $sql);
                    
                    if(mysqli_num_rows($result) > 0){
                        $row = mysqli_fetch_assoc($result);
                        ?>
                        
                        <div class="middlebox">
                            
                            <h1><?php uilang("Products added by") ?> <?php echo $row["name"] ?></h1>
                            <p><i class="fa fa-map-marker"></i> <?php echo $row["address"] ?></p>
                            
                            <?php
                            $sql = "SELECT * FROM $tableproducts WHERE userid = '$userid' ORDER BY id DESC";
                            $result = mysqli_query($connection, $sql);
                            if(mysqli_num_rows($result) > 0){
                                while($productrow = mysqli_fetch_assoc($result)){
                                    
                                    ?>
                                    <a href="<?php echo $baseurl ?>?product=<?php echo $productrow["productid"] ?>">
                                        <div class="productthumbnail">
                                            <div class="thumbnailimage" style="margin-bottom: 10px; background: url(upload/<?php echo $productrow["productid"] ?>-thumb.<?php echo $productrow["ext"] ?>) no-repeat center center; background-size: cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;">
                                                <div style="display: inline-block;">
                                                    <div class="pricetag"><i class="fa fa-tag"></i> <?php echo $currencysymbol . $productrow["price"] ?></div>
                                                </div>
                                            </div>
                                            
                                            
                                            <h3 style="margin: 0px;"><?php echo $productrow["title"] ?></h3>
                                            
                                            
                                            <h5 style="margin: 0px;"><i class="fa fa-user"></i> <?php echo $row["name"] ?></h5>
                                            <div class="shorttext">
                                                <?php echo $productrow["description"] ?>
                                            </div>
                                        </div>
                                    </a>
                                    <?php
                                }
                            }else{
                                ?>
                                <p align="center"><?php uilang("Coming soon!") ?></p>
                                <?php
                            }
                            ?>
                            
                        </div>
                        
                        <?php
                    }else{
                        ?>
                        <p align="center">There is nothing here, sir.</p>
                        <?php
                    }
                    
                }else if(isset($_GET["about"])){
                    
                    ?>
                    <div class="middlebox">
                        <?php include("about.php") ?>
                    </div>
                    <?php
                    
                }else if(isset($_GET["search"])){
                    
                    
                    ?>
                    <div class="middlebox">
                        <form method="post" action="<?php echo $baseurl ?>?search">
                            
                            <div id="searchbox">
                                <div class="sbitem" style="width: 50px;">
                                    <i class="fa fa-search"></i>
                                </div>
                                <div class="sbitem">
                                    <input name="search" placeholder="What are you looking for?" style="outline: none; border: none; background-color: inherit; margin: 0px;">
                                </div>
                                <div class="sbitem" style="width: 100px;">
                                    <input type="submit" value="Find it!" style="background-color: <?php echo $primarycolor ?>; margin: 0px; color: white; border-radius: 20px; outline: none;">
                                </div>
                            </div>
                            
                            
                            <?php
                            if(isset($_POST["search"])){
                                
                                $query = mysqli_real_escape_string($connection, $_POST["search"]);
                                
                                $sql = "SELECT * FROM $tableproducts WHERE title LIKE '%$query%' OR description LIKE '%$query%' ORDER BY id DESC";
                                $result = mysqli_query($connection, $sql);
                                if($query != ""){
                                    if(mysqli_num_rows($result) > 0){
                                        
                                        include("adscript.php");
                                        
                                        ?>
                                        
                                        <h3 align="center" style="margin: 30px;">Search results:</h3>
                                        <?php
                                        while($row = mysqli_fetch_assoc($result)){
                                            $uid = $row["userid"];
                                            $sellername = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM $tableusers WHERE userid = '$uid'"))["name"];
                                            
                                            ?>
                                            <a href="<?php echo $baseurl ?>?product=<?php echo $row["productid"] ?>">
                                                <div class="productthumbnail">
                                                    <div class="thumbnailimage" style="margin-bottom: 10px; background: url(upload/<?php echo $row["productid"] ?>-thumb.<?php echo $row["ext"] ?>) no-repeat center center; background-size: cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;">
                                                        <div style="display: inline-block;">
                                                            <div class="pricetag"><i class="fa fa-tag"></i> <?php echo $currencysymbol . $row["price"] ?></div>
                                                        </div>
                                                    </div>
    
                                                    <h3 style="margin: 0px;"><?php echo $row["title"] ?></h3>
    
                                                    <h5 style="margin: 0px;"><i class="fa fa-user"></i> <?php echo $sellername ?></h5>
                                                    <div class="shorttext">
                                                        <?php echo $row["description"] ?>
                                                    </div>
                                                </div>
                                            </a>
                                            <?php
                                        }
                                    }else{
                                        ?>
                                        <h3 align="center" style="margin: 30px;">Search results:</h3>
                                        <p align="center">Nothing found.</p>
                                        <?php
                                    }
                                }else{
                                    ?>
                                    <h3 align="center" style="margin: 30px;">Search results:</h3>
                                    <p align="center">Nothing found.</p>
                                    <?php
                                }
                            }
                            ?>
                            
                        </form>
                    </div>
                    <?php
                }else{
                    
                    //include("adscript.php");
                    
                    ?>
                    <div style="text-align: center;">
                        
                        
                            
                        <?php
                        
                        $sql = "SELECT * FROM $tableproducts ORDER BY id DESC";
                        $result = mysqli_query($connection, $sql);
                        if(mysqli_num_rows($result) > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                $uid = $row["userid"];
                                
                                
                                $sellername = mysqli_fetch_assoc(mysqli_query($connection, "SELECT * FROM $tableusers WHERE userid = '$uid'"))["name"];
                                
                                ?>
                                <a href="<?php echo $baseurl ?>?product=<?php echo $row["productid"] ?>">
                                    <div class="productthumbnail">
                                        <div class="thumbnailimage" style="margin-bottom: 10px; background: url(upload/<?php echo $row["productid"] ?>-thumb.<?php echo $row["ext"] ?>) no-repeat center center; background-size: cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;">
                                            <div style="display: inline-block;">
                                                <div class="pricetag"><i class="fa fa-tag"></i> <?php echo $currencysymbol . $row["price"] ?></div>
                                            </div>
                                        </div>
                                        <h3 style="margin: 0px; display: block;"><?php echo $row["title"] ?></h3>
                                        <h5 style="margin: 0px;"><i class="fa fa-user"></i> <?php echo $sellername ?></h5>
                                        <div class="shorttext">
                                            <?php echo $row["description"] ?>
                                        </div>
                                    </div>
                                </a>
                                <?php
                            }
                        }else{
                            ?>
                            <p align="center"><?php uilang("Coming soon!") ?></p>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
            ?>
            
        </div>
        <div id="footer">
            
            <div>
                <div class="footeritem"><a href="<?php echo $baseurl ?>"><?php uilang("Home"); ?></a></div>
                <?php 
                if(isset($_SESSION["email"])){
                    ?>
                    <div class="footeritem"><a href="<?php echo $baseurl ?>?dashboard"><?php uilang("Dashboard"); ?></a></div>
                    <div class="footeritem"><a href="<?php echo $baseurl ?>?logout"><?php uilang("Logout"); ?></a></div>
                    <?php
                }else{
                    ?>
                    <div class="footeritem"><a href="<?php echo $baseurl ?>?login"><?php uilang("Login"); ?></a></div>
                    <div class="footeritem"><a href="<?php echo $baseurl ?>?register"><?php uilang("Register"); ?></a></div>
                    <?php
                }
                ?>
                <div class="footeritem"><a href="<?php echo $baseurl ?>?about"><?php uilang("About"); ?></a></div>
            </div>
            
            <div style="margin: 30px;">
                <p style="font-size: 10px;">© Copyright <?php echo $websitename ?> <?php echo date("Y"); ?>. All rights reserved.</p>
            </div>
            
        </div>
        <div id="buyerchatscript"></div>
        <script>
        
            function toggleDrawer(){
                $("#appbarmenu").toggle()
            }
            
            $(document).ready(function(){
                /*
                $('.homeslider').slick({
                    autoplay : true,
                    infinite: true,
                    speed: 600,
                    pauseOnFocus: false,
                    pauseOnHover: false,
                });
                */
            })
            
            function openlink(url){
                location.href = url
            }
            
                
            
            <?php
            if(!isset($_GET["dashboard"])){
                if(isset($_SESSION["email"])){
                    ?>
                    stoponlinechat("<?php echo $_SESSION["email"] ?>", "<?php echo $_SESSION["password"] ?>")
                    <?php
                }
            }
            ?>
            
            function updatechatconversation(n){
                $.post("messagingsystem.php", {
                    "updatechatconversation" : n
                }, function(data){
                    $("#currentchatconversation").html(data)
                })
            }
            
            function replycurrentchat(messageid){
                
                var currentreply = $("#currentchatreplyinput").val()
                if(currentreply != ""){
                    var messagingtype = 0
                    $.post("messagingsystem.php", {
                        "userid" : "xxx",
                        "productid" : "xxx",
                        "offlinemessage" : messagingtype,
                        "senderemail" : "xxx",
                        "content" : currentreply,
                        "messageid" : messageid,
                        "chatmessaging" : "yes",
                        "selleranswer" : "yes"
                    }, function(data){
                        $("#currentchatreplyinput").val("").focus()
                        $("#currentchatconversation").append("<?php uilang("Loading") ?>...")
                        setTimeout(function(){
                            $("#currentchatconversation").scrollTop($('#currentchatconversation')[0].scrollHeight);
                        }, 2000)
                        
                    })
                }else{
                    alert("Write something first.")
                }
                
            }
            
        </script>
        
        <?php 
            echo uilang("Messaging", 0);
        ?>
    </body>
</html>