<?php

fscanf(STDIN, "%d", $w);
fscanf(STDIN, "%d", $h);
fscanf(STDIN, "%d", $d);

$cube = array_fill(0, $h + $d + 1, array_fill(0, $d + $w * 2 + $h, " "));

for($i = 0; $i < $w * 2; ++$i) $cube[$h][$d + $h + $i] = '.';

for($i = 0; $i < $w * 2; ++$i) $cube[0][$d + $i] = '_';
for($i = 1; $i < $w * 2; ++$i) $cube[$d][$i] = '_';
for($i = 1; $i <= ($w - 1) * 2; ++$i) $cube[$h + $d][$h + $i] = '_';

for($i = 0; $i < $h; ++$i) $cube[$i + 1][$d + $i] = "⠡";
for($i = 0; $i < $d; ++$i) $cube[$h + $d - $i][$h + $i] = "⠌";

if($w == 1) {
    $cube[$h + $d][$h] = '_';
    $cube[1][$d] = ' ';
}

if($h == 1) $cube[$h + $d][1] = '_';

if($d == 1) {
    $cube[1][1] = '_';
    $cube[$h][$d + $w * 2 + $h - 2] = ' ';
}

for($i = 0; $i < $h; ++$i) {
    $cube[$i + 1][$d + $w * 2 + $i] = "\\";
    $cube[$i + $d + 1][$i] = "\\";
    $cube[$i + $d + 1][$i + $w * 2] = "\\";
}

for($i = 0; $i < $d; ++$i) {
    $cube[$d - $i][$i] = "/";
    $cube[$d - $i][$w * 2 + $i] = "/";
    $cube[$d - $i + $h][$w * 2 + $h + $i] = "/";
}

echo implode(PHP_EOL, array_map(function($line) {
    return rtrim(implode($line));
}, $cube)) . PHP_EOL;
