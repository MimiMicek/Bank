<?php
ini_set('user_agent', 'any');
ini_set('display_errors', 0);

session_start();
if(!isset($_SESSION['sUserId'])){
  sendResponse(-1, __LINE__, 'You must login to use this api');
}

$sUserId = $_SESSION['sUserId']; 

if(empty($_POST['phone'])){ sendResponse(-1, __LINE__, 'Phone missing'); }
if(empty($_POST['amount'])){ sendResponse(-1, __LINE__, 'Amount is missing'); } 

$sPhone = $_POST['phone'] ?? '';
if(strlen($sPhone) != 8){ sendResponse(-1, __LINE__, 'Phone must be 8 characters in length'); }
if(!ctype_digit($sPhone)){ sendResponse(-1, __LINE__, 'Phone can only contain numbers'); } 

$iAmount = $_POST['amount'] ?? '';
if(!ctype_digit($iAmount)){ sendResponse(-1, __LINE__, 'Amount can only contain numbers'); } 

$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );

if( $jData == null){ sendResponse(-1, __LINE__, 'Cannot convert data to JSON'); }

$jInnerData = $jData->data;

if($jInnerData->$sPhone){
  $jInnerData->$sUserId->totalBalance->balance -= $iAmount;
  $jInnerData->$sPhone->totalBalance->balance += $iAmount;
  $sData = json_encode($jData, JSON_PRETTY_PRINT);
  file_put_contents('../data/clients.json', $sData);
}

header('Location: ../admin');
sendResponse( 1, __LINE__ , 'Phone registered locally' );


function sendResponse($iStatus, $iLineNumber, $sMessage){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}


