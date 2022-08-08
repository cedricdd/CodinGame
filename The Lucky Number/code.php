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
        //For [0, $d[ the last digit is done during next step or we would count the same lucky numbers twice
        //This is resulting in the fact we are only checking the range [0, $n[
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
