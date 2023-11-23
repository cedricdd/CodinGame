<?php

$number = trim(fgets(STDIN));

$binary = "";

//Generate the binary character by character, each hex character makes 4 bits
for($i = 0; $i < strlen($number); ++$i) {
    $binary .= str_pad(base_convert($number[$i], 16, 2), 4, "0", STR_PAD_LEFT);
}

$binary = ltrim($binary, "0"); //The leading zeros are not considered as flipping info

//2 flips of the same type cancel each others, we only need to flip once at most
$occurences = array_map(function($value) {
    return $value % 2;
}, count_chars($binary, 1));

//Horizontal flip
if($occurences[48]) $number = strrev(strtr($number, "123456789abcdef0", "15##2a#8e6d#b9#0"));
//Vertical flip
if($occurences[49]) $number = strtr($number, "123456789abcdef0", "153#2e#8a9#c#6#0");

if(strpos($number, "#") !== false) echo "Not a number" . PHP_EOL;
else echo substr($number, 0, 1000) . PHP_EOL;
