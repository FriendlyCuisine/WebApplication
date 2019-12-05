<?php
include('configuration.php');
session_start();
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>Sent Messages - Friendly Cuisine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="Friendly Cuisine">


   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <?php include 'resources.php'; ?>


<style type="text/css">

/* The Modal (background) */
.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Stay in place */
  z-index: 1; /* Sit on top */
  left: 0;
  top: 0;
  width: 100%; /* Full width */
  height: 100%; /* Full height */
  overflow: auto; /* Enable scroll if needed */
  background-color: rgb(0,0,0); /* Fallback color */
  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content/Box */
.modal-content {
  background-color: #fefefe;
  margin: 15% auto; /* 15% from the top and centered */
  padding: 20px;
  border: 1px solid #888;
  width: 30%; /* Could be more or less, depending on screen size */
}

/* The Close Button */
.close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  padding-left: 100%;
}

.close:hover,
.close:focus {
  color: black;
  text-decoration: none;
  cursor: pointer;
}


</style>


</head>

<header>
    <?php include 'header.php'; ?>
</header>

<body>
    <h1>Sent Messages</h1>

              <div class="col-md-12">
              <div class="table-responsive">
              <table class="table table-bordered mg-b-0">
              <thead>
                <tr>
                  <th>#</th>
                  <th>To</th>
                  <th>Message</th>
                  <th>Date</th>
                  <th>Actions</th>
                </tr>
              </thead>
    
<tbody>
<?php 

$messageFrom = $_SESSION['username'];



$stmt=$conn->prepare("SELECT * FROM message WHERE messageFrom=? AND sent_status=1 ");
$stmt->execute([$messageFrom]);

$cnt=1;
while ($row=$stmt->fetchAll()) 
{
$_SESSION['messageID'] = $row->messageID;
?>
<tr>

<td><?php echo $cnt; ?></td>
<td><?php echo $row->messageTo; ?></td>
<td><?php echo $row->messageBody; ?></td>
<td><?php echo $row->messageDate; ?></td>
<td><button id="myBtn" style="width: 28%;padding: 4px 0px;margin: 0px 0;color: white;" >View</button>
  /<a href="reply2.php?action=reply_message&messageID=<?php echo $row->messageID;?>&messageFrom=<?php echo $row->messageFrom; ?>&messageTo=<?php echo $row->messageTo; ?>">Reply </a>
  /<a href="sent.php?action=delete_sent_message&messageID=<?php echo $row->messageID;?>">Delete </a></td>

</tr>

	
<?php
$cnt=$cnt+1;
}
?>
</tbody>
</table>
</div>
</div>




<?php 

if(isset($_REQUEST['action']) == "delete_sent_message")
  {
    
  $messageID = $_REQUEST['messageID'];
 

  $stmt=$conn->prepare("UPDATE message SET sent_status=0 WHERE messageID=?");
  $stmt->execute([$messageID]);

  header("location: sent.php");

} // end of if
?>





<div id="myModal" class="modal">

  <?php 
    
  $messageID = $_SESSION['messageID'];
 

  $stmt=$conn->prepare("SELECT * FROM message WHERE messageID=? AND sent_status=1 ");
  $stmt->execute([$messageID]);

  $stmt2=$conn->prepare("SELECT * FROM reply WHERE messageID=?");
  $stmt2->execute([$messageID]);


  unset($_SESSION['messageID']);
  ?>

  <!-- Modal content -->
  <div class="modal-content">
    <span class="close">&times;</span>
    <p style="color: green;">
    <?php
    while ($row=$stmt->fetchAll()) 
    {
    ?>
    <strong><?php echo $row->messageFrom ?></strong>:<?php echo $row->messageBody ?>&nbsp;&nbsp;&nbsp;<?php echo $row->messageDate ?><br/>
    
    <?php
    }
    ?>
    </p>
    <p style="color: black;">
    <?php
    while ($row2=$stmt->fetchAll()) 
    {
    ?>
    <strong><?php echo $row2->replyFrom ?></strong>:<?php echo $row2->replyBody ?>&nbsp;&nbsp;&nbsp;<?php echo $row2->replyDate ?><br/>
    <?php
    }
    ?>
    </p>
  </div>

</div>



<script type="text/javascript">


// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on the button, open the modal 
btn.onclick = function() {
  modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}


</script>


</body>