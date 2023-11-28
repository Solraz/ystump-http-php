<?php

function print_debugger(string|array $array)
{
  echo "<pre>";
  print_r($array);
  echo "</pre>";
}

function error_testing(string|array $error)
{
  if (gettype($error) === "array") {
    foreach ($error as $e) {
      print_debugger($e);
      echo "\n";
    }
  } else {
    print_debugger($error);
  }
}
