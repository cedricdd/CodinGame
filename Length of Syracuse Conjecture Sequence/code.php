<?php

//Get the cycle-length of the Syracuse Conjecture
function syracuseConjecture(array &$memory, int $n): int {
  
    if(isset($memory[$n])) return $memory[$n];

    if($n & 1) return $memory[$n] = 1 + syracuseConjecture($memory, $n * 3 + 1);
    else return $memory[$n] = 1 + syracuseConjecture($memory, $n >> 1);
}

$memory = [1 => 1];

fscanf(STDIN, "%d", $N);
for ($k = 0; $k < $N; $k++) {
    fscanf(STDIN, "%d %d", $A, $B);

    $longest = -INF;
    $index = 0;

    for($i = $A; $i <= $B; ++$i) {
        $cycleLength = syracuseConjecture($memory, $i);
        if($cycleLength > $longest) {
            $longest = $cycleLength;
            $index = $i;
        }
    }

    echo "$index $longest" . PHP_EOL;
}
?>
