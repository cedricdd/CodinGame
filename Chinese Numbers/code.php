<?php

const NUMBERS = [
    "*000*0***00***00***0*000*" => 0,
    "**********00000**********" => 1,
    "00000***************00000" => 2,
    "00000******000******00000" => 3,
    "000000*0*000*000***000000" => 4,
    "00000**0***0000**0*000000" => 5,
    "**0****0**00000*0*0*0***0" => 6,
    "**0****0**00000**0****000" => 7,
    "*0*0**0*0**0*0**0*0*0***0" => 8,
    "**0****0**0000**0*0*0**00" => 9,
];

for ($i = 0; $i < 5; $i++) {
    foreach(explode(' ', trim(fgets(STDIN))) as $x => $string) {
        if($i == 0) $characters[$x] = $string;
        else $characters[$x] .= $string;
    }
}

echo implode("", array_map(function($character) { return NUMBERS[$character]; }, $characters)) . PHP_EOL;
