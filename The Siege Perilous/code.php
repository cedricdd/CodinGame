<?php

fscanf(STDIN, "%d", $k);
for ($i = 0; $i < $k; $i++) {
    $knights[] = stream_get_line(STDIN, 100 + 1, "\n");
}

$gk = stream_get_line(STDIN, 100 + 1, "\n");

fscanf(STDIN, "%d", $sp);
fscanf(STDIN, "%d", $shift);

$table = [];
$index = 0;

//Initial positions
foreach($knights as $knight) {
    if($index == $sp - 1 && $knight != $gk) ++$index;
    
    $table[$index++] = $knight;
}

for($i = $k + 1; $i > 0; --$i) {
    $newTable = [];
    $gameOver = false;

    foreach($table as $index => $knight) {
        $newIndex = ($index + $shift) % ($k + 1);

        if($newIndex == $sp - 1) {
            if($knight != $gk) continue;
            else $gameOver = true;
        }

        $newTable[$newIndex] = $knight;
    }

    if(count($newTable) == 0) exit("None");

    $table = $newTable;

    if($gameOver) break;
}

ksort($table);

echo implode(PHP_EOL, $table) . PHP_EOL;
