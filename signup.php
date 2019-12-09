<div id="signup" class="signup-window">
  <div>
    <a href="" title="Close" class="signup-close">close &times;</a>
    <h1>Create Account</h1>
    <form class="form" action="" method="post" enctype="multipart/form-data" autocomplete="off">
      <div><?php echo $_SESSION['message'] ?></div>
      <input type="text" id="signupInput" placeholder="First Name" name="firstName" minlength="1" maxlength="15" required /><br>
      <input type="text" id="signupInput" placeholder="Last Name" name="lastName" minlength="1" maxlength="15" required /><br>
      <input type="text" id="signupInput"placeholder="Username" name="username" minlength="1" maxlength="14" required /><br>
      <input type="email" id="signupInput" placeholder="Email" name="email" maxlength="45" required /><br>
      <input type="password" id="signupInput" placeholder="Password" name="password" autocomplete="new-password" minlength="8" maxlength="25" required /><br>
      <input type="password" id="signupInput" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" minlength="8" maxlength="25" required />
      <br>
      <br>
      <input type="submit" id="signupBtn" value="Join Now!" name="signUp" onclick="return val();" />
    </form>
  </div>
</div>
