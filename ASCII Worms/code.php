<?php

fscanf(STDIN, "%d", $thickness);
fscanf(STDIN, "%d", $length);
fscanf(STDIN, "%d", $turns);

$w = ($thickness + 1) * ($turns + 1) + 1;
$h = $length + 1;
$cols = 0;
$output = array_fill(0, $h, str_repeat(" ", $w));

for($i = 0; $i < $w; ++$i) {
    if($i != 0 && $i != $w - 1) $output[0][$i] = "_";
    $output[$h - 1][$i] = "_";

    if($i % ($thickness + 1) == 0) {
        if($i == 0 || $i == $w - 1) {
            for($y = 1; $y < $h; ++$y) $output[$y][$i] = "|";
        }
        elseif($cols & 1) {
            $output[0][$i] = " ";
            for($y = 1; $y < $h - 1; ++$y) $output[$y][$i] = "|";
        } else {
            for($y = 2; $y < $h; ++$y) $output[$y][$i] = "|";
        }

        ++$cols;
    }
}

echo implode("\n", array_map("rtrim", $output)) . PHP_EOL;
