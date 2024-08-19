<?php

function toSeconds(string $time): int {
    $seconds = 0;

    foreach(array_reverse(explode(":", $time)) as $i => $v) {
        $seconds += $v * (60 ** $i);
    }

    return $seconds;
}

function toTime(int $seconds): string {
    $time = [];

    for($i = 2; $i >= 0; --$i) {
        $amount = 60 ** $i;
        $count = intdiv($seconds, $amount);
        $seconds -= $count * $amount;
        $time[] = str_pad($count, 2, '0', STR_PAD_LEFT);
    }

    if($time[0] == "00") unset($time[0]);

    return implode(":", $time);
}

$ft = toSeconds(trim(fgets(STDIN)));
$et = toSeconds(trim(fgets(STDIN)));
$ln = trim(fgets(STDIN));

$ln1 = floor(($et / $ft) * $ln);
$ln2 = $ln - $ln1;

echo toTime($et) . "  " . str_repeat("|", $ln1) . str_repeat("-", $ln2) . "  -" . toTime($ft - $et) . PHP_EOL;
