<?php

ini_set('display_errors', 0);

session_start();

if(!isset($_GET['id'])){
  header('Location: ../create-credit-card');
}

$sUserId = $_SESSION['sUserId'];

$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);
if($jData == null){ echo 'System update'; }
$jInnerData = $jData->data;
$jClient = $jInnerData->$sUserId->creditCards;

//looping through customers and finding a credit card id match
foreach($jClient as $sCreditCardId => $creditCard){
  if($_GET['id'] == $sCreditCardId){
    $creditCard->active = !$creditCard->active;
    $sData = json_encode($jData, JSON_PRETTY_PRINT);
    file_put_contents('../data/clients.json', $sData);
    header('Location: ../create-credit-card'); 
   }
} 

