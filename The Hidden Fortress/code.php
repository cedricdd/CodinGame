<?php

$start = microtime(1);

$counts = array_flip(str_split("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"));

fscanf(STDIN, "%d", $size);

$colSums = array_fill(0, $size, 0);
$rowSums = array_fill(0, $size, 0);

for ($y = 0; $y < $size; ++$y) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        $index = $y * $size + $x;

        $map[$y][$x] = $counts[$c];
        $colSums[$x] += $counts[$c];
        $rowSums[$y] += $counts[$c];
    }
}

/**
 * Each fortress will increase the counts of each cells in row ($size) and each cells in the col ($size) with one cell in common so $size * 2 - 1
 * If we divide the total sum by $size * 2 - 1 we will get the number of fortresses
 */
$nbrFortress = array_sum($colSums) / ($size * 2 - 1);

//Every fortress will add one to the sum of the col via the rows and each fortress in the col will add an additional $size - 1
foreach($colSums as $sum) $cols[] = ($sum - $nbrFortress) / ($size - 1);

//Every fortress will add one to the sum of the row via the cols and each fortress in the row will add an additional $size - 1
foreach($rowSums as $sum) $rows[] = ($sum - $nbrFortress) / ($size - 1);

/**
 * A fortress at a given cell will appear in the number of fortresses for the column & the row so if we sum them it would then be counted twice.
 * In the input we are given if there's a fortress in the current cell it's only counted once.
 * If the sum of the number of fortresses in the row & the col is the same as the input for this cell it means there's no fortress in the current cell.
 */
for($y = 0; $y < $size; ++$y) {
    for($x = 0; $x < $size; ++$x) {
        if($map[$y][$x] == $cols[$x] + $rows[$y]) $map[$y][$x] = ".";
        else $map[$y][$x] = "O";
    }
}

echo implode(PHP_EOL, array_map("implode", $map)) . PHP_EOL;

error_log(microtime(1) - $start);
