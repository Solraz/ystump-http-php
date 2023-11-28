<?php

require_once ROOT . "/globals/core_functions/debugging.php";

$app_env = parse_ini_file(ROOT . "/.env");

print_debugger($app_env);

/**
 * @var array
 */
$app_state = [];

function require_all_configs(): array
{
  $vars = [];

  $files = glob(ROOT . "/globals/config" . "/*.php");

  foreach ($files as $file) {
    if (is_file($file) && array_reverse(explode("/", $file))[0] !== "state.php") {
      ob_start();

      $content = require_once $file;

      $content = $data ?? [];

      $vars[basename($file, ".php")] = $content;

      ob_end_clean();
    }
  }

  return $vars;
}

$app_state = require_all_configs();

print_debugger($app_state);
