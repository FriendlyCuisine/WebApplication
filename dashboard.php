<?php
session_start();
include 'controller.php';
include 'session.php';
?>
<!DOCTYPE HTML>
<html lang="en">

<head>
	<title>Dashboard - Friendly Cuisine</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="keywords" content="Friendly Cuisine">
	<?php include 'resources.php'; ?>
</head>

<header>
	<?php include 'header.php'; ?>
</header>

<body>
	<h1>Dashboard</h1>
	<div class="column">

		<div class="contentBody">
			<h2>Share Post</h2>
			<div class="container">
				<form method="post" action="post.php">
					<textarea name="postContent" placeholder="Share your story..." rows="10" cols="55"></textarea>
					<br>
					<hr>
					<button class=""><i class=""></i> Share </button>
				</form>

			</div>
		</div>
		<br><br>

		<div class="contentBody">
			<h2>Feeds</h2>
			<div class="container">


				<?php
                $query = $conn->query(
                    "SELECT 
                        * 
                    FROM 
                        post 
                    LEFT JOIN 
                        user 
                    ON 
                        user.userID = post.userID 
                    ORDER BY
                        postID DESC"
                );
                while($row = $query->fetch()){
                    $postedBy = $row['userFirstName']." ".$row['userLastName'];
                    $postedImage = $row['userProfileImage'];
                    $id = $row['postID'];
                    
            ?>
				<div class="">
					<a><img src="<?php echo $postedImage; ?>" style="width:50px;height:50px" class="img-circle"></a>
				</div>
				<div class="">
					<div class="alert"><?php echo $row['postContent']; ?></div>
					<div class="row">
						<div class="col-xs-9">
							<h4><span class="label label-info"> <?php echo $row['postDatePosted']; ?></span></h4>
							<h4>
								<small class="text-muted">Posted By: <a href="" class="text-muted"><?php echo $postedBy; ?></a></small>
							</h4>
						</div>
						<!--
                    <div class="col-xs-3"><a href="postDelete.php<?php echo '?id='.$userID; ?>" class="btn btn-danger"><i class="icon-trash"></i> Delete</a>
                    </div>
-->

					</div>
					<br><br>
				</div>
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="column">
		<div class="contentBody">
			<h2>Photos</h2>
			<div class="container">
				<form id="photos" method="POST" enctype="multipart/form-data">
					<label class="" for="input01"></label>
					<input type="file" name="userProfileImage" class="font" required>
					<br><br>
					<button type="submit" name="submit" class="btn btn-success"><i class="icon-upload"></i> Upload</button>
				</form>
			</div>
			<br><br>
			<div class="container">
				<div class="">
					<?php 
                    if (isset($_POST['submit'])) {
						$image = addslashes(file_get_contents($_FILES['userProfileImage']['tmp_name']));
						$image_name = addslashes($_FILES['userProfileImage']['name']);
						$image_size = getimagesize($_FILES['userProfileImage']['tmp_name']);
						move_uploaded_file($_FILES["userProfileImage"]["tmp_name"], "upload/" . $_FILES["userProfileImage"]["name"]);
						$location = "upload/" . $_FILES["userProfileImage"]["name"];
						$conn->query(
							"INSERT INTO
								image (imageLocation) 
							VALUES 
								('$location')"
						);
					}
                ?>
				</div>
				<div class="">
					<?php
                $query = $conn->query(
                    "SELECT 
                        * 
                    FROM 
                        image");
                while($row = $query->fetch()){
                $id = $row['imageID'];
            ?>
					<div class="">
						<a href="<?php echo $row['imageLocation']; ?>"><img class="" src="<?php echo $row['imageLocation']; ?>"></a><br>
						<a class="" href="imageDelete.php<?php echo '?id='.$id; ?>"> Delete</a>
						<br>
						<br>
						<hr>
					</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>

</body>

</html>
