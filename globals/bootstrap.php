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

      $data = [];

      $content = include_once $file;

      $content = $data ?? [];

      $vars[basename($file, ".php")] = $content;

      ob_end_clean();
    }
  }

  return $vars;
}

$app_state = require_all_configs();

print_debugger($app_state);
