<?php

try {
  run_function($app_state['router']['subdomain'], $app_state['router']['route']);
} catch (Throwable $th) {
  echo "<pre>";
  print_r($error->getTrace());
  echo "</pre>";
  require_once API_ROOT . "/rest/functions/errors/404.php";
}
