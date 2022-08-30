<?php

$cigars = [];

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d", $size);

    $cigars[$size] = ($cigars[$size] ?? 0) + 1; //Group by cigar size
}

$ans = max($cigars); //Iniital max is the max # of cigar of the same size
$N = count($cigars); //Count without duplicate sizes
$cigars = array_keys($cigars);
$cigarsFlipped = array_flip($cigars);
$maxSize = end($cigars);

for($i = 0; $i < $N - 1; ++$i) {
    for($j = $i + 1; $j < $N; ++$j) {
        $difference = $cigars[$j] - $cigars[$i]; //The difference we need to test
        $count = 2;

        //Check how many cigar we can add start at $j with a difference of $difference
        $k = $cigars[$j] + $difference;

        while($k <= $maxSize && isset($cigarsFlipped[$k])) {
            ++$count;
            $k += $difference;
        }

        if($count > $ans) $ans = $count;       
    }
}

echo $ans . PHP_EOL;
?>
