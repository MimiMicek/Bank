<?php

ini_set('display_errors', 0);

session_start();
$sUserId = $_SESSION['sUserId'];

if( !isset($_SESSION['sUserId'] ) ){
    sendResponse(-1, __LINE__, 'You must login to use this api');
}

$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if($jData == null ){sendResponse(-1, __LINE__, 'cant fetch json data'); }
$jInnerData = $jData->data;

$jTransactionsNotRead = $jInnerData->$sUserId->transactionsNotRead;
$jTransactionsRead = $jInnerData->$sUserId->transactions;

echo $jTransactionsNotRead;
