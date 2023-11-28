<?php

/**
 * @var string
 */
$route = $_REQUEST['route'] ?: "errors/404";

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
$subdomain = "";

/**
 * @var string
 */
$function = "";

$pages = new RecursiveDirectoryIterator(ROOT . "/rest/functions");
$iterator = new RecursiveIteratorIterator($pages);
$regex = new RegexIterator($iterator, "/^.+\.php$/i", RecursiveRegexIterator::GET_MATCH);

foreach ($regex as $page => $value) {
  $true_file = str_replace([ROOT, "/rest/functions/", "/rest/functions\\", "/rest/", "/rest\\", ".php"], "", $page);
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

    // $total_subdomain_string = rtrim($total_subdomain_string, "/");
    $subdomains[] = "/{$total_subdomain_string}";
  } else {
    $routes[] = "{$true_path[0]}";
  }
}

/**
 * @var array
 */
$full_path = explode("/", $route);

/**
 * @var array
 */
$last = array_pop($full_path);

/**
 * @var string
 */
$path = implode("/", $full_path);

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

/**
 * @var array
 */
$subdomains = [...array_unique($subdomains)];

if ($function) {
  array_pop($full_path);
}

/**
 * @var string
 */
$subdomain = "/" . implode("/", $full_path) . "/";

if ($function) {
  $subdomain = str_replace($route, "", $subdomain);
}

if (!in_array($subdomain, $subdomains)) {
  $subdomain = "";
}

$route = str_replace(ltrim($subdomain, "/"), "", $route);

$data = [
  "route" => $route,
  "routes" => $routes,
  "subdomains" => $subdomains,
  "subdomain" => $subdomain,
  "function" => $function,
];

return $data;
