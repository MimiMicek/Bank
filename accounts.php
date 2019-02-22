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
    <div>Checking account: <?= $jAccounts->checkingAccount; ?></div>
    <div>Debit account: <?= $jAccounts->debitAccount; ?> </div>
    <div>Savings account: <?= $jAccounts->savingsAccount; ?> </div>
    <div>Current balance: <?= $jClient->totalBalance; ?> </div>
  </div>


<?php 
$sLinkToScript = '<script src="js/profile.js"></script>';
require_once 'bottom.php'; 
?>
<script>
   $('#accounts').show()
</script>