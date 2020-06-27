<?php
    session_start();
    include("config.php");
    include("functions.php");
?>


<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $websitetitle ?></title>
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
        
        <link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
        <link rel="manifest" href="favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        
        
        <style>
            <?php
            include("style1.php");
            ?>
        </style>
        
        <link rel="stylesheet" type="text/css" href="slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="slick/slick-theme.css"/>
        <script type="text/javascript" src="slick/slick.min.js"></script>
        
    </head>
    <body>
        <div id="appbar">
            <div style="display: inline-block;">
                <a href="<?php echo $baseurl ?>"><img src="images/weblogo.png" width="200px"></a>
            </div>
            <div id="mobilebutton" class="mobilevisible" onclick="toggleDrawer()"><i class="fa fa-bars"></i></div>
            <div id="appbarmenu">
                <div class="ablink mobilevisible" onclick="toggleDrawer()" style="padding: 40px;"><i class="fa fa-times"></i></div>
                <a href="<?php echo $baseurl ?>"><div class="ablink">Home</div></a>
                <?php 
                if(isset($_SESSION["email"])){
                    ?>
                    <a href="<?php echo $baseurl ?>?dashboard"><div class="ablink">Dashboard</div></a>
                    <a href="<?php echo $baseurl ?>?logout"><div class="ablink">Logout</div></a>
                    <?php
                }else{
                    ?>
                    <a href="<?php echo $baseurl ?>?login"><div class="ablink">Login</div></a>
                    <a href="<?php echo $baseurl ?>?register"><div class="ablink">Register</div></a>
                    <?php
                }
                ?>
                <a href="<?php echo $baseurl ?>?about"><div class="ablink">About</div></a>
                <a href="<?php echo $baseurl ?>?search"><div class="ablink"><i class="fa fa-search"></i></div></a>
                
            </div>
        </div>
        <div id="mainbanner">
            <h2>Tasty Home Cooks</h2><h4>For Everyone</h4>
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
                                $_SESSION["userid"] = mysqli_fetch_assoc($result)["userid"];
                                ?>
                                <p>Welcome!</p>
                                <script>
                                    setTimeout(function(){
                                        location.href = "<?php echo $baseurl ?>?dashboard"
                                    }, 1000)
                                </script>
                                <?php
                            }else{
                                ?>
                                <p>Incorrect email and/or password!</p>
                                <?php
                            }
                        }else{
                            ?>
                            <h2>Login</h2>
                            <form method="post" action="<?php echo $baseurl ?>?login">
                                <label>Email</label>
                                <input name="email" type="email" placeholder="Email">
                                <label>Password</label>
                                <input name="password" type="password" placeholder="Password">
                                <input name="login" type="submit" placeholder="Login" class="submitbutton"> 
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
                                    <p>This email address is already registered. Try to use another email.</p>
                                    <?php
                                }else{
                                    mysqli_query($connection, "INSERT INTO $tableusers (datereg, email, password, name, phone, address, userid) VALUES ('$datereg', '$email', '$password', '$name', '$phone', '$address', '$userid')");
                                    ?>
                                    <p>Thank you for registering!</p>
                                    <script>
                                        setTimeout(function(){
                                            location.href = "<?php echo $baseurl ?>?dashboard"
                                        }, 1000)
                                    </script>
                                    <?php
                                    $_SESSION["email"] = $email;
                                    $_SESSION["userid"] = $userid;
                                }
                            }else{
                                ?>
                                <p>You did not fill all the fields. Please try again.</p>
                                <?php
                            }

                        }else{
                            ?>
                            <h2>Register</h2>
                            <form method="post" action="<?php echo $baseurl ?>?register">
                                <label>Email</label>
                                <input name="email" type="email" placeholder="Email">
                                <label>Password</label>
                                <input name="password" type="password" placeholder="Password">
                                <label>Name/Nickname</label>
                                <input name="name" type="text" placeholder="Your name or nickname">
                                <label>Phone Number</label>
                                <p>*Include your country code before your phone number like this: 6590611234</p>
                                <input name="phone" type="number" placeholder="Phone number">
                                <label>Address</label>
                                <input name="address" type="text" placeholder="Address">
                                <input name="register" type="submit" value="Register" class="submitbutton">
                            </form>
                            <?php
                        }
                    
                        ?>
                        
                    </div>
                    <?php
                }else if(isset($_GET["logout"])){
                    ?>
                    <p align="center">Good bye!</p>
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
                            $name = "";
                            $phone = "";
                            $address = "";
                            
                            $sql = "SELECT * FROM $tableusers WHERE email = '$email'";
                            $result = mysqli_query($connection, $sql);
                            
                            while($row = mysqli_fetch_assoc($result)){
                                $name = $row["name"];
                                $phone = $row["phone"];
                                $address = $row["address"];
                            }
                            ?>
                            
                            
                            
                            <div class="dashboardcontentholder">
                                
                                <div class="dashboardcell dbcleft">
                                    <div class="dashboardleftbutton" onclick="dbpage(1)"><i class="fa fa-plus" style="width: 20px;"></i> New</div>
                                    <div class="dashboardleftbutton" onclick="dbpage(2)"><i class="fa fa-cutlery" style="width: 20px;"></i> Products</div>
                                    <div class="dashboardleftbutton" onclick="dbpage(3)"><i class="fa fa-user" style="width: 20px;"></i> Profile</div>
                                    <div class="dashboardleftbutton" onclick="dbpage(4)"><i class="fa fa-envelope" style="width: 20px;"></i> Messages</div>
                                </div>
                                <div class="dashboardcell dbcright">
                                    <div class="dbp dbp1">
                                        <h3>Add New Product</h3>
                                        <form method="post" action="<?php echo $baseurl ?>?dashboard" enctype="multipart/form-data">
                                            <input name="title" placeholder="Title">
                                            <input name="price" type="number" placeholder="Price">
                                            <textarea name="description" placeholder="Description"></textarea>
                                            <p>Choose your product photo:</p>
                                            <input type="file" name="productimage" accept="image/*">
                                            <input name="addnew" type="submit" value="Sell" class="submitbutton">
                                        </form>
                                    </div>
                                    <div class="dbp dbp2">
                                        <h3>Your Products</h3>
                                        <?php
                                        $sql = "SELECT * FROM $tableproducts WHERE userid = '$userid' ORDER BY id DESC";
                                        $result = mysqli_query($connection, $sql);
                                        if(mysqli_num_rows($result) > 0){
                                            ?>
                                            <p>Click to edit one of your published products.</p>
                                            <?php
                                            while($productrow = mysqli_fetch_assoc($result)){
                                                
                                                ?>
                                                <a href="<?php echo $baseurl ?>?dashboard&edit=<?php echo $productrow["productid"] ?>">
                                                    <div class="productthumbnail">
                                                        <div class="thumbnailimage" style="margin-bottom: 10px; background: url(upload/<?php echo $productrow["productid"] ?>-thumb.<?php echo $productrow["ext"] ?>) no-repeat center center; background-size: cover; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover;">
                                                            <div style="display: inline-block;">
                                                                <div class="pricetag"><i class="fa fa-tag"></i> $<?php echo $productrow["price"] ?></div>
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
                                            <p align="center">You don't have any product yet.</p>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    
                                    <div class="dbp dbp3">
                                        <h3>Profile</h3>
                                        <form action="<?php echo $baseurl ?>?dashboard" method="post">
                                            <label>Name/Nickname</label>
                                            <input name="name" type="text" placeholder="Your name or nickname" value="<?php echo $name ?>">
                                            <label>Phone Number</label>
                                            <p>*Include your country code before your phone number like this: 6590611234</p>
                                            <input name="phone" type="number" placeholder="Phone number" value="<?php echo $phone ?>">
                                            <label>Address</label>
                                            <input name="address" type="text" placeholder="Address" value="<?php echo $address ?>">
                                            <input name="updateprofile" type="submit" value="Update" class="submitbutton">
                                        </form>
                                    </div>
                                    <div class="dbp dbp4">
                                        <h3>Messages</h3>
                                        <?php
                                        
                                        if(isset($_GET["readmessage"])){
                                            
                                            $messageid = mysqli_real_escape_string($connection, $_GET["readmessage"]);
                                            $sql = "SELECT * FROM $tablemessages WHERE userid = '$userid' AND messageid = '$messageid'";
                                            $result = mysqli_query($connection, $sql);
                                            $row = mysqli_fetch_assoc($result);
                                            
                                            if(mysqli_num_rows($result) > 0){
                                                $msql = "SELECT * FROM $tableconversations WHERE messageid = '$messageid' AND fromseller = 1";
                                                $mresult = mysqli_query($connection, $msql);
                                                $mrow = mysqli_fetch_assoc($mresult);
                                                mysqli_query($connection, "UPDATE $tableconversations SET isread = 1 WHERE messageid = '$messageid'");
                                                ?>
                                                <script>
                                                    setTimeout(function(){
                                                        $("#messagestable").hide()
                                                        $("#messagecontent").show().html("<div><div onclick='backToMessages()' class='textlink'><i class='fa fa-arrow-left'></i> Back</div><div style='padding: 20px; font-size: 12px;'><p style='font-size: 12px;'>Message ID: <? echo $row["messageid"] ?></p><p><b>Sender:</b> <?php echo $row["senderemail"] ?><br><b>Date:</b> <?php echo $mrow["timestamp"] ?><br><b>Product link:</b> <?php echo $baseurl ?>?product=123123123123</p><div align='left'><div class='msgthatperson'><div class='msgtimestamp'><?php echo $mrow["timestamp"] ?></div><div class='msgbody'><?php echo $mrow["content"] ?></div></div></div></div><div id='replies'></div><textarea id='offlinereplyinput'></textarea><button class='submitbutton' onclick='offlinereply()'>Reply</button></div>")
                                                    }, 500)
                                                    
                                                    
                                                    <?php
                                                
                                                    $repliessql = "SELECT * FROM $tableconversations WHERE messageid = '$messageid' AND fromseller = 0";
                                                    
                                                    $repliesresult = mysqli_query($connection, $repliessql);
                                                    if(mysqli_num_rows($repliesresult) > 0){
                                                        while($repliesrow = mysqli_fetch_assoc($repliesresult)){
                                                            ?>
                                                            setTimeout(function(){
                                                                $("#replies").append("<div align='right'><div class='msg'><div class='msgtimestamp'>You replied on <?php echo $repliesrow["timestamp"] ?>:</div><div class='msgbody'><?php echo preg_replace( "/(\r|\n)/", "", nl2br($repliesrow["content"])) ?></div></div></div>")
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
                                                        $("#messagecontent").show().html("<div><div onclick='backToMessages()' class='textlink'><i class='fa fa-arrow-left'></i> Back</div><p>You are not authorized to view this message.</p></div>")
                                                    }, 500)
                                                </script>
                                                <?php
                                            }
                                            
                                            
                                            ?>
                                            <script>
                                                
                                                function backToMessages(){
                                                    $("#messagestable").show()
                                                    $("#messagecontent").hide()
                                                }
                                            </script>
                                            <?php
                                            
                                        }
                                        
                                        $sql = "SELECT * FROM $tablemessages WHERE userid = '$userid' AND offlinemessage = 1 ORDER BY id DESC";
                                        $result = mysqli_query($connection, $sql);
                                        
                                        ?>
                                        <div id="messagecontent"></div>
                                        <div id="messagestable">
                                            <table style="width=100%">
                                                <tr>
                                                    <th>
                                                        <i class="fa fa-envelope"></i>
                                                    </th>
                                                    <th>
                                                        Date
                                                    </th>
                                                    <th>
                                                        Sender
                                                    </th>
                                                    <th>
                                                        Message
                                                    </th>
                                                </tr>
                                                <?php
                                            
                                                while($row = mysqli_fetch_assoc($result)){
                                                    
                                                    $messageid = $row["messageid"];
                                                    $msql = "SELECT * FROM $tableconversations WHERE messageid = '$messageid'";
                                                    $mresult = mysqli_query($connection, $msql);
                                                    while($mrow = mysqli_fetch_assoc($mresult)){
                                                        if($mrow["fromseller"] == 1){
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
                                        <?php
                                        
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
                                        
                                        if($name != "" && $phone != "" && $address != ""){
                                            
                                            mysqli_query($connection, "UPDATE $tableusers SET name='$name', phone='$phone', address='$address' WHERE userid = '$userid'");
                                            
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
                                        <h3>Edit Product</h3>
                                        
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
                                                    <p>Product has been successfully updated.</p>
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
                                                <label>Title</label>
                                                <input name="title" placeholder="Title" value="<?php echo $row["title"] ?>">
                                                <label>Price</label>
                                                <input name="price" type="number" placeholder="Price" value="<?php echo $row["price"] ?>">
                                                <label>Description</label>
                                                <textarea name="description" placeholder="Description"><?php echo $row["description"] ?></textarea>
                                                <p>Current product photo (Click if you want to replace it):</p>
                                                <img src="upload/<?php echo $productid ?>.<?php echo $row["ext"] ?>" width="100%" style="cursor: pointer; border-radius: 10px;" onclick="$('#productimageupdate').click()">
                                                <input type="file" name="productimage" accept="image/*" id="productimageupdate" style="display: none;">
                                                <input  name="updateproduct" type="submit" value="Update" class="submitbutton">
                                            </form>
                                            
                                            <p><i class="fa fa-link"></i> Click <a class="textlink" href="<?php echo $baseurl ?>?product=<?php echo $productid ?>">here</a> to view this product.</p>
                                            <p style="color: red"><i class="fa fa-trash"></i> Or click <a class="textlink" href="<?php echo $baseurl ?>?dashboard&delete=<?php echo $productid ?>">here</a> to delete it.</p>
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
                                            <p>Product has been successfully deleted.</p>
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
                                </div>
                            </div>
                            
                            
                            <script>
                                
    
                                function dbpage(num){
                                    $(".dbp").hide()
                                    $(".dbp" + num).show()
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
                                        <h1><?php echo $row["title"] ?> <span style="font-size: 14px;">Just for</span> <span style="color: <?php echo $primarycolor ?>"><i class="fa fa-tag"></i>$<?php echo $row["price"] ?></span></h1>
                                        <h4><span style="font-size: 12px;">Added by</span> <a class="textlink" href="<?php echo $baseurl ?>?user=<?php echo $sellerid ?>"><i class="fa fa-user"></i> <?php echo $sellerinfo["name"] ?></a> <span style="font-size: 12px;">from</span> <i class="fa fa-map-marker"></i> <?php echo $sellerinfo["address"] ?></h4>
                                        <p><?php echo $row["description"] ?></p>
                                        
                                        <?php
                                        
                                        //if($_SESSION["userid"] != $sellerid){
                                            if(isset($_GET["chat"])){
                                                ?>
                                                <div class="messaging">
                                                    <h3>Messaging</h3>
                                                    <p style="font-size: 12px;">You are sending a message to <a class="textlink" href="<?php echo $baseurl ?>?user=<?php echo $sellerid ?>"><i class="fa fa-user"></i> <?php echo $sellerinfo["name"] ?></a>.</p>
                                                    <div id="messaging"></div>
                                                    <script>
                                                        <?php
                                                        include("messaging.php");
                                                        ?>
                                                    </script>
                                                </div>
                                                <?php
                                            }else{
                                                
                                                ?>
                                                <a href="https://wa.me/<?php echo $sellerinfo["phone"] ?>?text=Hi, I came across this link <?php echo $baseurl . "?product=" . "$productid" ?> and I want to ask some questions..."><div class="chatbutton" style="margin-right: 20px;"><i class="fa fa-whatsapp"></i> Chat Now</div></a>
                                                <a href="<?php echo $baseurl ?>?product=<?php echo $productid ?>&chat=<?php echo $sellerid ?>"><div class="chatbutton"><i class="fa fa-envelope"></i> Send Message</div></a>
                                                <?php
                                            }
                                        //}
                                        
                                        ?>
                                        
                                        <br><br><br>
                                        <div id="fb-root"></div>
                                        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&amp;version=v5.0&amp;appId=569420283509636&amp;autoLogAppEvents=1"></script>
                                         
                                        <div class="fb-comments" data-href="<?php echo $baseurl ?>?product=<?php echo $productid ?>" data-width="" data-numposts="5"></div>
                                        
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
                    
                    $userid = mysqli_real_escape_string($connection, $_GET["user"]);
                    $sql = "SELECT * FROM $tableusers WHERE userid = '$userid'";
                    $result = mysqli_query($connection, $sql);
                    
                    if(mysqli_num_rows($result) > 0){
                        $row = mysqli_fetch_assoc($result);
                        ?>
                        
                        <div class="middlebox">
                            
                            <h1>Products added by <?php echo $row["name"] ?></h1>
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
                                                    <div class="pricetag"><i class="fa fa-tag"></i> $<?php echo $productrow["price"] ?></div>
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
                                <p align="center">Coming soon!</p>
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
                                                            <div class="pricetag"><i class="fa fa-tag"></i> $<?php echo $row["price"] ?></div>
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
                                            <div class="pricetag"><i class="fa fa-tag"></i> $<?php echo $row["price"] ?></div>
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
                        <p align="center">Coming soon!</p>
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
                <div class="footeritem"><a href="<?php echo $baseurl ?>">Home</a></div>
                <?php 
                if(isset($_SESSION["email"])){
                    ?>
                    <div class="footeritem"><a href="<?php echo $baseurl ?>?dashboard">Dashboard</a></div>
                    <div class="footeritem"><a href="<?php echo $baseurl ?>?logout">Logout</a></div>
                    <?php
                }else{
                    ?>
                    <div class="footeritem"><a href="<?php echo $baseurl ?>?login">Login</a></div>
                    <div class="footeritem"><a href="<?php echo $baseurl ?>?register">Register</a></div>
                    <?php
                }
                ?>
                <div class="footeritem"><a href="<?php echo $baseurl ?>?about">About</a></div>
            </div>
            
            <div style="margin: 30px;">
                <p style="font-size: 10px;">Copyright 2020. All rights reserved.</p>
            </div>
            
        </div>
        
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
            
            
            
        </script>
    </body>
</html>