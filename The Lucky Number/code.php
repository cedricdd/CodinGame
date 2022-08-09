<?php

fscanf(STDIN, "%d %d", $L, $R);

/*Return the number of lucky number in [0, $n[
 *
 * We use the fact that we can easily find the number of lucky numbers in a range of [0, 10^n]
 * With a 10-based number we get 10^n numbers in [0, 10^n]
 * Excluding a number (6 or 8) we then get 9^n numbers in [0, 10^n]
 * Excluding two numbers (6 and 8) we then get 8^n numbers in [0, 10^n]
 * 
 * Lucky numbers are all numbers with a 6 => 10^n (all numbers) - 9^n (numbers without a 6)
 * + all numbers with a 8 => 10^n - 9^n 
 * - all numbers with a 6 and a 8 * 2 => (10^n - 8^n) * 2 
 * = 2* (9^n - 8^n)
 * 
 * We now just have to decompose the number in block of power of 10
 * $N = $x1 * 10^n + $x2 * 10^n-1 + ... + $xp * 10^0
 */
function solve(string $n): int {

    $count = 0;

    $power = strlen($n) - 1;
    $pow9 = pow(9, $power);
    $pow8 = pow(8, $power);

    $has8 = false;
    $has6 = false;

    //We check all digits from the number from left to right
    for($i = 0; $i < strlen($n); ++$i) {
        //We only count block that are "complete", for $x * 10^n we only count lycky numbres in for $i = [0, $x1 - 1] with 10^n
        //block $x1 will be taken care when we check $x2 => the very last number is excluded we only check the range [0, $n[
        for($d = 0; $d < $n[$i]; ++$d) {
            //A 6 or a 8 when we already had a 6 or 8 previously, add nothing
            if(($has6 || $d == 6) && ($has8 || $d == 8)) continue;

            //A 6 or a 8 => all numbers except the ones with the second are lucky numbers
            if(($has6 || $d == 6) || ($has8 || $d == 8)) $count += $pow9;
            else $count += (2 * ($pow9 - $pow8));
        }

        //If the digit we just worked on is a 6 or a 8, update
        $has8 |= ($n[$i] == 8);
        $has6 |= ($n[$i] == 6);

        if($has6 && $has8) break; //We now already have a 6 and a 8, we can't have anymore more lucky numbers

        //Update the powers
        $pow9 /= 9;
        $pow8 /= 8;
    }

    return $count;
}

//The number of lucky numbers in the range [$a, $b] = [0, $b] - [0, $a[
echo solve(strval($R + 1)) - solve(strval($L));
?>
