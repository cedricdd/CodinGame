<?php

const COUNTS1 = ['0' => 0, '1' => 1, '2' => 1, '3' => 2,'4' => 1, '5' => 2, '6' => 2, '7' => 3, '8' => 1, '9' => 2, 'a' => 2, 'b' => 3, 'c' => 2, 'd' => 3, 'e' => 3, 'f' => 4];
const LEADING_ZEROS = ['0' => 4, '1' => 3, '2' => 2, '3' => 2, '4' => 1, '5' => 1, '6' => 1, '7' => 1, '8' => 0, '9' => 0, 'a' => 0, 'b' => 0, 'c' => 0, 'd' => 0, 'e' => 0, 'f' => 0];

$number = trim(fgets(STDIN));
$count1 = 0;


//Get the number of bits set to 1 in the binary form
foreach(str_split($number) as $character) $count1 += COUNTS1[$character];

$index = 0;
$count0 = strlen($number) * 4 - $count1;

//Remove all the leading zero
do {
    $leading = LEADING_ZEROS[$number[$index++]];
    $count0 -= $leading;
} while($leading == 4);

//Two flips (horizontal or vertical) cancel each others so at max we only need to make one of each flip type

//Horizontal flip
if($count0 % 2) $number = strrev(strtr($number, "123456789abcdef0", "15##2a#8e6d#b9#0"));
//Vertical flip
if($count1 % 2) $number = strtr($number, "123456789abcdef0", "153#2e#8a9#c#6#0");

if(strpos($number, "#") !== false) echo "Not a number" . PHP_EOL;
else echo substr($number, 0, 1000) . PHP_EOL;
