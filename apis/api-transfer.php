<?php
ini_set('user_agent', 'any');
ini_set('display_errors', 0);

session_start();
if(!isset($_SESSION['sUserId'])){
  sendResponse(-1, __LINE__, 'You must login to use this api');
}

$sUserId = $_SESSION['sUserId']; 

if(empty($_GET['phone'])){ sendResponse(-1, __LINE__, 'Phone missing'); }
if(empty($_GET['amount'])){ sendResponse(-1, __LINE__, 'Amount is missing'); }
if(empty($_GET['message'])){ sendResponse(-1, __LINE__, 'Message is missing'); }

$sPhone = $_GET['phone'] ?? '';
if(strlen($sPhone) != 8){ sendResponse(-1, __LINE__, 'Phone must be 8 characters in length'); }
if(!ctype_digit($sPhone)){ sendResponse(-1, __LINE__, 'Phone can only contain numbers'); }

$iAmount = $_GET['amount'] ?? '';
if(!ctype_digit($iAmount)){ sendResponse(-1, __LINE__, 'Amount can only contain numbers'); }

$sMessage = $_GET['message'] ?? '';
if(strlen($sMessage) < 2){ sendResponse(-1, __LINE__, 'Message cannot be less than 2 characters in length'); }
if(strlen($sMessage) > 30){ sendResponse(-1, __LINE__, 'Message cannot be more than 30 characters in length'); }

$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );

if( $jData == null){ sendResponse(-1, __LINE__, 'Cannot convert data to JSON'); }

$jInnerData = $jData->data;

if($jInnerData->$sPhone){
  if($iAmount > $jInnerData->$sUserId->totalBalance->balance){
    sendResponse(-1, __LINE__, 'You dont have enough money in your account');
  }
  $jInnerData->$sUserId->totalBalance->balance -= $iAmount;
  $jInnerData->$sPhone->totalBalance->balance += $iAmount;

  $sData = json_encode($jData, JSON_PRETTY_PRINT);
  file_put_contents('../data/clients.json', $sData);

}

if(!$jInnerData->$sPhone){
  $jListOfBanks = fnjGetListOfBanksFromCentralBank();

  foreach( $jListOfBanks as $sKey => $jBank ){
    $sUrl = $jBank->url.'/apis/api-handle-transaction?phone='.$sPhone.'&amount='.$iAmount.'&message='.$sMessage;
   
    $sBankResponse =  file_get_contents($sUrl);
    $jBankResponse = json_decode($sBankResponse);

    if( $jBankResponse->status == 1 && 
        $jBankResponse->code && 
        $jBankResponse->message ){
         sendResponse( 1, __LINE__ , $jBankResponse->message);
        }
  }
  sendResponse( 2, __LINE__ , 'Phone does not exist' );
}



sendResponse( 1, __LINE__ , 'Phone registered locally' );

function sendResponse($iStatus, $iLineNumber, $sMessage){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.',"message":"'.$sMessage.'"}';
  exit;
}

function fnjGetListOfBanksFromCentralBank(){
  $sData = file_get_contents('https://ecuaguia.com/central-bank/api-get-list-of-banks.php?key=1111-2222-3333');
  return json_decode($sData);
}


