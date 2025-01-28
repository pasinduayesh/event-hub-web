<?php
function generateUniqueID($numDigits)
{

    $timestamp = microtime(true);

    $random = mt_rand();

    $userSpecificValue = isset($_SESSION['user_verification_id']) ? $_SESSION['user_verification_id'] : '';

    $uniqueID = md5($timestamp . $random . $userSpecificValue);

    $uniqueID = substr($uniqueID, 0, $numDigits);

    return $uniqueID;
}