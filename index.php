<script
  src="https://code.jquery.com/jquery-3.6.1.js"
  integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI="
  crossorigin="anonymous"></script>
<?php
require __DIR__ . '/autoload.php';
use \GuzzleHttp\Client;

$api_key = 'IMYBHXc3WQIhoZMZ8rKNcPHSZLLq5MxqbpQJNy0eGlWKzvII';
$api_secret = 'J69dVDfrXgtxfWuCBPbPOVhbHW3LMZEmqtBVaJ1hAWuSfYYf';

$authorization_url = 'https://accounts.paxful.com/oauth2/authorize';
$token_url = 'https://accounts.paxful.com/oauth2/token';

$client_id = $api_key;
$client_secret = $api_secret;

// Step 1: Redirect the user to the authorization URL if no 'code' parameter present in the URL
if (!isset($_GET['code'])) {
    $authorization_params = array(
        'response_type' => 'code',
        'client_id' => $client_id,
        'redirect_uri' => 'http://localhost/paxfulapi/index.php',
        'scope' => 'all',
    );
    $authorization_url .= '?' . http_build_query($authorization_params);
    header('Location: ' . $authorization_url);
    exit;
}

// Step 2: Exchange the authorization code for an access token
$code = $_GET['code'];
$token_params = array(
    'grant_type' => 'authorization_code',
    'code' => $code,
    'redirect_uri' => 'http://localhost/paxfulapi/index.php',
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    
);

$token_response = \Requests::post($token_url, array(), $token_params);
// echo "<pre>";
// print_r($token_response);
// var_dump($token_response);
// $token_response = requests\post($token_url, $token_params);
if (isset(json_decode($token_response->body)->access_token)) {
    $access_token = json_decode($token_response->body)->access_token;
    // print_R($access_token);
    // die();
} else {
    // Handle the case where the access token is not present in the response
    echo 'Error: Failed to retrieve access token from API response.';
    die();
}
// Step 3: Fetch purchase data using the Paxful API
//  application/x-www-form-urlencoded, must be text/plain
$headers = array(
    'Authorization: Bearer ' . $access_token,
    'Accept: application/json; version=1',
    'Content-Type: text/plain',
);

$response = \Requests::post('https://paxful.com/api/user/info',array(
    'Accept'=>'application/json; version=1',
    'Content-Type'=> 'text/plain'), $headers
);
// $data = $response->json();
// echo $access_token;

// last_hit($access_token);
echo "<pre>";
print_r($response);
exit;

// function last_hit($access_token)
// {
//     ?>
    
//     <script>
//         jQuery.ajax({
//             url:"https://paxful.com/api/user/info",
//             type:"POST",
//             dataType: 'jsonp',
//             CORS: true ,
//             contentType:'application/json',
//             secure: true,
//             headers:{
//                 'Accept': 'application/json; version=1',
//                 'Content-Type': 'text/plain',
//                 'Access-Control-Allow-Origin': '*'
//             },
//             beforeSend: function (xhr) {
//                 xhr.setRequestHeader ("Authorization", "Bearer <?=$access_token?>");
//             },            
//             success:function(response)
//             {                
//                 console.log('<?=$access_token?>');
//                 console.log(response);
//             }
//         });
//     </script>
//     <?php
// }

// Process the purchase data as needed
// foreach ($data['data'] as $purchase) {
//     // Handle each purchase record here
// }

// // Step 4: Receive webhook notifications for new purchases
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $webhook_data = json_decode(file_get_contents('php://input'), true);

//     // Handle the webhook data here
//     // For example, update a database or trigger a notification
// }
?>

<script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>

