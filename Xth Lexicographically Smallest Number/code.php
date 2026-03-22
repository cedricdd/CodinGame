<?php

function solve(array &$base, int $index, string $number, int $x): int {
    global $b, $s1, $s2, $m, $n;

    //Check every possible characters in lexicographical order (the first one can't be a 0)
    for($i = ($index ? 0 : 1); $i < $b; ++$i) {
        $prefix = base_convert($number . $base[$i], $b, 10);

        $l = $index + 1;
        $counts = [];

        //We get how many numbers in total with that prefix exist in the given range
        for($s = $l; $s <= $s2; ++$s) {
            $v = $b ** ($s - $l);

            $min = $prefix * $v; //The minimum number starting with the prefix
            $max = ($prefix + 1) * $v - 1; //The maximum number starting with the prefix

            //How many numbers are in our range that start with the prefix
            if($max < $m  || $min > $n) $intersect = 0;
            else $intersect = min($n, $max) - max($m, $min) + 1;

            $counts[$s] = $intersect;
        }

        $total = array_sum($counts);

        if($total < $x) $x -= $total; //Even by using every numbers we can't reach our goal position, we need to "increase" the prefix
        else { //Our goal number start with the current prefix
            $x -= $counts[$l] ? 1 : 0; //The current prefix is in the range

            if($x == 0) return $prefix; //We have found the goal number
            else return solve($base, $index + 1, $number . $base[$i], $x); //Increase the size of the prefix
        }
    }
}

fscanf(STDIN, "%d %d %d %d", $m, $n, $b, $x);

$base = str_split(substr('0123456789abcdefghijklmnopqrstuvwxyz', 0, $b));
$s1 = strlen(base_convert($m, 10, $b));
$s2 = strlen(base_convert($n, 10, $b));

echo solve($base, 0, "", $x) . PHP_EOL;
