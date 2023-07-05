<?php

$N = trim(fgets(STDIN));

$sum = array_sum(str_split($N)); //The sum of the given number

$nonZeroFound = false;

//We want the number to be the smallest so we find the first position starting from the end where we can increase the value of the digit by 1
for($i = strlen($N) - 1; $i >= 0; --$i) {
    if($nonZeroFound) {
        if($N[$i] != 9) break;
    } //We need at last 1 non zero digit at the right to compensate the 1 we're adding
    else {
        if($N[$i] != 0) $nonZeroFound = true;
    }
}

//What's on the left doesn't change, we increase by one at the position and just 0s at the right
$N = substr($N, 0, max($i, 0)) . strval(($i == -1 ? 0 : $N[$i]) + 1) . str_repeat("0", strlen($N) - $i - 1);

$i = strlen($N) - 1;
$sum -= array_sum(str_split($N)); //The amount missing to have the same sum as input number

//Starting from the end we add what's missing to reach the sum
while($sum) {
    $value = min($sum, 9); 

    $N[$i--] = $value;
    $sum -= $value;
}

echo $N . PHP_EOL;
