<?php
require_once 'top.php';?>

<div id="forgotPassword" class="page">    
    <h1>FORGOT PASSWORD</h1>
    <h4>Please write your telephone so you can set up a new password!</h4>
    <br>
    <form id="frmForgotPassword">
      <div class="row" >
        <input id="txtForgotPasswordPhone" name="txtForgotPasswordPhone" type="tel" placeholder="phone" maxlength="8" value="22222222" required>
      </div>
      <button>Send activation link</button>
      </div>
    </form>
  </div> 
   
 <?php 
 
  require_once 'bottom.php'; 
  ?>
  <script>
   $('#forgotPassword').show()
</script>
<script src="js/forgot-password.js"></script>