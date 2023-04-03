<?php 

$api_key = 'VY1q6nmpq8pAsPwJ5IDv9npaybJmKn8E';
$api_secret = 'cQMshQJUkVE7ij69koWjLgNo4cuAwYP9';
$token_url = 'https://accounts.paxful.com/oauth2/token';
$client_id = $api_key;
$client_secret = $api_secret;


// Step 2: Exchange the authorization code for an access token
$code = $_GET['code'];
$token_params = array(
    'grant_type' => 'authorization_code',
    'code' => $code,
    'redirect_uri' => 'http://paxful.az-solutions.pk/callback.php',
    'client_id' => $client_id,
    'client_secret' => $client_secret,
);

$token_response = httpPost($token_url, $token_params);
echo "<pre>";
print_r($token_response);
exit;
$access_token = $token_response->access_token;

// Step 3: Fetch purchase data using the Paxful API
$headers = array(
    'Authorization: Bearer ' . $access_token,
    'Accept: application/json',
);
$response = requests.get('https://paxful.com/api/purchases', $headers);
$data = $response->json();


$response = httpPost("http://mywebsite.com/update.php",
	array("first_name"=>"Bob","last_name"=>"Dillon")
);

//using php curl (sudo apt-get install php-curl) 
function httpPost($url, $data){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

?>