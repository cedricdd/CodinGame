<?php

fscanf(STDIN, "%d", $count);

$sum = 0;

foreach(explode(" ", trim(fgets(STDIN))) as $value) {
    foreach(str_split(strrev($value)) as $i => $d) {
        $sum += ($d == 'A' ? 10 : $d) * pow(10, $i);
    }
}

$output = '';

while($sum > 0) {
    $mod = $sum % 10;
    $output = ($mod == 0 ? 'A' : $mod) . $output;
    $sum -= ($mod == 0 ? 10 : $mod);
    $sum /= 10;
}

echo $output . PHP_EOL;
