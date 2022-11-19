<?php
fscanf(STDIN, "%d", $n);

$sum = 0;

//1 is a divisor of each numbers
//2 is a divisor of each 2th numbers
//3 is a divisor of each 3th numbers
//X will be a divisor of floor(N/X) numbers
for($i = 1; $i <= $n; ++$i) {
    $sum += intdiv($n, $i) * $i;
}

echo $sum . PHP_EOL;
