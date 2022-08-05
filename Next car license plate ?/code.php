<?php
$a = range('A', 'Z');
$ar = array_flip($a); 

$plate = stream_get_line(STDIN, 9 + 1, "\n");

list($left, $center, $right) = explode("-", $plate);

$center += intval(fgets(STDIN));

$value = $ar[$right[1]] + ($ar[$right[0]] * 26) + ($ar[$left[1]] * 26 ** 2) + ($ar[$left[0]] * 26 ** 3);

if($center > 999) {
    $value += intdiv($center, 999);
    $center = $center % 999;
}

$q = intdiv($value, 26 ** 3);
$left[0] = $a[$q];
$value -= $q * 26 ** 3;

$q = intdiv($value, 26 ** 2);
$left[1] = $a[$q];
$value -= $q * 26 ** 2;

$q = intdiv($value, 26);
$right[0] = $a[$q];
$value -= $q * 26;

$right[1] = $a[$value];

echo $left . "-" . str_pad($center, 3, '0', STR_PAD_LEFT) . "-" . $right;
?>
