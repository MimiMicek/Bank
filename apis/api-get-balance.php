<?php

ini_set('display_errors', 0);

session_start();
$sUserId = $_SESSION['sUserId'];
$sData = file_get_contents('../data/clients.json');
$jData = json_decode($sData);

$jInnerData = $jData->data;

echo $jInnerData->$sUserId->totalBalance->balance;