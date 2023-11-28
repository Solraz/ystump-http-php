<?php

/**
 * @var string
 * @var string
 */
$table = str_replace("/", "", $app_state['router']['subdomain']);
$function = $app_state['router']['function'] ?: "get";

/**
 * Normal CRUD functions with Aliases.
 * 
 * @var match
 * 
 * @return string
 */
match ($function) {
  "get", "select" => run_function("/database/", "select"),
  "add", "insert" => run_function("/database/", "insert"),
  "del", "rem", "renove", "delete" => run_function("/database/", "delete"),
  "change", "set", "edit" => run_function("/database/", "delete"),
};
