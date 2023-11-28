<?php

/**
 * @var DateTime
 */
$current_time = new DateTime("NOW");

/**
 * @var string
 */
$formatted_current_time = $current_time->format("Y-m-d H:i:s");

/**
 * @var array
 */
$data = [
  'current_time' => $current_time,
  'formatted_current_time' => $formatted_current_time
];

return $data;
