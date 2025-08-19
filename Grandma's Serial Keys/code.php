<?php

function format(int $v): string {
    return strtoupper(str_pad(dechex($v), 4, '0', STR_PAD_LEFT));
}

$username = stream_get_line(STDIN, 1000 + 1, "\n");

$seed = (array_sum(array_map('ord', str_split($username))) * strlen($username)) ^ 20480;

$p1 = $seed & 65535;
$p2 = $seed >> 16;
$p3 = (ord($username[0]) + ord($username[-1])) * strlen($username);
$p4 = ($p1 + $p2 + $p3) % 65536;

echo format($p1) . '-' . format($p2) . '-' . format($p3) . '-' . format($p4) . PHP_EOL;
