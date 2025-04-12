<?php
function sanitize_input($data) {
  return htmlspecialchars(stripslashes(trim($data)));
}

function validate_input($data, $type) {
  switch ($type) {
    case 'int':
      return filter_var($data, FILTER_VALIDATE_INT);
    case 'float':
      return filter_var($data, FILTER_VALIDATE_FLOAT);
    case 'email':
      return filter_var($data, FILTER_VALIDATE_EMAIL);
    case 'url':
      return filter_var($data, FILTER_VALIDATE_URL);
    default:
      return false;
  }
}
?>
