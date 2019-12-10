<?php
include('configuration.php');
session_start();

if (empty($_SESSION['userID'])){
    header('Location:index.php');
}

$type = !empty($_REQUEST['type']) ? $_REQUEST['type'] : 'inbox';
$notify="";

if(!empty($_REQUEST['username']) && !empty($_REQUEST['message'])){

    $sent_by=!empty($_SESSION['userID']) ? $_SESSION['userID'] : 0;
    $sent_to="";
    $message=trim($_REQUEST['message']);
    $date_sent=date('Y-m-d h:i:s');
    $date_received=date('Y-m-d h:i:s');

    $stmt = $conn->prepare("SELECT * FROM user WHERE userUsername=? ");
    $stmt->execute([$_REQUEST['username']]);

    if($stmt->rowCount() > 0){
        $sent_to=$stmt->fetch()['userID'];
    }

    $stmt = $conn->prepare('INSERT INTO message (messageSenderID, messageRecieverID, messageContent,messageDateSended,messageDateRecieved) 
                                                    VALUES (:sent_by, :sent_to, :message,:date_sent,:date_received)');

    $result=$stmt->execute([
        'sent_by' => $sent_by,
        'sent_to' => $sent_to,
        'message' => $message,
        'date_sent' => $date_sent,
        'date_received'=>$date_received
    ]);

    if($result){
        $notify="Message sent";
    }else{
        $notify="Message Not sent,".$stmt->errorInfo();
    }

}


if(!empty($_REQUEST['delete'])){
    $messageID=$_REQUEST['delete'];

    $stmt = $conn->prepare("DELETE FROM message WHERE messageID=? ");
    if($stmt->execute([$_REQUEST['delete']])){
        $notify="Message deleted";
    }else{
        $notify="Message not deleted,".$stmt->errorInfo();
    }

}


function getUsername($userID,$conn){
    $stmt = $conn->prepare("SELECT * FROM user WHERE userID=? ");
    $stmt->execute([$userID]);

    if($stmt->rowCount() > 0){
        return  $stmt->fetch()['userUsername'];
    }else{
        return "";
    }
}

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
    <title>My Messages - Friendly Cuisine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="keywords" content="Friendly Cuisine">
    <?php include 'resources.php'; ?>
    <link rel="stylesheet" href="css/inbox.css"/>
</head>
<body>
<header> <?php include 'header.php'; ?></header>

<div class="inbox-wrapper">
    <div class="inbox-header">
        <h1>My Messages: <u><?php echo ucfirst($type);?></u></h1>
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
            <button class="new-message buttons" id="myBtn">Compose Message</button>
            <?php
            if(strtolower(trim($type))=='inbox') {
            ?>
                <a href="message.php?type=outbox" class="sent-messages buttons">View Outbox Messages</a>
            <?php
            }else {
            ?>
                <a href="message.php?type=inbox" class="sent-messages buttons">View Inbox Messages</a>
            <?php
            }
            ?>
        </div>
        <hr/>
    </div>
    <div class="table-responsive">
        <table class="table-inbox">
            <thead>
                <tr>
                    <th>#</th>
                    <th> <?php echo (strtolower(trim($type))=='inbox') ? 'Received From' : 'Sent To';?></th>
                    <th>Message</th>
                    <th>Date <?php echo (strtolower(trim($type))=='inbox') ? 'Received' : 'Sent';?></th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            <?php

            if(strtolower(trim($type))=='inbox') {
                $sent_to = !empty($_SESSION['userID']) ? $_SESSION['userID'] : 0;

                $stmt = $conn->prepare("SELECT * FROM message WHERE messageRecieverID=? ORDER BY messageID DESC");
                $param=$sent_to;
            }else{
                $sent_by = !empty($_SESSION['userID']) ? $_SESSION['userID'] : 0;

                $stmt = $conn->prepare("SELECT * FROM message WHERE messageSenderID=? ORDER BY messageID DESC");
                $param=$sent_by;
            }

            if($stmt->execute([$param])){ $i=1;

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>

                <tr>
                    <td><?php echo $i++?></td>
                    <td>
                        <span class="badge badge-pill badge-success">
                            <?php $username = strtolower(trim($type))=='inbox' ? getUsername($row['messageSenderID'],$conn) : getUsername($row['messageRecieverID'],$conn);
								echo $username;
							?>
                        </span>
                    </td>
                    <td><?php echo $row['messageContent'];?></td>
                    <td><?php echo strtolower(trim($type))=='inbox' ? $row['messageDateSended'] : $row['messageDateRecieved'];?></td>
                    <td>
						<?php
						if(strtolower(trim($type))=='inbox'){
						?>
		<button class="buttons reply-button myBtnReply" onClick="replyButton(this,'<?php echo $username;?>','<?php echo $row['messageID'];?>','<?php echo $row['messageContent'];?>')">Reply</button>
						<?php
						}
						?>
                        <a class="buttons delete-button" href="message.php?delete=<?php echo $row['messageID'];?>" onclick="return confirm('Are you sure to delete?');">Delete</a>
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
            <form class="form-compose"id="form-compose" action="message.php" method="post">
				<div>
					<h3 id="reply_header"></h3>
				</div>
                <div id="username_container">
                    <label for="username"><strong>Enter Username</strong></label>
                    <input type="text" name="username" class="username" id="username" placeholder="Username.." required/>
                    <span id="usernameError"></span>
                </div>
                <br/>
                <div>
                    <label for="message"><strong>Write Message</strong></label>
                    <textarea name="message" class="message" id="message" placeholder="Message.." required></textarea>
                </div>
                <div>
                    <br/>
                    <button type="button" class="send-message buttons" onclick="verifyUsername(this)">Send Message</button>
                </div>
            </form>
        </div>

    </div>

</div>
<script src="js/inbox.js"></script>
</body>
</html>
