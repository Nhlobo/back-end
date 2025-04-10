<?php
header("Access-Control-Allow-Origin: https://your-github-pages-url");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


header('HTTP/1.0 200 OK');
flush();

$pfData = $_POST;
$passPhrase = 'jt7NOE43FZPn';

function pfValidSignature($pfData, $pfParamString, $pfPassphrase = null) {
    $tempParamString = $pfPassphrase ? $pfParamString . '&passphrase=' . urlencode($pfPassphrase) : $pfParamString;
    $signature = md5($tempParamString);
    return $pfData['signature'] === $signature;
}

function pfValidIP() {
    $validHosts = ['www.payfast.co.za', 'sandbox.payfast.co.za', 'w1w.payfast.co.za', 'w2w.payfast.co.za'];
    $validIps = [];
    foreach ($validHosts as $pfHostname) {
        $ips = gethostbynamel($pfHostname);
        if ($ips !== false) {
            $validIps = array_merge($validIps, $ips);
        }
    }
    $validIps = array_unique($validIps);
    $referrerIp = gethostbyname(parse_url($_SERVER['HTTP_REFERER'])['host']);
    return in_array($referrerIp, $validIps, true);
}

foreach ($pfData as $key => $val) {
    $pfData[$key] = stripslashes($val);
}

$pfParamString = '';
foreach ($pfData as $key => $val) {
    if ($key !== 'signature') {
        $pfParamString .= $key . '=' . urlencode($val) . '&';
    }
}
$pfParamString = substr($pfParamString, 0, -1);

$check1 = pfValidSignature($pfData, $pfParamString, $passPhrase);
$check2 = pfValidIP();

if ($check1 && $check2) {
    // Payment is valid, update your order status
    echo "Payment successful";
} else {
    // Payment is invalid, log for investigation
    echo "Payment failed";
}
?>
