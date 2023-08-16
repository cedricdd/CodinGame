<?php

const ONE = [1, 1];
const ZERO = [0, 0];


function GCD(int $a, int $b): int {
    return $b ? GCD($b, $a % $b) : $a;
}

function LCM(int $a, int $b): int {
    return $a * $b / GCD($a, $b);
}


function addFractions(array $a, array $b): array {
    $divisor = LCM($a[1], $b[1]);
    $dividend = ($a[0] * ($divisor / $a[1])) + ($b[0] * ($divisor / $b[1]));

    return simplifyFractions($dividend, $divisor);
}

function divFractions(array $a, array $b): array {
    return simplifyFractions($a[0] * $b[1], $a[1] * $b[0]);
}

function mulFractions(array $a, array $b): array {
    return simplifyFractions($a[0] * $b[0], $a[1] * $b[1]);
}

function subFractions(array $a, array $b): array {
    $divisor = LCM($a[1], $b[1]);
    $dividend = ($a[0] * ($divisor / $a[1])) - ($b[0] * ($divisor / $b[1]));

    return simplifyFractions($dividend, $divisor);
}


function simplifyFractions(int $a, int $b): array {
    if($a == 0 || $b == 0) return [0, 0];

    $gcd = GCD($a, $b);

    return [$a / $gcd, $b / $gcd];
}


function getProbabily(int $N, int $W, int $S, int $K): array {
    static $history = [];

    //Use the history
    if(isset($history[$N][$W][$S][$K])) return $history[$N][$W][$S][$K];

    //We can't pick enough white balls anymore or we already have too many
    if($K > $S || $K < 0) return ZERO;

    //We have picked all the balls
    if($S == 0) return ($K == 0) ? ONE : ZERO;

    //We get a black ball
    $black = mulFractions(getProbabily($N - 1, $W, $S - 1, $K), [$N - $W, $N]);

    //We get a white ball
    $white = mulFractions(getProbabily($N - 1, $W - 1, $S - 1, $K - 1), [$W, $N]);

    if($black == ZERO) $result = $white; //We have to pick a white ball
    elseif($white == ZERO) $result = $black; //We have to pick a black ball
    else $result = addFractions($white, $black); //We can pick either

    return $history[$N][$W][$S][$K] = $result;
}

$start = microtime(1);

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $W);
fscanf(STDIN, "%d", $S);
fscanf(STDIN, "%d", $K);

$probability = getProbabily($N, $W, $S, $K);

if($probability == ONE) echo "1:0" . PHP_EOL;
else echo implode(":", divFractions($probability, subFractions([1, 1], $probability))) . PHP_EOL;

error_log(microtime(1) - $start);
