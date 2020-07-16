<?php

include 'ScToken.php';


function urlsafe_b64decode($string) {
    $data = str_replace(array('-','_'),array('+','/'),$string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    return base64_decode($data);
  }

$appid = 1234;
$secret = '1234';
$version = 2;
$uid = '2483549835';
$validateTime = 4*60*60;
// $currentTime = 1589429259174l;

echo ScToken::buildToken(1234,'1234',2,'2483549835',4*60*60,1589429259174);



?>