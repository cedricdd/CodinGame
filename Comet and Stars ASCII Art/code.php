<?php

function pad2($string): string {
    return str_pad($string, 2, " ", STR_PAD_LEFT);
}

fscanf(STDIN, "%d %d", $C, $D);
fscanf(STDIN, "%d", $N);

$min = min($C, $D);
$max = max($C, $D);

foreach(range($min, $max) as $i) {
    $output[$i] = ".";
}

$output[$C] = "C";

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d", $star);

    if($star >= $min && $star <= $max) $output[$star] = "*";
}

echo implode(" ", array_map("pad2", array_keys($output))) . PHP_EOL;
echo implode(" ", array_map("pad2", $output)) . PHP_EOL;
