<?php

try {
  run_function($app_state['router']['subdomain'], $app_state['router']['route']);
} catch (\Throwable $th) {
  throw $th;
}
