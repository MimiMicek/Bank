<?php
require_once 'top.php';

ini_set('display_errors', 0);

$sPhone = $_GET['phone'];
$sActivationKey = $_GET['activation-key'];

?>

  <div id="setNewPassword" class="page">
    <div>
      <h3>Set new password</h3>
      <form id="frmSetNewPassword">
        <input id="phone" name="phone" value="<?=$sPhone?>" type="text" minlength="4" maxlength="20" required>
        <input id="activation-key" name="activation-key" value="<?=$sActivationKey?>"  type="text"  minlength="4" maxlength="20" required>
        <input id="txtNewPassword" name="txtNewPassword" placeholder="new password" type="text" minlength="4" maxlength="20" required>
        <input id="txtConfirmNewPassword" name="txtConfirmNewPassword" placeholder="confirm new password" type="text"  minlength="4" maxlength="20" required>
        <button>Submit</button>
      </form>
    </div>
    
 
<?php 
require_once 'bottom.php'; 
?>
<script>
   $('#setNewPassword').show()
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="js/set-new-password.js"></script>