<?php

ini_set('display_errors', 0);

$sData = file_get_contents('../data/clients.json');
$jData = json_decode( $sData );
if( $jData == null ){ fnvSendResponse(-1, __LINE__, 'Cannot convert the data file to json'); }
$jInnerData = $jData->data;

$sPhoneFromOtherServer = $_GET['phone'];
$iAmountFromOtherServer = $_GET['amount'];
$sMessageFromOtherServer = $_GET['message'];

if( !$jInnerData->$sPhoneFromOtherServer ){
    fnvSendResponse(0, __LINE__, 'Phone not registered in Erceg Bank');
}

$jInnerData->$sPhoneFromOtherServer->totalBalance += $iAmountFromOtherServer;

$iTransactionDate = time();
$jTransaction->date = date('D-d-M-Y', $iTransactionDate);
$jTransaction->amount = $iAmountFromOtherServer;
$jTransaction->name = 'AA';
$jTransaction->lastName = 'AAA';
$jTransaction->fromPhone = $sPhoneFromOtherServer;
$jTransaction->message = $sMessageFromOtherServer;
$sTransactionUniqueId = uniqid();

$jInnerData->$sPhoneFromOtherServer->transactionsNotRead->$sTransactionUniqueId = $jTransaction;
$jInnerData->$sPhoneFromOtherServer->transactions->$sTransactionUniqueId = $jTransaction;

$sData = json_encode($jData);
file_put_contents('../data/clients.json', $sData);

fnvSendResponse(1, __LINE__, 'Transaction success from Erceg Bank');

function fnvSendResponse( $iStatus, $iLineNumber, $sMessage ){
  echo '{"status":'.$iStatus.', "code":'.$iLineNumber.', "message":"'.$sMessage.'"}';
  exit;
}




