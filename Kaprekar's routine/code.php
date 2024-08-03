<?php

$n = trim(fgets(STDIN));
$count = strlen($n);
$history = [];
$index = 0;

while(true) {
    if(isset($history[$n])) exit(implode(" ", array_keys(array_slice($history, $history[$n], null, true))));
    else $history[$n] = $index++;

    $n = str_split($n);

    sort($n);

    $dn = implode("", array_reverse($n));
    $an = implode("", $n);

    $n = str_pad(strval($dn - $an), $count, '0', STR_PAD_LEFT);
}
