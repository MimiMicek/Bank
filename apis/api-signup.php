<?php

ini_set('display_errors', 0);

$sPhone = $_POST['txtSignupPhone'] ?? '';
if(empty($sPhone)){ sendResponse(0, __LINE__); }
if(strlen($sPhone) != 8){ sendResponse(0, __LINE__); }
if(intval($sPhone) < 10000000){ sendResponse(0, __LINE__); }
if(intval($sPhone) > 99999999){ sendResponse(0, __LINE__); }
if(!ctype_digit($sPhone)){ sendResponse(0, __LINE__);  }

$sName = $_POST['txtSignupName'] ?? '';
if(empty($sName)){ sendResponse(0, __LINE__); }
if(strlen($sName) < 4 ){ sendResponse(0, __LINE__); }
if(strlen($sName) > 20 ){ sendResponse(0, __LINE__); }

$sLastName = $_POST['txtSignupLastName'] ?? '';
if(empty($sLastName)){ sendResponse(0, __LINE__); }
if(strlen($sLastName) < 4 ){ sendResponse(0, __LINE__); }
if(strlen($sLastName) > 20 ){ sendResponse(0, __LINE__); }

$sEmail = $_POST['txtSignupEmail'] ?? '';
if(empty($sEmail)){ sendResponse(0, __LINE__); }
if(!filter_var($sEmail, FILTER_VALIDATE_EMAIL)){
  sendResponse(0, __LINE__);
}

$sCpr = $_POST['txtSignupCpr'] ?? '';
if(empty($sCpr)){ sendResponse(0, __LINE__); }
if(strlen($sCpr) != 10){ sendResponse(0, __LINE__); }
if(!ctype_digit($sCpr)){ sendResponse(0, __LINE__); }

$sPassword = $_POST['txtSignupPassword'] ?? '';
if(empty($sPassword)){ sendResponse(0, __LINE__); }
if(strlen($sPassword) < 4){ sendResponse(0, __LINE__); }
if(strlen($sPassword) > 20){ sendResponse(0, __LINE__); }

$sConfirmPassword = $_POST['txtSignupConfirmPassword'] ?? '';
if(empty($sConfirmPassword)){ sendResponse(0, __LINE__); }
if($sPassword != $sConfirmPassword){ sendResponse(0, __LINE__); }

$sData = file_get_contents('../data/clients.json');//opening the file
$jData = json_decode($sData);//decoding it to text
if($jData == null){ sendResponse(0, __LINE__); }//checking if its corrupted

$jInnerData = $jData->data;

$jClient = new stdClass();
$jClient->name = $sName;
$jClient->lastName = $sLastName;
$jClient->email = $sEmail;
$jClient->cpr = $sCpr;
$jClient->password = password_hash($sPassword, PASSWORD_DEFAULT);
$jClient->active = 1;
$jClient->iLoginAttemptsLeft = 3;
$jClient->iLastLoginAttempt = 0;

//TODO provjeriti jos kako cu napraviti accounts
//My Accounts bi trebali prikazivati Sve accounts i Balance na svakom
//Open new Account izaberem koji s klikom na gumb
//Svaki racun bi trebao imati svoj ID??
$jClient->accounts = new stdClass();
$jAccounts = $jClient->accounts;
$jAccounts->checkingAccount = new stdClass();
$checkingAccount = $jAccounts->checkingAccount; 
$checkingAccount->accountName = "checking";
$checkingAccount->accountBalance = 0;
$checkingAccount->active = 1;
$checkingAccount->currency= "EUR";
$jAccounts->debitAccount = new stdClass(); 
$debitAccount = $jAccounts->debitAccount;
$debitAccount->accountName = "debit";
$debitAccount->accountBalance = 0;
$debitAccount->active = 1;
$debitAccount->currency = "DKK";
$jAccounts->savingsAccount = new stdClass(); 
$savingsAccount = $jAccounts->savingsAccount;
$savingsAccount->accountName = "savings";
$savingsAccount->accountBalance = 0;
$savingsAccount->active = 1;
$savingsAccount->currency = "DKK";

$debitAccountBalance = $debitAccount->accountBalance;
$checkingAccountBalance = $checkingAccount->accountBalance;
$savingsAccountBalance = $savingsAccount->accountBalance;

$jClient->totalBalance = new stdClass();
$totalBalance = $jClient->totalBalance;
$totalBalance->name = "balance";
$overallBalance = ($checkingAccountBalance * 7.47) + $debitAccountBalance + $savingsAccountBalance;
$totalBalance->balance = $overallBalance;
$totalBalance->currency = "DKK";

$jClient->transactions = new stdClass();
$jClient->transactionsNotRead = new stdClass();
$jClient->creditCards = new stdClass();

$jInnerData->$sPhone = $jClient;//put the $jClient object in the data under the $sPhone 

$sData = json_encode($jData, JSON_PRETTY_PRINT);//encode string back to object
if($sData == null){ sendResponse(0, __LINE__); }//check if corrupted
file_put_contents('../data/clients.json', $sData);//saving it back to the file

sendResponse(1, __LINE__);

function sendResponse($bStatus, $iLineNumber){
  echo '{"status":'.$bStatus.', "code":'.$iLineNumber.'}';
  exit;
}