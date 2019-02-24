<?php
ini_set('user_agent', 'any');
ini_set('display_errors', 0);

session_start();
if(!isset($_SESSION['sUserId'])){
  sendResponse(-1, __LINE__, 'You must login to use this api');
}

$sUserId = $_SESSION['sUserId']; 

if(empty($_GET['fromAccount'])){ sendResponse(-1, __LINE__, 'From account is missing'); }
if(empty($_GET['toAccount'])){ sendResponse(-1, __LINE__, 'To account is missing'); }
if(empty($_GET['amount'])){ sendResponse(-1, __LINE__, 'Amount is missing'); }

$sFromAccount = $_GET['fromAccount'] ?? '';
if(strlen($sFromAccount) < 5){ sendResponse(-1, __LINE__, 'Message cannot be less than 2 characters in length'); }
if(strlen($sFromAccount) > 10){ sendResponse(-1, __LINE__, 'Message cannot be more than 30 characters in length'); }

$sToAccount = $_GET['toAccount'] ?? '';
if(strlen($sToAccount) < 5){ sendResponse(-1, __LINE__, 'Message cannot be less than 2 characters in length'); }
if(strlen($sToAccount) > 10){ sendResponse(-1, __LINE__, 'Message cannot be more than 30 characters in length'); }

$iAmount = $_GET['amount'] ?? '';
if(!is_numeric($iAmount)){ sendResponse(-1, __LINE__, 'Amount can only contain numbers'); }

$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );

if( $jData == null){ sendResponse(-1, __LINE__, 'Cannot convert data to JSON'); }

$jInnerData = $jData->data;
$jUser = $jInnerData->$sUserId;

$overallBalance = $jUser->totalBalance;
$overallBalanceName = $overallBalance->name;
$overallBalanceBalance = $overallBalance->balance;
$overallBalanceCurrency = $overallBalance->currency;

$allAccounts = $jUser->accounts;

$checkingAccount = $allAccounts->checkingAccount;
$checkingAccountName = $checkingAccount->accountName;
$checkingAccountBalance = $checkingAccount->accountBalance;
$checkingAccountCurrency = $checkingAccount->currency;

$debitAccount = $allAccounts->debitAccount;
$debitAccountName = $debitAccount->accountName;
$debitAccountBalance = $debitAccount->accountBalance;
$debitAccountCurrency = $debitAccount->currency;

$savingsAccount = $allAccounts->savingsAccount;
$savingsAccountName = $savingsAccount->accountName;
$savingsAccountBalance = $savingsAccount->accountBalance;
$savingsAccountCurrency = $savingsAccount->currency;

switch(strtolower($sFromAccount)){

  case $overallBalanceName:

    if($iAmount > $jInnerData->$sUserId->totalBalance->balance){
      sendResponse(-1, __LINE__, 'You dont have enough money in your account');
    }

    $jInnerData->$sUserId->totalBalance->balance -= $iAmount;

    if(strtolower($sToAccount) == $checkingAccountName){
      $jInnerData->$sUserId->accounts->checkingAccount->accountBalance += $iAmount / 7.47;
    }else if($sToAccount == $debitAccountName){
      $jInnerData->$sUserId->accounts->debitAccount->accountBalance += $iAmount;
    }else{
      $jInnerData->$sUserId->accounts->savingsAccount->accountBalance += $iAmount; 
    }

    $sData = json_encode($jData, JSON_PRETTY_PRINT);
    file_put_contents('../data/clients.json', $sData);

    break;

  case $checkingAccountName:
     
    if($iAmount > $jInnerData->$sUserId->accounts->checkingAccount->accountBalance){
      sendResponse(-1, __LINE__, 'You dont have enough money in your account');
    }

    $jInnerData->$sUserId->accounts->checkingAccount->accountBalance -= $iAmount / 7.47;

    if(strtolower($sToAccount) == $overallBalanceName){
      $jInnerData->$sUserId->totalBalance->balance += $iAmount;
    }else if($sToAccount == $debitAccountName){
      $jInnerData->$sUserId->accounts->debitAccount->accountBalance += $iAmount;
    }else{
      $jInnerData->$sUserId->accounts->savingsAccount->accountBalance += $iAmount; 
    }

    $sData = json_encode($jData, JSON_PRETTY_PRINT);
    file_put_contents('../data/clients.json', $sData);

    break;

  case $debitAccountName:

    if($iAmount > $jInnerData->$sUserId->accounts->debitAccount->accountBalance){
      sendResponse(-1, __LINE__, 'You dont have enough money in your account');
    }

    $jInnerData->$sUserId->accounts->debitAccount->accountBalance -= $iAmount;
    
    if(strtolower($sToAccount) == $overallBalanceName){
      $jInnerData->$sUserId->totalBalance->balance += $iAmount;
    }else if($sToAccount == $checkingAccountName){
      $jInnerData->$sUserId->accounts->checkingAccount->accountBalance += $iAmount / 7.47;
    }else{
      $jInnerData->$sUserId->accounts->savingsAccount->accountBalance += $iAmount; 
    }

    $sData = json_encode($jData, JSON_PRETTY_PRINT);
    file_put_contents('../data/clients.json', $sData);

    break;

  case $savingsAccountName:

    if($iAmount > $jInnerData->$sUserId->accounts->savingsAccount->accountBalance){
      sendResponse(-1, __LINE__, 'You dont have enough money in your account');
    }

    $jInnerData->$sUserId->accounts->savingsAccount->accountBalance -= $iAmount; 
    
    if(strtolower($sToAccount) == $overallBalanceName){
      $jInnerData->$sUserId->totalBalance->balance += $iAmount;
    }else if($sToAccount == $checkingAccountName){
      $jInnerData->$sUserId->accounts->checkingAccount->accountBalance += $iAmount / 7.47;
    }else{
      $jInnerData->$sUserId->accounts->debitAccount->accountBalance += $iAmount;
    }

    $sData = json_encode($jData, JSON_PRETTY_PRINT);
    file_put_contents('../data/clients.json', $sData);

    break;

  default:

    sendResponse( 0, __LINE__ , 'No account of that name could be found' );
 
}

sendResponse( 1, __LINE__ , 'Phone registered locally' );

function sendResponse($iStatus, $iLineNumber, $sMessage){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}

