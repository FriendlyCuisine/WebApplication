<div id="login" class="login-window">
  <div>
    <a href="" title="Close" class="login-close">close &times;</a>
    <h1>Login</h1>
    <form action="" method="post">
      <div><?php echo $_SESSION['message'] ?></div>
      <input type="text" id="loginInput" placeholder="Username" name="username"/>
      <input type="password" id="loginInput" placeholder="Password" name="password"/>
      <br/>
      <br/>
      <input name="logIn" id="loginBtn" type="submit" value="Login"/><br/>
    </form>
  </div>
</div>
