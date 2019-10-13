<div id="signup" class="signup-window">
  <div>
    <a href="" title="Close" class="signup-close">close &times;</a>
    <h1>Create an account</h1>
    <form class="form" action="" method="post" enctype="multipart/form-data" autocomplete="off">
      <div><?php echo $_SESSION['message'] ?></div>
      <input type="text" placeholder="Username" name="username" minlength="1" maxlength="14" required /><br>
      <input type="email" placeholder="Email" name="email" maxlength="45" required /><br>
      <input type="password" placeholder="Password" name="password" autocomplete="new-password" minlength="8" maxlength="25" required /><br>
      <input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" minlength="8" maxlength="25" required />
      <br>
      <br>
      <input type="submit" value="Join Now!" name="signUp" onclick="return val();" />
    </form>
  </div>
</div>
