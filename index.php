<?php require_once 'top.php';?>

  <div id="logo" class="page"> 
    <h1>WELCOME TO ERCEG BANK</h1>
  </div>

 
  <div id="signup" name="signup" class="page"> 
    <h1>SIGN UP</h1>
    <form id="frmSignup" method="POST">
      <div class="row" >
        <input name="txtSignupPhone" type="tel" placeholder="phone" maxlength="8" value="" required>
      </div>
      <div>
        <input name="txtSignupName" type="text" placeholder="name" value="Lala" minlength="2" maxlength="20" required>
      </div>
      <div class="row">
        <input name="txtSignupLastName" type="text" placeholder="last name" value="Lalic" minlength="2" maxlength="20" required>
      </div>
      <div class="row">
        <input name="txtSignupEmail" type="email" placeholder="email" value="a@a.com" required>
      </div>
      <div class="row">
        <input name="txtSignupCpr" type="text" placeholder="cpr" value="1234567891" minlength="10" maxlength="10" required>
      </div>
      <div class="row">
        <input name="txtSignupPassword" type="password" placeholder="password" value="1234"  minlength="4" maxlength="20" required>
      </div>
      <div class="row">
        <input name="txtSignupConfirmPassword" type="password" placeholder="confirm password" value="1234"  minlength="4" maxlength="20" required>
      </div>
      <div class="row">
        <button>Signup</button>
      </div>
    </form>
    </div>

  
  </body>
</html>

  <?php require_once 'bottom.php';?>