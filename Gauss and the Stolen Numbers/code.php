<?php

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $S);
fscanf(STDIN, "%d", $Q);

$sum1 = ($N * ($N + 1)) / 2;                //Sum of 1 to N
$sum2 = ($N * ($N + 1) * (2 * $N + 1)) / 6; //Sum of 1² to N²

/**
 * sum1 = S + x + y
 * sum2 = Q + x² + y²
 * 
 * x = sum1 - S - y => x = A - y with A = sum1 - S
 * x² = sum2 - Q - y² => x² = B - y² with B = sum2 - Q
 * 
 * (A - y)² = B - y²
 * =>
 * A² − 2Ay + y²= B − y²
 * =>
 * 2y² − 2Ay + (A²−B) = 0
 * =>
 * y² - Ay + C = 0 with C = (A² - B) / 2
 * => use quadratic formula
 * y = (A ± sqrt(A² - 4C)) / 2
 */
$A = $sum1 - $S;
$B = $sum2 - $Q;
$C = ($A * $A - $B) / 2;
$y = ($A + sqrt($A * $A - 4 * $C)) / 2;
$x = $sum1 - $S - $y;

echo("$x $y");
