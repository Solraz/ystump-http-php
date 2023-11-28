<?php

/**
 * @var string
 * @var string
 */
$table = str_replace("/", "", $app_state['router']['subdomain']);
$function = $app_state['router']['function'] ?: "get";

/**
 * @var match
 * 
 * @return string
 */
match ($function) {
  "get", "select" => run_function("/database/", "select"),
  "add", "insert" => run_function("/database/", "select"),
};
