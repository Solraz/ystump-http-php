<?php

/**
 * @var string
 */
$route = $_REQUEST['route'] ?? "home";

/**
 * @var array
 */
$routes = [];

/**
 * @var array
 */
$subdomains = [];

/**
 * @var string
 */
$current_subdomain = "";

/**
 * @var string
 */
$function = "";

$functions = new RecursiveDirectoryIterator(ROOT . "/rest/functions");
$iterator = new RecursiveIteratorIterator($functions);
$regex = new RegexIterator($iterator, "/^.+\.php$/i", RecursiveRegexIterator::GET_MATCH);

foreach ($regex as $file => $value) {
  $true_file = str_replace([ROOT, "/rest/functions/", "/rest/functions\\", "/rest/", "/rest\\", ".php"], "", $file);
  $true_path = explode("\\", $true_file);

  if (count($true_path) > 1) {
    $total_string = "";
    $total_subdomain_string = "";

    foreach ($true_path as $key => $value) {

      if ($key !== count($true_path) - 1) {
        $total_subdomain_string .= "{$value}/";
      }

      $total_string .= "{$value}/";

      if ($key === count($true_path) - 1) {
        $total_string = rtrim($total_string, "/");
      }
    }

    $routes[] = "{$total_string}";

    $total_subdomain_string = rtrim($total_subdomain_string, "/");
    $subdomains[] = "{$total_subdomain_string}";
  } else {
    $routes[] = "{$true_path[0]}";
  }
}

$current_subdomain = explode("/", $route);

$last = array_pop($current_subdomain);
$path = implode("/", $current_subdomain);

if (!in_array($route, $routes)) {
  if (in_array($path, $routes)) {
    $function = "{$last}";
    $route = $path;
  } else {
    $route = '404';
  }
} else {
  $route = $path . "/{$last}";
}

$subdomains = array_unique($subdomains);

$current_subdomain = implode("/", $current_subdomain);

if (!in_array($current_subdomain, $subdomains)) {
  $current_subdomain = "";
}

$data = [
  "route" => $route,
  "routes" => $routes,
  "subdomains" => $subdomains,
  "subdomain" => $current_subdomain,
  "function" => $function,
];


return $data;
