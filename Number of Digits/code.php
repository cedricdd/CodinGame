<?php

fscanf(STDIN, "%s", $n);
fscanf(STDIN, "%d", $k);

$size = strlen($n);
$count = 0;
$total = [0];

//We calculate how many times any digits appears in all the integers of size $i
for($i = 1; $i < $size; ++$i) $total[$i] = 10 * $total[$i - 1] + 10 ** ($i - 1);

for($i = 0; $i < $size; ++$i) {
    //Add how many times k can appear after $i position
    $count += $n[$i] * $total[$size - $i - 1];

    //Add how many times k can appear in $i position
    if($n[$i] == $k) $count += intval(substr($n, $i + 1)) + 1; //in kxxx, k is the first digit for every numbers form 0 to xxx
    if($n[$i] > $k)  $count += 10 ** ($size - $i - 1); //the digit is bigger than k which means that k was the first digit of every possible numbers
}

echo $count . PHP_EOL;
