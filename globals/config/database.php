<?php

/**
 * @var array
 */
$dev_db = [
  "host" => "localhost",
  "port" => "3306",
  "user" => "root",
  "pass" => "",
  "database" => "survive",
  "charset" => "utf8"
];


/**
 * @var array
 */
$db = [
  "host" => "localhost",
  "port" => "3306",
  "user" => APP_ENV["DB_USER"],
  "pass" => APP_ENV["DB_PASS"],
  "database" => "survive",
  "charset" => "utf8"
];


/**
 * @var array
 */
$select_db = ENVIRONMENT === 'production' ? $db : $dev_db;
foreach ($select_db as $key => $value) {
  ${$key} = $value;
}

/**
 * @var array
 */
$data = [];


try {
  mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

  /**
   * @var mysqli
   */
  $connection = mysqli_connect("{$host}:{$port}", "{$user}", "{$pass}", "{$database}");
  mysqli_set_charset($connection, "{$charset}");

  $data["connection"] = $connection;
  $data["database"] = $database;

  return $data;
} catch (Throwable $th) {
  $data["error"] = $th->getMessage();
  return $data;
}
