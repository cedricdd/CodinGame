<?php

fscanf(STDIN, "%d %d %d", $n, $m, $p);
fscanf(STDIN, "%d %d", $countA, $countB);

for ($i = 0; $i < $countA; $i++) {
    fscanf(STDIN, "%d %d %f", $y, $x, $value);
    $A[$y][$x] = $value;
}

for ($i = 0; $i < $countB; $i++) {
    fscanf(STDIN, "%d %d %f", $y, $x, $value);
    $B[$y][$x] = $value;
}

$output = [];

foreach($A as $yA => $row) {
    foreach($row as $xA => $valueA) {
        foreach(($B[$xA] ?? []) as $xB => $valueB) {
            $output[$yA][$xB] = ($output[$yA][$xB] ?? 0) + $valueA * $valueB;
        }
    }
}

ksort($output);

foreach($output as $y => $row) {
    ksort($row);

    foreach($row as $x => $value) {
        if($value == 0) continue;

        echo $y . " " . $x . " " . $value . (intval($value) == $value ? ".0" : "") . PHP_EOL;
    }
}
