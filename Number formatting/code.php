<?php

$float = preg_replace("/x|,|\.(?=[0-9x]{3}$)/", "", trim(fgets(STDIN))) . "0";
$exploded = explode(".", number_format($float / 2, 6, ".", ""));

$before = implode(",", str_split(str_pad(ltrim($exploded[0], "0"), 9, "x", STR_PAD_LEFT), 3));
$after = implode(".", str_split(str_pad(rtrim($exploded[1], "0"), 6, "x", STR_PAD_RIGHT), 3));

echo $before . "." . $after . PHP_EOL;
