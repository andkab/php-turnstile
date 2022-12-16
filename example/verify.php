<?php

require_once '../vendor/autoload.php';

use andkab\Turnstile\Turnstile;

$turnstile = new Turnstile('secret key');
$verifyResponse = $turnstile->verify($_POST['cf-turnstile-response'], $_SERVER['REMOTE_ADDR']);

if ($verifyResponse->success) {
    // successfully verified captcha resolving
} else {
    if ($verifyResponse->hasErrors()) {
        foreach ($verifyResponse->errorCodes as $errorCode) {
            echo $errorCode . '\n'; 
        }
    } else {
        // unknown reason of failure resolving of captcha
    }
}
