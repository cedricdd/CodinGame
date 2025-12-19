<?php

fscanf(STDIN, "%d %d", $a, $b);
fscanf(STDIN, "%d %d", $c, $d);

$max = max($a, $b, $c, $d);
$min = min($a, $b, $c, $d);
$result = 0;


if($a == $min) {
    if($b != $max) {
        $e = min($max - $b, $max - $a);
        $b += $e;
        $a += $e;
    }
    if($c != $max) {
        $e = min($max - $c, $max - $a);
        $c += $e;
        $a += $e;
    }
} elseif($b == $min) {
    if($a != $max) {
        $e = min($max - $a, $max - $b);
        $a += $e;
        $b += $e;
    }
    if($d != $max) {
        $e = min($max - $d, $max - $b);
        $d += $e;
        $b += $e;
    }
} elseif($c == $min) {
    if($a != $max) {
        $e = min($max - $a, $max - $c);
        $a += $e;
        $c += $e;
    }
    if($d != $max) {
        $e = min($max - $d, $max - $c);
        $d += $e;
        $c += $e;
    }
} 
elseif($d == $min) {
    if($b != $max) {
        $e = min($max - $b, $max - $d);
        $b += $e;
        $d += $e;
    }
    if($c != $max) {
        $e = min($max - $c, $max - $d);
        $c += $e;
        $d += $e;
    }
}

$max = max($a, $b, $c, $d);
$min = min($a, $b, $c, $d);

if($a == $max && $d == $max && abs($b - $c) > 1) {
    echo $max + ceil(abs($b - $c) / 2) - max($b, $c) . PHP_EOL;
} elseif($b == $max && $c == $max && abs($a - $d) > 1) {
    echo $max + ceil(abs($a - $d) / 2) - max($a, $d) . PHP_EOL;
} else echo $max - $min . PHP_EOL;
