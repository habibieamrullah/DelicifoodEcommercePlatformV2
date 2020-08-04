<?php
session_start();
include("config.php");

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title><?php echo $websitename ?> - SuperAdmin</title>
        <style>
            <?php
            include("style1.php");
            ?>
            body{
                color: white;
                font-size: 12px;
                padding: 20px;
            }
            .faicon{
                display: inline-block;
                padding: 5px;
                margin: 5px;
                font-size: 20px;
                cursor: pointer;
            }
            .faicon:hover{
                background-color: <?php echo $primarycolor ?>;
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="falist.js"></script>
        <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.css">
    </head>
    <body>
        <div>
            <?php
            if(isset($_GET["logout"])){
                session_destroy();
                ?>
                <p>Bye!</p>
                <script>
                    location.href = "<?php baseurl ?>superadmin.php"
                </script>
                <?php
            }
            
            if(isset($_POST["sapassword"])){
                if($sausername == $_POST["sausername"] && $sapassword == $_POST["sapassword"]){
                    $_SESSION["sausername"] = $_POST["sausername"];
                    $_SESSION["sapassword"] = $_POST["sapassword"];
                    ?>
                    <p>Login OK</p>
                    <script>
                        location.href = "<?php $baseurl ?>superadmin.php"
                    </script>
                    <?php
                }else{
                    ?>
                    <p>Invalid!</p>
                    <?php
                }
            }
            else if(isset($_SESSION["sausername"]) && isset($_SESSION["sapassword"])){
                if($sausername == $_SESSION["sausername"] && $sapassword == $_SESSION["sapassword"]){
                    ?>
                    <div style="margin-bottom: 20px;">
                        <a class='textlink' href="<?php echo $baseurl ?>superadmin.php"><i class="fa fa-home"></i> Home</a> |
                        <a class='textlink' href="?logout"><i class="fa fa-sign-out"></i> Logout</a>
                    </div>
                    
                    <?php
                    if(isset($_POST["submitnewcategory"])){
                        $category = mysqli_real_escape_string($connection, $_POST["category"]);
                        $faicon = mysqli_real_escape_string($connection, $_POST["faicon"]);
                        mysqli_query($connection, "INSERT INTO $tablecategories (category, faicon) VALUES ('$category', '$faicon')");
                        ?>
                        <div class='alert'>New category "<?php echo $category ?>" added.</div>
                        <?php
                    }
                    if(isset($_GET["edituser"])){
                        if(isset($_POST["updateuser"])){
                            $userid = mysqli_real_escape_string($connection, $_POST["userid"]);
                            $name = mysqli_real_escape_string($connection, $_POST["name"]);
                            $email = mysqli_real_escape_string($connection, $_POST["email"]);
                            $phone = mysqli_real_escape_string($connection, $_POST["phone"]);
                            $address = mysqli_real_escape_string($connection, $_POST["address"]);
                            $latlng = mysqli_real_escape_string($connection, $_POST["latlng"]);
                            
                            if($name != "" && $email != "" && $phone != "" && $address != ""){
                                mysqli_query($connection, "UPDATE $tableusers SET name = '$name', email = '$email', phone = $phone, address = '$address', latlng = '$latlng' WHERE userid = '$userid'");
                            }
                            
                            echo "<div class='alert'>User info updated.</div>";
                        }
                        
                        $userid = mysqli_real_escape_string($connection, $_GET["edituser"]);
                        $sql = "SELECT * FROM $tableusers WHERE userid = '$userid'";
                        $result = mysqli_query($connection, $sql);
                        if(mysqli_num_rows($result) > 0){
                            $row = mysqli_fetch_assoc($result);
                            ?>
                            <h1>Edit user info</h1>
                            <form method="post">
                                <input name="userid" value="<?php echo $row["userid"] ?>" readonly>
                                <input name="name" value="<?php echo $row["name"] ?>">
                                <input name="email" value="<?php echo $row["email"] ?>">
                                <input name="phone" value="<?php echo $row["phone"] ?>">
                                <input name="address" value="<?php echo $row["address"] ?>">
                                <input name="latlng" value="<?php echo $row["latlng"] ?>">
                                <input class="submitbutton" type="submit" name="updateuser" value="Submit">
                            </form>
                            <?php
                        }
                        ?>
                        <?php
                        
                    }else if(isset($_GET["editproduct"])){
                        $productid = mysqli_real_escape_string($connection, $_GET["editproduct"]);
                        if(isset($_POST["editproductupdate"])){
                            $title = mysqli_real_escape_string($connection, $_POST["title"]);
                            $price = mysqli_real_escape_string($connection, $_POST["price"]);
                            $description = mysqli_real_escape_string($connection, $_POST["description"]);
                            $catid = mysqli_real_escape_string($connection, $_POST["catid"]);
                            
                            mysqli_query($connection, "UPDATE $tableproducts SET title = '$title', price = $price, description = '$description', catid = $catid WHERE productid = '$productid'");
                            ?>
                            <div style="alert">Product has been updated.</div>
                            <?php
                        }else{
                            $sql = "SELECT * FROM $tableproducts WHERE productid = '$productid'";
                            $row = mysqli_fetch_assoc(mysqli_query($connection, $sql));
                            ?>
                            <h1>Edit Product : <?php echo $row["title"] ?></h1>
                            <form method="post">
                                <input name="productid" value="<?php echo $row["productid"] ?>" readonly>
                                <input name="title" value="<?php echo $row["title"] ?>">
                                <input name="price" value="<?php echo $row["price"] ?>">
                                <textarea name="description"><?php echo $row["description"] ?></textarea>
                                <select name="catid">
                                    <?php
                                    $catsql = "SELECT * FROM $tablecategories ORDER BY category ASC";
                                    $catresult = mysqli_query($connection, $catsql);
                                    if(mysqli_num_rows($catresult) > 0){
                                        while($catrow = mysqli_fetch_assoc($catresult)){
                                            if($catrow["id"] == $row["catid"]){
                                                ?>
                                                <option value="<?php echo $catrow["id"] ?>" selected="selected"><?php echo $catrow["category"] ?></option>
                                                <?php
                                            }else{
                                                ?>
                                                <option value="<?php echo $catrow["id"] ?>"><?php echo $catrow["category"] ?></option>
                                                <?php
                                            }
                                        }
                                        if($row["catid"] == 0){
                                            ?>
                                            <option value="0" selected="selected">Other</option>
                                            <?php
                                        }else{
                                            ?>
                                            <option value="0">Other</option>
                                            <?php
                                        }
                                        
                                    }else{
                                        ?>
                                        <option selected="selected">Other</option>
                                        <?php
                                    }
                                    ?>
                                </select>
                                <input class="submitbutton" type="submit" name="editproductupdate" value="Submit">
                            </form>
                            <?php
                        }
                    }else if(isset($_GET["editcategory"])){
                        $catid = mysqli_real_escape_string($connection, $_GET["editcategory"]);
                        if(isset($_POST["updateexistingcategory"])){
                            $newcatname = mysqli_real_escape_string($connection, $_POST["newcatname"]);
                            $newcaticon = mysqli_real_escape_string($connection, $_POST["newfaicon"]);
                            mysqli_query($connection, "UPDATE $tablecategories SET category = '$newcatname', faicon = '$newcaticon' WHERE id = $catid");
                            ?>
                            <div class="alert">Category updated.</div>
                            <?php
                        }
                        
                        
                        $sql = "SELECT * FROM $tablecategories WHERE id = $catid";
                        $result = mysqli_query($connection, $sql);
                        if(mysqli_num_rows($result) > 0){
                            $row = mysqli_fetch_assoc($result);
                            ?>
                            <h1>Edit Category with ID <?php echo $catid ?></h1>
                            <form method="post">
                                <input name="newcatname" placeholder="Category title" value="<?php echo $row["category"] ?>">
                                <input id="faiconinput" name="newfaicon" placeholder="FA-Icon" value="<?php echo $row["faicon"] ?>" readonly>
                                <div id="falist" style="max-height: 256px; overflow: auto;"></div>
                                <input class="submitbutton" type="submit" value="Update" name="updateexistingcategory">
                            </form>
                            
                            <script>
                                for(var i = 0; i < falist.length; i++){
                                    $("#falist").append("<div class='faicon' onclick=applyicon('" +falist[i]+ "')><i class='fa "+falist[i]+"'></i></div>")
                                }
                                
                                function applyicon(icon){
                                    $("#faiconinput").val(icon)
                                }
                            </script>
                            <?php
                        }
                    }else if(isset($_GET["deletecategory"])){
                        $catid = mysqli_real_escape_string($connection, $_GET["deletecategory"]);
                        mysqli_query($connection, "DELETE FROM $tablecategories WHERE id = $catid");
                        mysqli_query($connection, "UPDATE $tableproducts SET catid = 0 WHERE catid = $catid");
                        echo "<div class='alert'>Category " .$catid. " deleted.</div>";
                    }else{
                        ?>
                        <div style="margin-bottom: 20px; cursor: pointer;">
                            <span onclick="onlyshow('users')">Users | </span>
                            <span onclick="onlyshow('products')">Products | </span>
                            <span onclick="onlyshow('categories')">Categories</span>
                        </div>
                        <div class="page" id="users">
                    
                            <h1>Users</h1>
                            <?php
                            $sql = "SELECT * FROM $tableusers ORDER BY id DESC";
                            $result = mysqli_query($connection, $sql);
                            if(mysqli_num_rows($result) > 0){
                                ?>
                                <table>
                                    <tr>
                                        <th>
                                            UserID
                                        </th>
                                        <th>
                                            DateReg
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Phone
                                        </th>
                                        <th>
                                            Address
                                        </th>
                                        <th>
                                            LatLng
                                        </th>
                                    </tr>
                                
                                    <?php
                                    while($row = mysqli_fetch_assoc($result)){
                                        ?>
                                        
                                        <tr>
                                            <td><a class='textlink' href="?edituser=<?php echo $row["userid"] ?>"><?php echo $row["userid"] ?></a></td>
                                            <td><?php echo $row["datereg"] ?></td>
                                            <td><?php echo $row["name"] ?></td>
                                            <td><?php echo $row["email"] ?></td>
                                            <td><?php echo $row["phone"] ?></td>
                                            <td><?php echo $row["address"] ?></td>
                                            <td><?php echo $row["latlng"] ?></td>
                                        </tr>
                                        
                                        <?php
                                    }
                                    
                                    ?>
                                    
                                </table>
                                <?php
                            }else{
                                echo "<p>Empty</p>";
                            }
                            
                            ?>
                        </div>
                        <div class="page" id="products">
                            <h1>Products</h1>
                            <?php
                            $sql = "SELECT * FROM $tableproducts ORDER BY id DESC";
                            $result = mysqli_query($connection, $sql);
                            if(mysqli_num_rows($result) > 0){
                                ?>
                                <table>
                                    <tr>
                                        <th>ProductID</th>
                                        <th>Title</th>
                                        <th>Price</th>
                                        <th>catid</th>
                                    </tr>
                                
                                <?php
                                while($row = mysqli_fetch_assoc($result)){
                                    ?>
                                    <tr>
                                        <td><a class='textlink' href="?editproduct=<?php echo $row["productid"] ?>"><?php echo $row["productid"] ?></a></td>
                                        <td><?php echo $row["title"] ?></td>
                                        <td><?php echo $row["price"] ?></td>
                                        <td><?php echo $row["catid"] ?></td>
                                    </tr>
                                    <?php
                                }
                                
                                ?>
                                </table>
                                <?php
                            }else{
                                echo "<p>Empty</p>";
                            }
                            ?>
                        </div>
                        <div class="page" id="categories">
                            
                            <h1>Add new Category</h1>
                            <form method="post">
                                <input name="category" placeholder="Category title">
                                <input id="faiconinput" name="faicon" value="fa-home" placeholder="FA-Icon" readonly>
                                <div id="falist" style="max-height: 256px; overflow: auto;"></div>
                                <input class="submitbutton" type="submit" value="Submit" name="submitnewcategory">
                            </form>
                            
                            <script>
                                for(var i = 0; i < falist.length; i++){
                                    $("#falist").append("<div class='faicon' onclick=applyicon('" +falist[i]+ "')><i class='fa "+falist[i]+"'></i></div>")
                                }
                                
                                function applyicon(icon){
                                    $("#faiconinput").val(icon)
                                }
                            </script>
                            
                            <h1>Categories</h1>
                            <?php
                            $sql = "SELECT * FROM $tablecategories ORDER BY category ASC";
                            $result = mysqli_query($connection, $sql);
                            if(mysqli_num_rows($result) > 0){
                                while($row = mysqli_fetch_assoc($result)){
                                    echo "<p><i class='fa ".$row["faicon"]."'></i> " . $row["category"] . " | <a class='highlight' href='?editcategory=" .$row["id"]. "'>edit</a> | <a class='highlight' href='?deletecategory=" .$row["id"]. "'>delete</a></p>";
                                }
                            }else{
                                echo "<p>Empty</p>";
                            }
                            ?>
                        </div>
                        
                        
                        <script>
                            function onlyshow(id){
                                $(".page").hide()
                                $("#" + id).show()
                            }
                            onlyshow("users")
                        </script>
                        <?php
                        
                    }
                }
            }else{
                ?>
                <h1>SuperAdmin Login</h1>
                <form method="post">
                    <input type="text" name="sausername">
                    <input type="password" name="sapassword">
                    <input class="submitbutton" type="submit" value="Login">
                </form>
                
                <?php
            }
            ?>
        </div>
    </body>
</html>