<?php

ini_set('display_errors', 0);

$sPhone = $_POST['txtLoginPhone'] ?? '';
if(empty($sPhone)){ sendResponse(0, __LINE__); }
if(strlen($sPhone) != 8){ sendResponse(0, __LINE__); }
if(!ctype_digit($sPhone)){ sendResponse(0, __LINE__); }

$sPassword = $_POST['txtLoginPassword'] ?? '';
if(empty($sPassword)){ sendResponse(0, __LINE__); }
if(strlen($sPassword) < 4){ sendResponse(0, __LINE__); }
if(strlen($sPassword) > 20){ sendResponse(0, __LINE__); }

$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if( $jData == null ){ sendResponse(0, __LINE__); }
$jInnerData = $jData->data;

if($jInnerData->$sPhone->iLoginAttemptsLeft == 0){
  $iSecondsElapsedSinceLastLoginAttempt = $jInnerData->$sPhone->iLastLoginAttempt + 5 - time();
   if($iSecondsElapsedSinceLastLoginAttempt <= 0){
     if(!password_verify( $sPassword, $jInnerData->$sPhone->password)){
       echo "Wrong credentials. You have to wait again!";
       exit;
     }
        $jInnerData->$sPhone->iLoginAttemptsLeft = 3;
        $jInnerData->$sPhone->iLastLoginAttempt = 0;
        $sData = json_encode($jData, JSON_PRETTY_PRINT);//encode string back to object
        if($sData == null){ sendResponse(0, __LINE__); }//check if corrupted
        file_put_contents('../data/clients.json', $sData);//saving it back to the file
        echo 'You are logged in';
        exit;
     }
   echo "wait $iSecondsElapsedSinceLastLoginAttempt seconds to log in again";
   exit;
   }

if(!password_verify( $sPassword, $jInnerData->$sPhone->password )){ 
  $jInnerData->$sPhone->iLoginAttemptsLeft --;
  $jInnerData->$sPhone->iLastLoginAttempt = time();
  $sData = json_encode($jData, JSON_PRETTY_PRINT);
  if($sData == null){ sendResponse(0, __LINE__); }
  file_put_contents('../data/clients.json', $sData);
  echo "Wrong credentials. You have {$jInnerData->$sPhone->iLoginAttemptsLeft} attempts left";
  exit;
}
/* if($sPassword != $jInnerData->$sPhone->password){ 
  sendResponse(0, __LINE__); 
}*/

session_start();
$_SESSION['sUserId'] = $sPhone;
sendResponse(1, __LINE__);

function sendResponse($bStatus, $iLineNumber){
  echo '{"status":'.$bStatus.', "code":'.$iLineNumber.'}';
  exit;
}
