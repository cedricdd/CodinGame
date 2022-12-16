<?php

fscanf(STDIN, "%d", $level);
fscanf(STDIN, "%d", $xp);
fscanf(STDIN, "%d", $N);

$xpGained = $N * 300;

while(true) {
    if($xp <= $xpGained) {
        ++$level;
        $xpGained -= $xp;
        $xp = floor($level * sqrt($level) * 10);
    } else {
        $xp -= $xpGained;
        break;
    }
}

echo $level . PHP_EOL . $xp . PHP_EOL;
