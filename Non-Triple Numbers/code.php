<?php

fscanf(STDIN, "%d", $n);

$binary = decbin($n + 1); //The first possible number

//We have a triple 1 
while(preg_match("/111/", $binary, $match, PREG_OFFSET_CAPTURE)) {
    //111xxx => 1xxxxxx || xxx111x => xxx1000
    //The first one is moved left and everything after is set to 0
    if($match[0][1] == 0) $binary = "1" . str_repeat('0', strlen($binary));
    else $binary = substr($binary, 0, $match[0][1] - 1) . "1" . str_repeat('0', strlen($binary) - $match[0][1]);
}

//We have a triple 0
if(preg_match("/000/", $binary, $match, PREG_OFFSET_CAPTURE)) {
    $count = strlen($binary) - $match[0][1];

    //xx000xxx => xx001001 || xxx000000 => xxx001001
    //We replace every bits up to the end starting at the start of the triple with the pattern 001
    for($i = 0; $i < $count; ++$i) {
        if($i % 3 == 2) $binary[$i + $match[0][1]] = "1";
        else $binary[$i + $match[0][1]] = "0";
    }
}

echo bindec($binary) . PHP_EOL;
