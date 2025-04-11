<?php
$merchant_id = "10000100";
$merchant_key = "46f0cd694581a";
$return_url = "https://nhlobo.github.io/front-end/return.html";
$cancel_url = "https://nhlobo.github.io/front-end/cancel_url";
$notify_url = "https://keep-trying-tuv0.onrender.com/notify.php";
$item_name = "Sample Product";
$amount = "10.00";

$data = array(
  'merchant_id' => $merchant_id,
  'merchant_key' => $merchant_key,
  'return_url' => $return_url,
  'cancel_url' => $cancel_url,
  'notify_url' => $notify_url,
  'amount' => $amount,
  'item_name' => $item_name,
);

$query_string = http_build_query($data);
header('Location: https://sandbox.payfast.co.za/eng/process?' . $query_string);
exit;
?>
