<?php
require __DIR__ . '/autoload.php';
use \GuzzleHttp\Client;

$api_key = 'T8nyOP6GfQxHnausufKWaTo0pGYgAa5edJlBzsA24rpEairZ';
$api_secret = '78mc3WcNerVzul3V32i0V9q8WNd4RdPA88N07B1or6UNmsQv';

$authorization_url = 'https://accounts.paxful.com/oauth2/authorize';

$client_id = $api_key;
$client_secret = $api_secret;

if (!isset($_GET['code'])) {
    $authorization_params = array(
        'response_type' => 'code',
        'client_id' => $client_id,
        'redirect_uri' => 'http://localhost/paxfulapi/api-offers.php',
        'scope' => 'all',
    );
    $authorization_url .= '?' . http_build_query($authorization_params);
    header('Location: ' . $authorization_url);
    exit;
}
$code = $_GET['code'];
$token_url = 'https://accounts.paxful.com/oauth2/token';
$header = [
    'Content-Type'=>'application/x-www-form-urlencoded'
];
$token_params = array(
    'grant_type' => 'authorization_code',
    'code' => $code,
    'redirect_uri' => 'http://localhost/paxfulapi/api-offers.php',
    'client_id' => $client_id,
    'client_secret' => $client_secret,
);
$token_response = \Requests::post($token_url, $header, $token_params);

if (isset(json_decode($token_response->body)->access_token)) {
    $access_token = json_decode($token_response->body)->access_token;

} else {
    // Handle the case where the access token is not present in the response
    echo 'Error: Failed to retrieve access token from API response.';
    die();
}

$headers = [
    'Authorization'=>'Bearer ' . $access_token,
    // 'Accept' => 'application/json; version=1',
    // 'Content-Type' => 'text/plain'
];

$parameters = [
    'offer_type'=>'buy'
];

$response = \Requests::post('https://api.paxful.com/paxful/v1/offer/all', $headers, $parameters);
$body = json_decode($response->body);
session_start();
$_SESSION["offers"] = $body;
header("Location: http://localhost:8000/deposit?code=".$code);
exit;
