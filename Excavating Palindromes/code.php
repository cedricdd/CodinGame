<?php


function solve(string $s): int {
    $len = strlen($s);
    $middle = $len >> 1;

    if($len == 0) return 0;

    for($left = 0; $left <= $middle; ++$left) {
        $right = $len - $left - 1;

        if($s[$left] != $s[$right]) {
            $max = $left * 2 + 1; //The size of the current palindrome we have created

            //We use the left, find the first matching on the right
            for($j = $right - 1; $j > $left; --$j) {
                if($s[$j] == $s[$left]) {
                    $max = max($max, solve(substr_replace($s, "", $j + 1, $right - $j)));

                    break;
                }
            }

            //We use the right, find the first matching on the left
            for($j = $left + 1; $j < $right; ++$j) {
                if($s[$j] == $s[$right]) {
                    $max = max($max, solve(substr_replace($s, "", $left, $j - $left)));

                    break;
                }
            }

            //We drop the left and the right
            $max = max($max, solve(substr($s, 0, $left) . substr($s, $left + 1, $right - $left - 1) . substr($s, $right + 1)));

            return $max;
        }
    }

    return $len;
}

$start = microtime(1);

$string = trim(fgets(STDIN));

echo solve($string) . PHP_EOL;

error_log(microtime(1) - $start);
