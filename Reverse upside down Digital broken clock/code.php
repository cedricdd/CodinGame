<?php

$readableText = trim(fgets(STDIN));

$converted = strtr($readableText, ['O' => '0', 'i' => '1', 'E' => '3', 'h' => '4', 'S' => '5', '9' => '6', 'L' => '7', '6' => '9']);
$reversed = strrev($converted);

[$hours, $minutes] = explode(":", $reversed);

if($hours > 24) echo "Error $hours hours" . PHP_EOL;
if($minutes > 59) echo "Error $minutes minutes" . PHP_EOL;
if($hours < 25 && $minutes < 60) echo $reversed . PHP_EOL;
