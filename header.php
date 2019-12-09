<div class="navbar">
  <?php
  if(isset($_SESSION['loggedin'])) {
  ?>
  <div class="dropdown">
    <button class="dropbtn">
      <?php echo '<img style="float:left;width: 20px; height: 20px;margin-right: 8px;" src="'.$_SESSION['profileImage'].'">' ?>
      <div style="float:left;vertical-align: text-bottom;"><?php echo $_SESSION['username'];?></div>
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <div class="dropdown-sec-1">
      <?php echo '<img style="height: 70px; width: 70px;border-radius:35px;" src="'.$_SESSION['profileImage'].'">' ?>
      <br>
      <?php echo $_SESSION['firstName']." ".$_SESSION['lastName']."<br>"."@".$_SESSION['username'];?>
      <br>
      <div style="float:left;">
        <hr id="userDropdownHr">
      </div>
    </div>
      <a href="profile.php?id=<?php echo $_SESSION['userID']; ?>">My Profile</a>
      <a href="settings.php">Settings</a>
      <a href="logout.php">Log out</a>
    </div>
  </div>
  <a href="events.php">Events</a>
  <a href="food.php">Food/Drink</a>
  <a href="dashboard.php">Dashboard</a>
  <a href="profile.php?id=<?php echo $_SESSION['userID']; ?>">Profile</a>
  <a href="index.php">Home</a>
  <?php
}else {
  ?>
  <a href="#login">Login</a>
  <a href="#signup">Signup</a>
  <?php
}
?>
<img class="smallLogo" src= "img/logo-small.png">
</div>
