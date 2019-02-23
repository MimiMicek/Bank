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
$jAccounts = $jClient->accounts;
?>

  <div id="accounts" class="page">
    <h1>ACCOUNTS</h1>
    <br>
    <div><b> Checking account:</b> 
      <?= $jAccounts->checkingAccount->accountBalance; ?>
      <?= $jAccounts->checkingAccount->currency;?>
    </div>
    <br>
    <div><b> Debit account:</b> 
      <?= $jAccounts->debitAccount->accountBalance; ?> 
      <?= $jAccounts->debitAccount->currency;?>
    </div>
    <br>
    <div><b>Savings account: </b> 
      <?= $jAccounts->savingsAccount->accountBalance; ?>
      <?= $jAccounts->savingsAccount->currency;?> 
    </div>
    <br>
    <div><b> Current balance:</b> 
      <?= $jClient->totalBalance->balance; ?> 
      <?= $jClient->totalBalance->currency; ?>
    </div>
    <br>
    <br>
    <div id="transferBetweenAccounts">
    <h1>Transfer money</h1>
    <form id="frmTransferBetweenAccounts">
      <div class="row">
      <label for="txtTransferFromAccount">From account (Checking, Debit, Savings or Balance)</label>
        <input id="txtTransferFromAccount" placeholder="From account" type="text" minlength="5" maxlength="10" required> 
      </div>
      <div class="row">
      <label for="txtTransferToAccount">To account (Checking, Debit, Savings or Balance)</label>
        <input id="txtTransferToAccount" placeholder="To account" type="text" minlength="5" maxlength="10" required>
      </div>
      <div class="row">
      <label for="txtTransferAmount">Transfer amount</label>
        <input id="txtTransferAmount" placeholder="Amount" type="number" min="1" max="10000000000" required>
      </div>
      <button>Transfer</button>
      </form>
    </div>
  </div>
  
    

<?php 
$sLinkToScript = '<script src="js/profile.js"></script>';
require_once 'bottom.php'; 
?>
<script>
   $('#accounts').show()
   $('#transferBetweenAccounts').show()
</script>