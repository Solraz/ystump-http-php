<?php

$table = str_replace("/", "", $app_state['router']['subdomain']);
$function = $app_state['router']['function'] ?: "select";

print_debugger($table);
print_debugger($function);
