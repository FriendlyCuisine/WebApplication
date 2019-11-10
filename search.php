<?php
session_start();
include 'controller.php';
?>
<!DOCTYPE HTML>
<html lang="en">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<head>
    <title>Search - Friendly Cuisine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="Friendly Cuisine">
    <?php include 'resources.php'; ?>
</head>

<header>
    <?php 
        include 'header.php'; 
    ?>
</header>

<body>
    <!--    <h1><?php echo $_SESSION['firstName']." ".$_SESSION['lastName'];?></h1>-->
    <h1>Friends</h1>

    <div class="contentBody">
        <div class="container">
            <?php
                $query = $conn->query(
                    "SELECT 
                        * 
                    FROM 
                        user 
                    WHERE 
                        userFirstName 
                    LIKE 
                        '%$search%'
                    OR 
                        userLastName
                    LIKE 
                        '%$search%'"
                );
                $count = $query->rowcount();
                    if ($count > 0) { 
                        while($row = $query->fetch()) {
                            $posted_by = $row['userFirstName']." ".$row['userLastName'];
                            $posted_image = $row['userProfileImage'];
                            $friendID = $row['userID'];
            ?>
            <div>
                <img src="<?php echo $posted_image; ?>" style="width:50px; height:50px" class="img-circle">
            </div>
            <div>
                <div class="alert"><?php echo $posted_by; ?></div>
                <div class="row">
                    <div>
                        <form method="post" action="friendAdd.php">
                            <div>
                                <input type="hidden" name="myFriendID" value="<?php echo $friendID; ?>">
                                <?php 
                                    $query1 = $conn->query(
                                        "SELECT 
                                            * 
                                        FROM 
                                            friend 
                                        WHERE 
                                            myFriendID = '$friendID'"
                                    );
                                    $count1 = $query1->rowcount();
                                    if ($count1 > 0) { 
                                        echo 'Aleady Friend'; 
                                    } else {
                                        ?>
                                <button class="btn btn-info"><i class="icon-plus-sign"></i> Add as Friend</button>
                                <?php } ?>
                            </div>

                        </form>
                    </div>
                    <br><br>
                </div>
                <?php } } else { ?> &nbsp;&nbsp;&nbsp;&nbsp; No Result Found. <?php } ?>
            </div>
            <hr>
            <br><br>
        </div>



</body>

</html>
