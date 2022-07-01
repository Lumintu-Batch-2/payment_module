<?php

function http_request_with_auth($url, $token) {

    $auth = "Authorization: Bearer " . $token;
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $auth));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $out = curl_exec($ch);
    curl_close($ch);

    return $out;
}

function http_request($url) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $out = curl_exec($ch);

    curl_close($ch);

    return $out;
}