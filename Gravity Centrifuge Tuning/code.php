<?php

const CONV = ['000' => '0', '001' => '1', '010' => '2', '011' => '3', '100' => '4', '101' => '5', '110' => '6', '111' => '7'];

$start = microtime(1);

$N = strval(stream_get_line(STDIN, 10000 + 1, "\n"));

if($N == 0) exit("0");

$index = 1;
$v = ['1', '2'];

//Get the number of possible tumbles on each turn
while(bccomp($N, $v[$index]) > 0) {
    $v[] = bcadd($v[$index], $v[$index - 1]);

    ++$index;
}

$binary = "";

//Each time the number of tumbles left if greater than the number of possible tumble at that turn we set the bit to 1
while($index >= 0) {
    if(bccomp($N, $v[$index]) >= 0) {
        $binary .= "1";
        $N = bcsub($N, $v[$index]);
    } else $binary .= "0";

    --$index;
}

while(strlen($binary) % 3 != 0) $binary = '0' . $binary;

$octal = "";

//We can convert to octal 3 bits at a time
$l = strlen($binary);
for($i = 0; $i < $l; $i += 3) {
    $octal .= CONV[$binary[$i] . $binary[$i + 1] . $binary[$i + 2]];
}

echo ltrim($octal, '0') . PHP_EOL;

error_log(microtime(1) - $start);
