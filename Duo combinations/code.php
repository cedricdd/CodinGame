<?php

fscanf(STDIN, "%d", $total);
for ($i = 0; $i < $total; $i++) {
    $symbols[] = trim(fgets(STDIN));
}

for($i = 0; $i < 2 ** $total; ++$i) $binaryList[] = str_pad(decbin($i), $total, "0", STR_PAD_LEFT); //Generate all the numbers in binary

for($i = 0; $i < count($symbols) - 1; ++$i) {
    $match = [0 => $symbols[$i], 1 => $symbols[$i + 1]]; //We just have to replace the 0 & 1 with the symbols

    foreach($binaryList as $binary) $results[strtr($binary, $match)] = 1; //We don't want the same result multiple times
}

echo implode("\n", array_keys($results)) . PHP_EOL;
