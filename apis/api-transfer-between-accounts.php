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
if(!ctype_digit($iAmount)){ sendResponse(-1, __LINE__, 'Amount can only contain numbers'); }

$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );

if( $jData == null){ sendResponse(-1, __LINE__, 'Cannot convert data to JSON'); }

$jInnerData = $jData->data;

$overallBalance = $jInnerData->$sUserId->totalBalance->balance;
$debitAccountBalance = $jInnerData->$sUserId->accounts->debitAccount->accountBalance;
$checkingAccountBalance = $jInnerData->$sUserId->accounts->checkingAccount->accountBalance;
$savingsAccountBalance = $jInnerData->$sUserId->accounts->savingsAccount->accountBalance;

$overallBalance = $debitAccountBalance + $checkingAccountBalance +$savingsAccountBalance;

/* echo json_encode($overallBalance);
echo json_encode($debitAccountBalance);
echo json_encode($checkingAccountBalance ); */

if($jInnerData->$sPhone){
  if($iAmount > $jInnerData->$sUserId->totalBalance){
    sendResponse(-1, __LINE__, 'You dont have enough money in your account');
  }
  $jInnerData->$sUserId->totalBalance->balance -= $iAmount;
  $jInnerData->$sPhone->totalBalance->balance += $iAmount;

  $sData = json_encode($jData, JSON_PRETTY_PRINT);
  file_put_contents('../data/clients.json', $sData);

}

sendResponse( 1, __LINE__ , 'Phone registered locally' );

function sendResponse($iStatus, $iLineNumber, $sMessage){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}

