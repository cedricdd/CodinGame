<?php

function getOffset(string $offset): int {
    return (intval(substr($offset, 1, 2)) * 60 + intval(substr($offset, 3))) * ($offset[0] == "-" ? -1 : 1);
}

function getTime(int $offset): string {
    return str_pad(intdiv($offset, 60), 2, '0', STR_PAD_LEFT) . str_pad($offset % 60, 2, '0', STR_PAD_LEFT);
}

fscanf(STDIN, "%s %s", $offset1, $offset2);

//Convert the offset to minutes difference
$offset1 = getOffset($offset1);
$offset2 = getOffset($offset2);

//Make sure both values are positive
while($offset1 < 0 || $offset2 < 0) {
    $min = abs(min($offset1, $offset2));
    $offset1 += $min;
    $offset2 += $min;
}

$match = [];

//We just test the 1440 possible times during the day
for($i = 0; $i < 1440; ++$i) {
    $t1 = getTime(($offset1 + $i) % 1440);
    $t2 = getTime(($offset2 + $i) % 1440);

    if(count_chars($t1) === count_chars($t2)) $match[] = [$t1, $t2];
}

sort($match);

echo count($match) . PHP_EOL;
echo implode(PHP_EOL, array_map(function($m) {
    return implode(", ", $m);
}, $match)) . PHP_EOL;
