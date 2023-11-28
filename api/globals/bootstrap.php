<?php

require_once ROOT . "/globals/core_functions/debugging.php";

/**
 * @var array
 */
$app_state = [];
/**
 * @var function
 * @return array
 */
function require_all_configs(): array
{
  $vars = [];

  $files = glob(ROOT . "/globals/config" . "/*.php");

  foreach ($files as $file) {
    if (is_file($file) && pathinfo($file, PATHINFO_EXTENSION) === "php") {
      ob_start();

      include_once $file;

      $vars[basename($file, ".php")] = $data;

      ob_end_clean();
    }
  }

  return $vars;
}
$app_state = require_all_configs();

/**
 * @var function
 * 
 * @param string
 * @param string
 * 
 * @return string|void
 */
function run_function($subdomain, $route, ...$vars)
{
  global $app_state;

  foreach ($vars as $var) {
    if (gettype($var) !== "array") continue;

    foreach ($var as $key => $value) {
      $$key = $value;
    }
  }

  ob_start();
  include API_ROOT . "{$subdomain}{$route}.php";
  $content = ob_get_contents();
  ob_end_clean();

  echo $content;
}

/**
 * @param string|array|boolean|int
 * @param int
 * 
 * @return string
 */
function api_handling($response, $http = 200): void
{
  $type = gettype($response);

  if ($type === "string" || $type == "array") {
    $response = ['response' => $response];
  }

  if ($type === "boolean" || $type === "integer") {
    $response = ['status' => $response];
  }

  http_response_code($http);

  header("Content-Type: application/json; charset=UTF-8");

  match ($http) {
    200 => header("{$_SERVER['SERVER_PROTOCOL']} 200 OK"),
    404 => header("{$_SERVER['SERVER_PROTOCOL']} 404 Not Found"),
    500 => header("{$_SERVER['SERVER_PROTOCOL']} 500 Server Error"),
  };

  echo json_encode($response, JSON_INVALID_UTF8_IGNORE);
}
