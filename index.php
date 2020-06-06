<?php

// api/new-report

// Simple router
$path = explode("/", $_SERVER['REQUEST_URI']);
array_shift($path);

if (strtolower($path[0]) == "api" &&
    strtolower($path[1]) == "new-report") {
  // continuing
  echo "Entering report handler";
} else {
  http_response_code(404);
  echo "404";
  die();
}


$fp = fopen('/var/www/html/request.log', 'a');

$entityBody = json_decode(file_get_contents('php://input'));
// TODO: check for pubkey attribute before using
$entityBody->key = $_SERVER['HTTP_PUBLIC_KEY'];

// Validate attributes
$requiredValues = ["hostname","runtimeSeconds","exitCode","runMode","key"];

$missingOptions = [];
foreach ($requiredValues as $o) {
  if(property_exists($entityBody, $o)) {
    echo "Found $o";
  } else {
    $missingOptions[] = $o;
  }
}

if ( count($missingOptions) > 0) {
  header( 'HTTP/1.1 400 BAD REQUEST' );
  echo "400 BAD REQUEST: missing options: " . join($missingOptions,", ");
  die();
}

fwrite($fp, json_encode($entityBody)."\n");


fclose($fp);

?>

