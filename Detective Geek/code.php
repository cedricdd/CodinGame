<?php

$months = ["jan" => 0, "feb" => 1, "mar" => 2, "apr" => 3, "may" => 4, "jun" => 5,
            "jul" => 6, "aug" => 7, "sep" => 8, "oct" => 9, "nov" => "A", "dec" => "B"];

$time = str_pad(bindec(strtr(trim(fgets(STDIN)), ["#" => 1, "*" => 0])), 4, '0', STR_PAD_LEFT);

$address = "";

foreach(explode(" ", trim(fgets(STDIN))) as $input) {
    $address .= chr(base_convert($months[substr($input, 0, 3)] . $months[substr($input, 3)], 12, 10));
}

echo substr($time, 0, 2) . ":" . substr($time, 2) . PHP_EOL . $address . PHP_EOL;
