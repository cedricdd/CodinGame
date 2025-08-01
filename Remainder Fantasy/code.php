<?php

function GCD(int $a, int $b): int {
    return $b ? GCD($b, $a % $b) : $a;
}

function LCM(int $a, int $b): int {
    return $a * $b / GCD($a, $b);
}

$integer = 0;
$step = 1;
$start = microtime(1);

fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $m, $r);

    if($m > $integer) $integer = $m; //Answer can't be less than the bigger modulo

    $list[] = [$m, $r];
}

//We sort by biggest modulo, so the step grows faster
usort($list, function($a, $b) {
    return $b[0] <=> $a[0];
});

foreach($list as [$m, $r]) {
    //Find the next number passing the current condition, incrementing by $step makes sure they still pass all the previous conditions
    while($integer % $m != $r) $integer += $step;

    $step = LCM($step, $m);
}

echo $integer . PHP_EOL;
error_log(microtime(1) - $start);
