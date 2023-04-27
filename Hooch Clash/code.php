<?php

function getVolume(int $diameter): float {
    return (4/3) * pi() * ($diameter / 2) ** 3;
}

function getDiameter(float $volume): float {
    return number_format(($volume / ((4/3) * pi())) ** (1/3) * 2, 6, ".", "");
}

fscanf(STDIN, "%d %d", $orbSizeMin, $orbSizeMax);
fscanf(STDIN, "%d %d", $glowingSize1, $glowingSize2);

$volumeKing = getVolume($glowingSize1) + getVolume($glowingSize2);

for($i = $orbSizeMin; $i < $orbSizeMax; ++$i) {
    $volume = $volumeKing - getVolume($i);

    if($volume <= 0) break;

    $d = getDiameter($volume);

    if($d < $orbSizeMin) break;
    if($d > $orbSizeMax) continue;

    if($d == intval($d)) {
        $d = intval($d);
        $possibilities[] = [min($d, $i), max($d, $i), abs($i - $d)];
    }

    $orbSizeMax = $d;
}

//Sort by the difference between the diameters of the orbs
usort($possibilities, function($a, $b) {
    return $b[2] <=> $a[2];
});

foreach($possibilities as [$s1, $s2, ]) {
    if($s1 != $glowingSize1 && $s1 != $glowingSize2 && $s2 != $glowingSize1 && $s2 != $glowingSize2) exit("$s1 $s2");
}

echo "VALID" . PHP_EOL;
