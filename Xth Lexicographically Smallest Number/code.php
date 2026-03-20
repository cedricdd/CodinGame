<?php

function solve(array $base, int $index, string $number, int $x) {
    global $b, $s1, $s2, $m, $n;

    for($i = ($index ? 0 : 1); $i < $b; ++$i) {
        $prefix = base_convert($number . $base[$i], $b, 10);

        error_log("prefix $prefix");

        $l = strlen($prefix);

        for($s = $s1; $s <= $s2; ++$s) {
            $v = $b ** ($s - $l);

            $min = $prefix * $v;
            $max = ($prefix + 1) * $v - 1;

            if($max < $m  || $min > $n) $intersect = 0;
            else $intersect = min($n, $max) - max($m, $min) + 1;

            error_log("size $s - $min $max -- $intersect -- left $x");

            if($intersect < $x) $x -= $intersect;
            else {
                echo $min + $x . PHP_EOL;
                die();
            }
        }
    }
}

fscanf(STDIN, "%d %d %d %d", $m, $n, $b, $x);

$base = str_split(substr('0123456789abcdefghijklmnopqrstuvwxyz', 0, $b));
$s1 = strlen(base_convert($m, 10, $b));
$s2 = strlen(base_convert($n, 10, $b));

error_log(var_export($base, 1));

solve($base, 0, "", $x);
