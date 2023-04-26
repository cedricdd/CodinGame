<?php

function GCD(int $a, int $b): int {
    return $b ? GCD($b, $a % $b) : $a;
}

function LCM(int $a, int $b): int {
    return $a * $b / GCD($a, $b);
}

$name1 = trim(fgets(STDIN));
$name2 = trim(fgets(STDIN));

$l1 = strlen($name1);
$l2 = strlen($name2);
$LCM = LCM($l1, $l2);

$answer = array_fill(0, $LCM + 2, str_repeat(" ", $LCM));

for($i = 0; $i < $LCM; ++$i) {
    $answer[0][$i] = $name1[$i % $l1];
    $answer[$i + 1][$LCM - 1] = $name1[$i % $l1];

    $answer[$i + 1][0] = $name2[$i % $l2];
    $answer[$LCM + 1][$i] = $name2[$i % $l2];
}

echo implode("\n", $answer) . PHP_EOL;
