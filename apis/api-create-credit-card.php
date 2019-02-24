<?php

ini_set('display_errors', 0);

session_start();
if(!isset($_SESSION['sUserId'])){
  sendResponse(-1, __LINE__, 'You must login to use this api');
}

$sUserId = $_SESSION['sUserId']; 

$sCreateCardName = $_POST['txtCreateCardName'] ?? '';
if(empty($sCreateCardName)){ sendResponse(0, __LINE__); } 
if(strlen($sCreateCardName) < 4){ sendResponse(0, __LINE__); } 
if(strlen($sCreateCardName) > 10){ sendResponse(0, __LINE__); }

$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ sendResponse(0, __LINE__); }
$jInnerData = $jData->data;

$creditCards = $jInnerData->$sUserId->creditCards;

$creditCardId = uniqid().uniqid();
$creditCards->$creditCardId = new stdClass();
$creditCard->name = $sCreateCardName; 
$creditCard->active = 1;
$creditCard->creditLimit = 5000;
$creditCards->$creditCardId = $creditCard;
//create uniqid as stdClass with name and active

$sData = json_encode($jData, JSON_PRETTY_PRINT);
if($sData == null){ sendResponse(0, __LINE__); }
file_put_contents('../data/clients.json', $sData);

sendResponse(1, __LINE__);

function sendResponse($bStatus, $iLineNumber){
  echo '{"status":'.$bStatus.', "code":'.$iLineNumber.'}';
  exit;
}
