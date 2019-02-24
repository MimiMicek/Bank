<?php
require_once 'top.php';

session_start();

if(!isset($_SESSION['sUserId'])){
  header('Location: login');
}

$sUserId = $_SESSION['sUserId'];

$sData = file_get_contents('data/clients.json');
$jData = json_decode($sData);
if($jData == null){ echo 'System update'; }
$jInnerData = $jData->data;
$jClient = $jInnerData->$sUserId;
?>

  <div id="profile" class="page">
    <div class="row">
      <a href="admin">Admin page</a>    
    </div>
    <h1>PROFILE</h1>
    <br>
    <br>
    <div><b>Name:</b> <?= $jClient->name; ?></div>
    <div><b>Last Name:</b> <?= $jClient->lastName; ?> </div>
    <div><b>Email:</b> <?= $jClient->email; ?> </div>
    <div><b>Phone:</b> <?= $sUserId; ?> </div>
    <div><b>Balance:</b> 
      <span id="lblBalance">
        <?= $jClient->totalBalance->balance; ?>
        <?= $jClient->totalBalance->currency; ?>
      </span>
    </div>
    <br>
    <br>
    <div>
      <h3>Change password</h3>
      <form id="frmChangePassword">
        <input id="txtOldPassword" name="txtOldPassword" placeholder="old password" type="text" >
        <input id="txtNewPassword" name="txtNewPassword" placeholder="new password" type="text" minlength="4" maxlength="20" required>
        <input id="txtConfirmNewPassword" name="txtConfirmNewPassword" placeholder="confirm new password" type="text"  minlength="4" maxlength="20" required>
        <button>Submit</button>
      </form>
    </div>
    <br>
    <br>
    <h1>Transfer money</h1>
    <form id="frmTransfer">
      <div class="row">
        <input id="txtTransferToPhone" placeholder="Enter telephone" type="tel" minlength="8" maxlength="8" required> 
      </div>
      <div class="row">
        <input id="txtTransferAmount" placeholder="Enter amount" type="number" min="1" max="10000000000" required>
      </div>
      <div class="row">
        <input id="txtTransferMessage" placeholder="Enter message" type="tel" minlength="2" maxlength="30" required>
      </div>
      <button>Transfer</button>
    </form>
    <br>
    <br>
    <h1>Transactions</h1>
    <table>
      <thead>
        <tr>
          <td>ID</td>
          <td>DATE</td>
          <td>AMOUNT</td>
          <td>NAME</td>
          <td>LAST NAME</td>
          <td>PHONE</td>
          <td>MESSAGE</td>
        </tr>
      </thead>
      <tbody id="lblTransactions">
  <?php
  foreach($jClient->transactions as $sTransactionId => $jTransaction){
    echo "
      <tr>
        <td>$sTransactionId</td>
        <td>$jTransaction->date</td>
        <td>$jTransaction->amount</td>
        <td>$jTransaction->name</td>
        <td>$jTransaction->lastName</td>
        <td>$jTransaction->fromPhone</td>
        <td>$jTransaction->message</td>
      </tr>
    ";
  }   

  ?>
  </div>
 
<?php 
$sLinkToScript = '<script src="js/profile.js"></script>';
require_once 'bottom.php'; 
?>
<script>
   $('#profile').show()
</script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="js/profile.js"></script>
<script src="js/transfer-money.js"></script>
<script src="js/change-password.js"></script>