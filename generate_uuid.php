<?php
$passPhrase = 'jt7NOE43FZPn'; // Test passphrase
$data = [
    'merchant_id' => '10000100', // Test merchant ID
    'merchant_key' => '46f0cd694581a', // Test merchant key
    'amount' => number_format(10.00, 2, '.', ''),
    'item_name' => 'Test Product',
    'return_url' => 'http://localhost/return.php',
    'cancel_url' => 'http://localhost/cancel.php',
    'notify_url' => 'http://localhost/notify.php',
    'name_first' => 'First Name',
    'name_last' => 'Last Name',
    'email_address' => 'test@test.com',
];

function generateSignature($data, $passPhrase = null) {
    $pfOutput = '';
    foreach ($data as $key => $val) {
        if ($val !== '') {
            $pfOutput .= $key . '=' . urlencode(trim($val)) . '&';
        }
    }
    $getString = substr($pfOutput, 0, -1);
    if ($passPhrase !== null) {
        $getString .= '&passphrase=' . urlencode(trim($passPhrase));
    }
    return md5($getString);
}

function dataToString($dataArray) {
    $pfOutput = '';
    foreach ($dataArray as $key => $val) {
        if ($val !== '') {
            $pfOutput .= $key . '=' . urlencode(trim($val)) . '&';
        }
    }
    return substr($pfOutput, 0, -1);
}

function generatePaymentIdentifier($pfParamString, $pfProxy = null) {
    $url = 'https://sandbox.payfast.co.za/onsite/process';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, NULL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $pfParamString);
    if (!empty($pfProxy)) {
        curl_setopt($ch, CURLOPT_PROXY, $pfProxy);
    }
    $response = curl_exec($ch);
    curl_close($ch);
    $rsp = json_decode($response, true);
    if (isset($rsp['uuid'])) {
        return $rsp['uuid'];
    }
    return null;
}

$data['signature'] = generateSignature($data, $passPhrase);
$pfParamString = dataToString($data);
$uuid = generatePaymentIdentifier($pfParamString);
echo $uuid;
?>
