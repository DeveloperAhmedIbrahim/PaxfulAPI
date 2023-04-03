<?php
$api_key = 'BMTe2914LmYWR6mQb6mdP8tShY54Hrrh';
$api_secret = 'PEv5BXqAuzVyapJDS60L1RbP3EomgjEo';
$bitcoin_address = '3Jzg4qRJGKyKDez2VjuYVXVztPTod7DEbs';
$merchant = 'or4QNELLkXe';

if(isset($_GET['btc_amount']))
{
    $btc_amount = $_GET['btc_amount'];
}

$payload = [
    'merchant' => $merchant,
    'apikey' => $api_key,
    'to' => $bitcoin_address,
    'amount' => $btc_amount,
    'track_id' => time()
];

function sign_with_hmac($api_key, $api_secret, array $payload = []) {
    $payload = array_merge($payload, [
        'apikey' => $api_key,
        'nonce' => time()
    ]);

    $apiSeal = hash_hmac('sha256', http_build_query($payload), $api_secret);
    $signed_payload = http_build_query(array_merge($payload, ['apiseal' => $apiSeal]));
    return $signed_payload;
}

$signed_payload = sign_with_hmac($api_key,$api_secret,$payload);
$post_url = 'https://paxful.com/wallet/pay';
$post_url .= '?' . $signed_payload;
?>
<script>
    window.location.href = '<?php echo $post_url; ?>';
</script>