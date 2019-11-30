<?php
session_start();
include 'controller.php';
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
    <title>Create Message - Friendly Cuisine</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="keywords" content="Friendly Cuisine">
    <?php include 'resources.php'; ?>
</head>

<header>
    <?php include 'header.php'; ?>
</header>

<body>
    <h1>Create Message</h1>
    
<!--    <img src="img/default-profile-pic.png">-->
    <!--<img id="profileImage" src="img/default-profile-pic.png">-->


<div>
<?php
if(isset($_SESSION['message2'])!='')
{
?> 
<span style="color: red"><?php echo $_SESSION['message2'];?></span>
<?php
unset($_SESSION['message2']);
}
?>
</div>
<form method="post">
<input type="hidden" name="messageFrom" value="<?php echo $_SESSION['username'] ?>">
<input type="text" name="messageTo" placeholder="Enter Username of a Person to which you want to send a message" required="">
<input type="text" name="messageBody" placeholder="Enter Message" required="">
<input type="submit" name="send_msg" value="Send">
</form>



<!--<h1 align='center'><a href='mail.php'><button><h1 align='center'><b><i>Create Messege</i></b></h1></button></a></h1><br>
<h1 align='center'><a href='inbox1.php'><button><h1 align='center'><b><i>Inbox</i></b></h1></button></a></h1><br>
<h1 align='center'><a href='sent.php'><button><h1 align='center'><b><i>Sentbox</i></b></h1></button></a></h1>
<br><br>-->

</body>