<?php

require __DIR__ . '/autoload.php';
use \GuzzleHttp\Client;

$post_url = "https://accounts.paxful.com/oauth2/token";
$header = [
    'Content-Type'=>'application/x-www-form-urlencoded'
];
$request = [
    'grant_type'=>'client_credentials',
    'client_id'=>'9LOrI3Y1rtGfAFE94T3E76DeYi0cuxcitAqJRehuu6BPjlb0',
    'client_secret'=>'B7TfXsBjDr8g1Mv3gG464ugqEI9Af6RmuugG2XMVG79q31F9',
    'redirect_uri' => 'http://localhost/paxfulapi/direct-access.php'
];

$response = \Requests::post($post_url, $header, $request);
$access_token = json_decode($response->body)->access_token;

if (!isset($_GET['code'])) {
    $authorization_url = 'https://accounts.paxful.com/oauth2/authorize';
    $authorization_params = array(
        'response_type' => 'code',
        'client_id' => '9LOrI3Y1rtGfAFE94T3E76DeYi0cuxcitAqJRehuu6BPjlb0',
        'redirect_uri' => 'http://localhost/paxfulapi/direct-access.php',
        'scope' => 'all',
    );
    $authorization_url .= '?' . http_build_query($authorization_params);
    header('Location: ' . $authorization_url);
    exit;
}

$headers = [
    'Authorization'=>'Bearer ' . $access_token,
    // 'Accept' => 'application/x-www-form-urlencoded',
    // 'Content-Type' => 'text/plain'
];

$request = [
    // 'convert_to' => 'BTC',
    // 'convert_from' => 'USDT'
];

$response = \Requests::post('https://paxful.com/api/purchases',$headers, array());
echo "<pre>";
$body = json_decode($response->body);
// $data = $body->data[0];
// $quote_id = $data->quote_id;
print_r($response);
exit;
?>