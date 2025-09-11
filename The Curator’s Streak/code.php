<?php

function solve(array $arr, int $r, int $n): int {
    //Get the positions of each values
    foreach ($arr as $i => $x) {
        $pos[$x][] = $i;
    }

    $best = 0;

    foreach ($pos as $v => $p) {
        $i = 0;
        $size = count($p);

        for ($j = 0; $j < $size; $j++) {
            /**
             * i can't become bigger then j
             * The length of the interval is $p[$j] - $p[$i] + 1
             * The number of positions that don't need to be changed is $j - $i + 1
             * Find the biggest interval possible ending at $j
             */
            while ($i <= $j && (($p[$j] - $p[$i] + 1) - ($j - $i + 1)) > $r) {
                $i++;
            }

            $len = $p[$j] - $p[$i] + 1;
            $wrongValues = $len - ($j - $i + 1);

            $count = min($n, $len + $r - $wrongValues); //It's possible that we can still change some label, try to expand the interval

            if ($count > $best) $best = $count;
        }
    }

    return $best;
}

fscanf(STDIN, "%d %d %d", $n, $m, $r);
$inputs = explode(" ", trim(fgets(STDIN)));

echo solve($inputs, $r, $n);
