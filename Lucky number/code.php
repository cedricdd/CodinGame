<?php

$N = strtr(trim(fgets(STDIN)), ["0" => "", "5" => ""]);
$len = strlen($N);

if($len < 2) exit("-1");

$values = [0, 0, 0];

for($i = 0; $i < $len - 1; ++$i) {
    $sum = $N[$i] + $N[$i + 1];

    if($sum > 9) {
        $values[0]++;
        $types[] = [substr($N, $i, 2), "POSITIVE"];
    } elseif($sum == 9) {
        $values[1]++;
        $types[] = [substr($N, $i, 2), "NEUTRAL"];
    } else {
        $values[2]++;
        $types[] = [substr($N, $i, 2), "NEGATIVE"];
    }
}

echo implode(";", array_column($types, 0)) . PHP_EOL;
echo implode(";", array_column($types, 1)) . PHP_EOL;
echo ($values[0] > $values[2] ? "LUCKY" : ($values[0] == $values[2] ? "NEUTRAL" : "UNLUCKY")) . PHP_EOL;
