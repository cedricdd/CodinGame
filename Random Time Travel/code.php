<?php
//https://www.geeksforgeeks.org/multiplicative-inverse-under-modulo-m/
function modInverse($a, $m) {
    $m0 = $m;
    $y = 0;
    $x = 1;
 
    if ($m == 1)
    return 0;
 
    while ($a > 1)
    {
         
        // q is quotient
        $q = (int) ($a / $m);
        $t = $m;
 
        // m is remainder now,
        // process same as
        // Euclid's algo
        $m = $a % $m;
        $a = $t;
        $t = $y;
 
        // Update y and x
        $y = $x - $q * $y;
        $x = $t;
    }
 
    // Make x positive
    if ($x < 0)
    $x += $m0;
 
    return $x;
}

fscanf(STDIN, "%d %d %d", $a, $c, $m);
fscanf(STDIN, "%d", $seed);
fscanf(STDIN, "%d", $steps);

error_log(var_export($a . " " . $c . " " . $m, true));
error_log(var_export($seed, true));
error_log(var_export($steps, true));

//We consider that the LCG period is full, every $m the values will start to reapeat
//Find the lowest steps to find the value we want whitout timing out
$s1 = bcmod($steps, $m);

//Get the number of steps in the opposite direction
$s2 = ($s1 > 0) ? bcsub($s1, $m) : bcadd($s1, $m);

if(abs($s1) < abs($s2)) $steps = $s1;
else $steps = $s2;

/*
 * https://www.nayuki.io/page/fast-skipping-in-a-linear-congruential-generator
 * Backward iteration
 * a-1 is the multiplicative inverse of a
 * a => (a−1 mod m)
 * c => (−(a−1 * c) mod m)
 */

if($steps < 0) {
    $inverse = modInverse($a, $m);
    $a = $inverse;
    $c = bcmul($inverse, bcmul($c, -1));
    $steps = bcmul($steps, -1);
}                                                                                

/*
 * https://www.nayuki.io/page/fast-skipping-in-a-linear-congruential-generator
 * Fast skipping
 * xn = [( (a^n * x0) mod m) + ( ( ( (a^n −1) mod ((a−1) * m) ) / a−1) * b)] mod m.
 */

 
//a^n might be very high, we use the fact that (x * y) mod z = ((x mod z) * y) mod z
$t1 = 1;
for($i = 0; $i < $steps; ++$i) {
    $t1 = bcmul($t1, $a); 
    $t1 = bcmod($t1, $m);
} //a^n mod m

$t2 = bcmul($t1, $seed); //a^n * x0
$t3 = bcmod($t2, $m);    //(a^n * x0) mod m

$t4 = bcmul($m, bcsub($a, 1)); // m (a - 1)

$t5 = 1;
for($i = 0; $i < $steps; ++$i) {
    $t5 = bcmul($t5, $a); 
    $t5 = bcmod($t5, $t4);
} //a^n mod (m (a - 1))

$t6 = bcdiv($t5, bcsub($a, 1)); //( (a^n −1) mod ((a−1) * m) ) / a−1
$t7 = bcmul($t6, $c); // ( ( ( (a^n −1) mod ((a−1) * m) ) / a−1) * b

$t8 = bcadd($t3, $t7);
$t9 = bcmod($t8, $m);

//Make sure seed is always > 0
$t10 = bcmod(bcadd($t9, $m), $m);

echo $t10;
?>
