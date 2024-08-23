<?php

const CONV = ['0' => '000', '1' => '001', '2' => '010', '3' => '011', '4' => '100', '5' => '101', '6' => '110', '7' => '111'];

fscanf(STDIN, "%d %d", $width, $height);
$bitstream = trim(fgets(STDIN));
for ($i = 0; $i < $height; $i++) {
    $input[] = trim(fgets(STDIN));
}

if($bitstream == 0) exit(implode("\n", $input)); //We have nothing to do

//Convert octal to binary
$binary = "";

foreach(str_split($bitstream) as $d) $binary .= CONV[$d];

//We don't care about the real values, all we need to know is if the total number of tumbles is odd or even
$a = 1;
$b = 1;
$t = 0;

foreach(str_split(strrev($binary)) as $i => $d) {
    //Affecting B
    if($i & 1) {
        if($d == '1') $t ^= $b;
        $a ^= $b;
    } //Affecting A
    else {
        if($d == '1') $t ^= $a;
        $b ^= $a;
    }
}

//Tumble are repetive, we just need to know if it's odd or even
if($t & 1) $output = array_fill(0, $width, str_repeat(".", $height));
else       $output = array_fill(0, $height, str_repeat(".", $width));

for($y = 0; $y < $height; ++$y) {
    $count = substr_count($input[$y], '#');

    for($i = 0; $i < $count; ++$i) {
        if($t & 1) $output[$width - 1 - $i][$y] = '#';
        else       $output[$y][$width - 1 - $i] = '#';
    }
}

echo implode("\n", $output) . PHP_EOL;
