<?php
$conn = $app_state['database']['connection'];
$db = $app_state['database']['database'];

$query_string = <<<MYSQL
  SELECT * FROM {$table};
MYSQL;

try {
  $query = mysqli_query($conn, $query_string);
  $result = mysqli_fetch_assoc($query);

  api_handling($result, 200);
} catch (Throwable $th) {
  print_r($th->getTrace());
  api_handling("CRITICAL ERROR", 500);
}
