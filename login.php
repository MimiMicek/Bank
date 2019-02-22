<?php
require_once 'top.php';?>

<div id="login" class="page">    
    <h1>LOG IN</h1>
    <h4>Please Log in first to be able to see your Profile and your Accounts!</h4>
    <br>
    <form id="frmLogin" method="POST">
      <div class="row" >
        <input name="txtLoginPhone" type="tel" placeholder="phone" maxlength="8" value="22222222" required>
      </div>
      <div class="row">
        <input name="txtLoginPassword" type="password" placeholder="password" value="1234" required>
      </div>
      <br>
      <div class="row">
        <a href="forgot-password">Forgot password</a>
      </div>
      <br>
      <button>Login</button>
      </div>
    </form>
  </div> 
   
 <?php 
  $sLinkToScript = '<script src="js/login.js"></script>';
  require_once 'bottom.php'; 
  ?>
  <script>
   $('#login').show()
</script>