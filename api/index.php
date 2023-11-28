<?php

declare(strict_types=1);

/**
 * @var string
 * Root of project
 */
$root = str_replace("/index.php", "", $_SERVER['PHP_SELF']);
define('ROOT', "{$_SERVER['DOCUMENT_ROOT']}$root");
define('API_ROOT', "{$_SERVER['DOCUMENT_ROOT']}$root/rest/functions");

/**
 * @var array
 */
$app_env = parse_ini_file(ROOT . "/.env");
define("APP_ENV", $app_env);

/**
 * Sets timezone
 */
if (!ini_get('date.timezone')) {
  date_default_timezone_set('America/Sao_Paulo');
}

/**
 * @var array
 */
$end = explode('.', $_SERVER['SERVER_NAME']);
$end = array_pop($end);

if ($_SERVER['SERVER_NAME'] === APP_ENV['DEV_URL'] || $end === APP_ENV['DEV_URL_ENDING']) {
  define('ENVIRONMENT', 'development');
} else {
  define('ENVIRONMENT', 'production');
}
switch (ENVIRONMENT) {
  case 'development':
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    break;
  case 'production':
    error_reporting(0);
    ini_set('display_errors', 0);
    break;
  default:
    error_reporting(0);
    ini_set('display_errors', 0);
    break;
}

try {
  require_once ROOT . "/globals/bootstrap.php";
} catch (Throwable $error) {
  echo "<pre>";
  print_r($error->getTrace());
  echo "</pre>";
  require_once API_ROOT . "/rest/functions/errors/404.php";
}

try {
  require_once ROOT . "/rest/index.php";
} catch (Throwable $error) {
  echo "<pre>";
  print_r($error->getTrace());
  echo "</pre>";
  require_once ROOT . "/rest/functions/errors/404.php";
}
