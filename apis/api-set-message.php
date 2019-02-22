<?php
$sUserId = $_POST['txt-user-id'];
$sMessage = $_POST['txt-message'];
$sUserId = $sUserId;
file_put_contents( "../data/to-$sUserId.txt", $sMessage );