<?php

$A = trim(fgets(STDIN));

$size = strlen($A);
$s = $size; //Every pairs where the starting and ending position is the same will be similar

for($i = 0; $i < $size - 1; ++$i) {
    for($j = $i + 1; $j < $size; ++$j) {
        //We just need to check if previous is <= to know if it's sorted, if it isn't anything after will also not be
        if($A[$j - 1] <= $A[$j]) ++$s;
        else continue 2;
    }

}

echo $s . PHP_EOL;
