<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$start = PHP_INT_MAX;
$end = PHP_INT_MIN;

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++)
{
    fscanf(STDIN, "%d %d", $X, $Y[]);

    if($X > $end) $end = $X;
    if($X < $start) $start = $X;
}

//Sort by ascending Y position
sort($Y);

//Calculate the median value
$median = $Y[$N / 2];

//Calculate the length
$length = $end - $start;
foreach($Y as $position) {
    $length += abs($median - $position); 
}

echo($length . "\n");
?>
