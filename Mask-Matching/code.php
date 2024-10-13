<?php

function explore(string $binary, int $index, array &$list) {
    $size = strlen($binary);

    if($index == $size) {
        $decimal = bindec($binary);

        if($decimal != 0) $list[] = $decimal; //We just want to filter out 0

        return;
    }

    //We can switch that bit to 0
    if($binary[$index] == "1") {
        $binary2 = $binary;
        $binary2[$index] = "0";

        explore($binary2, $index + 1, $list);
    }
    
    explore($binary, $index + 1, $list); //We keep the bit as it is
}

$mask = base_convert(trim(fgets(STDIN)), 16, 2);
$listIntegers = [];

explore($mask, 0, $listIntegers);

if(count($listIntegers) <= 15) echo implode(",", $listIntegers) . PHP_EOL;
else echo implode(",", array_slice($listIntegers, 0, 13)) . ",...," . implode(",", array_slice($listIntegers, -2)) . PHP_EOL;
