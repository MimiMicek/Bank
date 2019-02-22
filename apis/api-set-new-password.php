<?php

ini_set('display_errors', 0);

$sPhone = $_POST['phone'];
$sActivationKey = $_POST['activation-key'];

$sPassword = $_POST['txtNewPassword'] ?? '';
if(empty($sPassword)){ sendResponse(0, __LINE__); }
if(strlen($sPassword) < 4){ sendResponse(0, __LINE__); }
if(strlen($sPassword) > 20){ sendResponse(0, __LINE__); }

$sConfirmNewPassword = $_POST['txtConfirmNewPassword'] ?? '';
if(empty($sConfirmNewPassword)){ sendResponse(0, __LINE__); }
if($sPassword != $sConfirmNewPassword){ sendResponse(0, __LINE__); }

$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ sendResponse(0, __LINE__); }
$jInnerData = $jData->data;

if($jInnerData->$sPhone->activationKey != $sActivationKey){
  sendResponse(0, __LINE__); 
} 

$jInnerData->$sPhone->password = password_hash($sPassword, PASSWORD_DEFAULT);

$sData = json_encode($jData, JSON_PRETTY_PRINT);
file_put_contents('../data/clients.json', $sData);

sendResponse(1, __LINE__);

function sendResponse($bStatus, $iLineNumber){
  echo '{"status":'.$bStatus.', "code":'.$iLineNumber.'}';
  exit;
}
 
