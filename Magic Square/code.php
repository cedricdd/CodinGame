<?php

fscanf(STDIN, "%d", $n);

$rows = array_fill(0, $n, 0);
$columns = array_fill(0, $n, 0);
$diagonals = array_fill(0, 2, 0);
$numbers = array_fill(1, $n*$n, 1);
define("SUM", $n * ($n*$n + 1) / 2);

for ($y = 0; $y < $n; ++$y) {
    foreach(explode(" ", trim(fgets(STDIN))) as $x => $v) {
        $rows[$y] += $v;
        $columns[$x] += $v;
        if($y == $x) $diagonals[0] += $v;
        if($x == ($n - 1) - $y) $diagonals[1] += $v;
    }
}

//Check if any row, column or diagonal doesn't have the right sum
$invalid = array_filter(array_merge($columns, $rows, $diagonals), function ($value) { 
    return $value != SUM; 
});

echo (count($invalid)) ? "MUGGLE\n" : "MAGIC\n";
?>
