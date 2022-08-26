<?php

$ip = stream_get_line(STDIN, 18 + 1, "\n");

preg_match("/([0-9]+)\.([0-9]+)\.([0-9]+)\.([0-9]+)\/([0-9]+)/", $ip, $matches);

$integers = array_slice($matches, 1, 4); //The integers of the ip
$mask = str_repeat(1, $matches[5]) . str_repeat(0, 32 - $matches[5]); //The binary representation of the mask

//The network address
foreach(str_split($mask, 8) as $i => $binary) {
    $network[] =  $integers[$i] & bindec($binary);
}

//The broadcast adress
foreach(str_split(strtr($mask, "01", "10"), 8) as $i => $binary) {
    $broadcast[] =  $network[$i] | bindec($binary);
}

echo implode(".", $network) . PHP_EOL;
echo implode(".", $broadcast) . PHP_EOL;
?>
