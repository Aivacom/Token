<?php
include("ScTokenUtil.php");
$token = ScTokenUtil::createToken('123', ['parameter1' => 'a'], ['privilege1' => 100001]);
echo $token . "\n";