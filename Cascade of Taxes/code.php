<?php

// $w: Your lottery Winnings.
fscanf(STDIN, "%d", $w);
// $t: Tax rate.
fscanf(STDIN, "%f", $t);
// $f: Number of friends.
fscanf(STDIN, "%d", $f);
// $s: Rate of Shares to friends.
fscanf(STDIN, "%f", $s);
// $l: Number of Levels.
fscanf(STDIN, "%d", $l);
// $g: Minimum Gift amount.
fscanf(STDIN, "%d", $g);

$tax = 0;
$count = 1;

for($i = 0; $i <= $l; ++$i) {

    $tax += $w * $t * $count; //The tax for each donations on this level

    if($w < $g) break; //Donation is too smal to continue

    $w *= (1 - $t) * $s; //The amount of the next level of donation

    $count *= $f; //The amount of people getting the next level of donation
}

echo "The total taxes paid are: " . $tax . "." . PHP_EOL;
