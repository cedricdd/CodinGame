<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$units = [
    "um" => 0,
    "mm" => 1,
    "cm" => 2,
    "dm" => 3,
    "m" => 4,
    "km" => 5,
];

$factor = [
    "mm" => [1, 1000],
    "cm" => [1, 10, 10000],
    "dm" => [1, 10, 100, 100000],
    "m" => [1, 10, 100, 1000, 1000000],
    "km" => [1, 1000, 10000, 100000, 1000000, 1000000000],
];

preg_match_all("/([0-9\.]+)([umcdk]?m) \+ ([0-9]+)([umcdk]?m)/", stream_get_line(STDIN, 50 + 1, "\n"), $matches);

error_log(var_export($matches, true));

$v1 = $matches[1][0];
$u1 = $matches[2][0];
$v2 = $matches[3][0];
$u2 = $matches[4][0];

if($units[$u1] > $units[$u2]) {
    echo $v2 + ($v1 * $factor[$u1][$units[$u1] - $units[$u2]]) . $u2;
} else {
    echo $v1 + ($v2 * $factor[$u2][$units[$u2] - $units[$u1]]) . $u1;
}
?>
