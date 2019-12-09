<?php
include('configuration.php');
session_start();

if (empty($_SESSION['userID'])){
    header('Location:index.php');
}


function imageUploader($file){

    $target_dir = "./img/"; // change do your upload dir
    $target_file = $target_dir . basename($file["image"]["name"]);
    $post_tmp_img = $file["image"]["tmp_name"];

    $imageData = getimagesize($post_tmp_img);

    if ($imageData){

        $mimeType = $imageData['mime'];

        $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($mimeType, $allowedMimeTypes))
        {
            if(move_uploaded_file($post_tmp_img,$target_file)){
                return $target_file;
            }else{
                return array('error'=>"Could Not Upload Image, Check upload dir permissions");
            }

        }else{
            return array('error'=>"Only JPEG, PNG and GIFs are allowed");
        }

    }else{
        return array('error'=>"Invalid image");
    }

}


$notify="";

if(!empty($_REQUEST['eventName']) && !empty($_REQUEST['description'])){

    $created_by=!empty($_SESSION['userID']) ? $_SESSION['userID'] : 0;

    $eventName=trim($_REQUEST['eventName']);
    $description=trim($_REQUEST['description']);
    $eventDate=trim($_REQUEST['eventDate']);
    $eventLocation=trim($_REQUEST['eventLocation']);
    $eventImage="";

    if(empty($_REQUEST['edit'])) {

        if (!empty($_FILES["image"]["tmp_name"])) {
            $image = imageUploader($_FILES);
        }

        if (gettype($image) == "string") {

            $stmt = $conn->prepare('INSERT INTO event (eventName, eventDesc, eventDate,eventLocation,eventImage,userID)
                                                    VALUES (:eventName, :eventDesc, :eventDate,:eventLocation,:eventImage,:userID)');

            $result = $stmt->execute([
                'eventName' => $eventName,
                'eventDesc' => $description,
                'eventDate' => $eventDate,
                'eventLocation' => $eventLocation,
                'eventImage' => $image,
                'userID'=>$created_by
            ]);

            if ($result) {
                $notify = "Event Created";
            } else {
                $notify = "Event Not Created,";
            }

        }else{
            $notify = $image['error'];
        }

    }else{

        if(!empty($eventImage)){
            $eventImage="";
        }

        $id=trim($_REQUEST['edit']);

        if (empty($_FILES["image"]["tmp_name"])) {
            $eventImage = trim($_REQUEST['edit_image']);
        } else {
            $eventImage = imageUploader($_FILES);
        }

        if (empty($eventImage) || gettype($eventImage) == "string") {
            $stmt = $conn->prepare('UPDATE `event` SET `eventName`=:eventName,`eventDesc`=:eventDesc,`eventDate`=:eventDate,`eventLocation`=:eventLocation,`eventImage`=:eventImage WHERE eventID=:id');

            $result = $stmt->execute([
                'eventName' => $eventName,
                'eventDesc' => $description,
                'eventDate' => $eventDate,
                'eventLocation' => $eventLocation,
                'eventImage' => $eventImage,
                'id' => $id
            ]);

            if ($result) {
                $notify = "Event Updated";
            } else {
               echo json_encode($stmt->errorInfo()); exit;
                $notify = "Event Not Updated," . $stmt->errorInfo();
            }

        } else {
            $notify = "Event Not Edited";
        }

    }

}


if(!empty($_REQUEST['delete'])){
    $messageID=$_REQUEST['delete'];

    $stmt = $conn->prepare("DELETE FROM event WHERE eventID=? ");
    if($stmt->execute([$_REQUEST['delete']])){
        $notify="Message deleted";
    }else{
        $notify="Message not deleted,".$stmt->errorInfo();
    }

}

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>Events - Friendly Cuisine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="Friendly Cuisine">
    <?php include 'resources.php'; ?>
    <link rel="stylesheet" href="css/inbox.css"/>
</head>
<?php if($_SESSION['loggedin'] == true) { ?>
<body>
<header><?php include 'header.php'; ?></header>

<div class="inbox-wrapper">
    <div class="inbox-header">
        <h1>Events</h1>
        <?php
        if(!empty($notify)) {
            ?>
            <div class="alert">
                <?php echo $notify;?>
            </div>
            <?php
        }
        ?>
        <br/>
        <div class="top-action-btn">
            <button class="new-message buttons" id="myBtn">Create Event</button>
        </div>

        <div class="top-action-btn pull-right">
            <form action="events.php" method="get">
                <input type="search" class="form-control" name="search" style="height: 50px;width: 250px;" value="<?php echo !empty($_REQUEST['search']) ? trim($_REQUEST['search']): '';?>" placeholder="Enter search and press enter"/>
            </form>
        </div>
        <hr style="clear: both;"/><br/>
    </div>
    <div class="table-responsive">
        <table class="table-inbox">
            <thead>
            <tr>
                <th>#</th>
                <th>Event Name</th>
                <th>Event Description</th>
                <th>Event Date</th>
                <th>Event Location</th>
                <th>Event Image</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>

            <?php

                $created_by = !empty($_SESSION['userID']) ? $_SESSION['userID'] : 0;

                $sql="SELECT * FROM event";

                if (!empty($_REQUEST['search'])) {
                    $search=trim($_REQUEST['search']);
                    $sql .= " AND eventName LIKE '%$search%' OR eventLocation LIKE '%$search%' OR eventDate LIKE '%$search%' ";
                }

                $sql .= " ORDER BY eventID DESC";

                $stmt = $conn->prepare($sql);
                $param=$created_by;

            if($stmt->execute([$param])){ $i=1;

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    ?>

                    <tr>
                        <td><?php echo $i++?></td>
                        <td>
                            <?php echo$row['eventName'];?>
                        </td>
                        <td>
                            <?php echo $row['eventDesc'];?>
                        </td>
                        <td>
                            <?php echo $row['eventDate'];?>
                        </td>
                        <td>
                            <?php echo $row['eventLocation'];?>
                        </td>
                        <td>
                            <img style="width:100px;height:100px;" src="<?php echo $row['eventImage'];?>" alt="<?php echo$row['eventName'];?>"/>
                        </td>
                        <td>
                          <?php if($_SESSION['userID'] == $row['userID']) { ?> <a class="buttons edit-button" href="#<?php echo $row['eventID'];?>" onclick="return document.getElementById('editModal<?php echo $row['eventID'];?>').style.display='block';">Edit</a> <?php } ?>

                            <!-- The Modal -->
                            <div id="editModal<?php echo $row['eventID'];?>" class="modal">

                                <!-- Modal content -->
                                <div class="modal-content">
                                    <span class="close">&times;</span>
                                    <br/>
                                    <form class="form-compose" id="form-compose" action="events.php?edit=<?php echo $row['eventID'];?>" method="POST" enctype="multipart/form-data">
                                        <div>
                                            <label for="eventName"><strong>Enter Event Name</strong></label>
                                            <input type="text" name="eventName" class="input-style" id="eventName" value="<?php echo $row['eventName'];?>" placeholder="Event Name...." required/>
                                            <span id="eventName"></span>
                                        </div>
                                        <br/>
                                        <div>
                                            <label for="description"><strong>Write Event Description</strong></label>
                                            <textarea name="description" class="input-style" id="description" placeholder="Event Description.." required><?php echo $row['eventDesc'];?></textarea>
                                        </div>
                                        <br/>
                                        <div>
                                            <label for="eventDate"><strong>Enter Event Date</strong></label>
                                            <input type="date" name="eventDate" class="input-style" id="eventDate" value="<?php echo $row['eventDate'];?>" placeholder="Event Date...." required/>
                                            <span id="date"></span>
                                        </div>
                                        <br/>
                                        <div>
                                            <label for="location"><strong>Enter Event Location</strong></label>
                                            <input type="text" name="eventLocation" class="input-style" id="eventLocation" value="<?php echo  $row['eventLocation'];?>" placeholder="Event Event Location...." required/>
                                            <span id="location"></span>
                                        </div>
                                        <div>
                                            <label for="image"><strong>Upload Image</strong></label>
                                            <input type="file" name="image" class="input-style" id="image"/>
                                            <span id="image"></span>

                                            <?php
                                            if(!empty($row['eventImage'])) {
                                                ?>
                                                <input type="hidden" name="edit_image" value="<?php echo $row['eventImage'];?>"/>
                                                <img class="img-show mx-auto" src="<?php echo $row['eventImage'] ?>" style="width:100%"/>
                                                <?php
                                            }
                                            ?>

                                        </div>
                                        <div>
                                            <br/>
                                            <button type="submit" class="send-message buttons">Save</button>
                                        </div>
                                    </form>
                                </div>

                            </div>

                            <?php if($_SESSION['userID'] == $row['userID']) { ?> <a class="buttons delete-button" href="events.php?delete=<?php echo $row['eventID'];?>" onclick="return confirm('Are you sure to delete?');">Delete</a> <?php } ?>
                        </td>
                    </tr>

                    <?php
                }
            }
            ?>
            </tbody>
        </table>
    </div>

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <span class="close">&times;</span>
            <br/>
            <form class="form-compose" id="form-compose" action="events.php" method="post" enctype="multipart/form-data">
                <div>
                    <label for="eventName"><strong>Enter Event Name</strong></label>
                    <input type="text" name="eventName" class="input-style" id="eventName" placeholder="Event Name...." required/>
                    <span id="eventName"></span>
                </div>
                <br/>
                <div>
                    <label for="description"><strong>Write Event Description</strong></label>
                    <textarea name="description" class="input-style" id="description" placeholder="Event Description.." required></textarea>
                </div>
                <br/>
                <div>
                    <label for="eventDate"><strong>Enter Event Date</strong></label>
                    <input type="date" name="eventDate" class="input-style" id="eventDate" placeholder="Event Date...." required/>
                    <span id="date"></span>
                </div>
                <br/>
                <div>
                    <label for="location"><strong>Enter Event Location</strong></label>
                    <input type="text" name="eventLocation" class="input-style" id="eventLocation" placeholder="Event Event Location...." required/>
                    <span id="location"></span>
                </div>
                <div>
                    <label for="image"><strong>Upload Image</strong></label>
                    <input type="file" name="image" class="input-style" id="image" required/>
                    <span id="image"></span>
                </div>
                <div>
                    <br/>
                    <button type="submit" class="send-message buttons">Save</button>
                </div>
            </form>
        </div>

    </div>

</div>
<script src="js/inbox.js"></script>
</body>
<?php } else {
  header("location: index.php");
} ?>
</html>
