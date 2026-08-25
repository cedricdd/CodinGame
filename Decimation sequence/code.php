<?php

fscanf(STDIN, "%d %d", $n, $k);
$inputs = explode(" ", trim(fgets(STDIN)));

while($k > $n) {
    /**
     * k is a multiple of n+1 (it's one of the 'decimated term')
     * position (k) = position (k / (n + 1))
     */
    if($k % ($n + 1) == 0) $k /= ($n + 1);
    /**
     * Among the first k positions, there are floor(k / n + 1) removed positions
     * Therefore k corresponds to position k - floor(k / n + 1) of the original sequence.
     */
    else $k -= floor($k / ($n + 1));
}

echo $inputs[$k - 1] . PHP_EOL;
