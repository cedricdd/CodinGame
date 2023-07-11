<?php

$crazylist = array_slice(explode(" ", trim(fgets(STDIN))), -3);

//All the numbers are the same, just re-print the last number
if(count(array_unique($crazylist)) == 1)  echo array_pop($crazylist) . PHP_EOL;
else {
    //We only work with basic operators + - * / => Un+1 = Un * a + b, Un+2 = Un+1 * a + b
    //a = (Un+1 - b) / Un
    //b = Un+2 - Un+1 * a
    //
    //a = (Un+1 - (Un+2 - Un+1 * a)) / Un => a = (Un+1 - Un+2) / (Un - Un+1)

    $z = array_pop($crazylist);
    $y = array_pop($crazylist);
    $x = array_pop($crazylist);

    $a = ($y - $z) / ($x - $y);
    $b = $z - $y * $a;

    echo $z * $a + $b . PHP_EOL;
}
