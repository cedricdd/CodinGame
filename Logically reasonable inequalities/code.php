<?php

$alphabet = array_combine(range("A", "Z"), array_fill(0, 26, [[], []]));

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    [$a, $b] = explode(" > ", trim(fgets(STDIN)));

    //We know for sure that B is bigger than A
    if(isset($alphabet[$b][0][$a])) exit("contradiction");

    $alphabet[$a][0][$b] = 1; //A is > than B
    $alphabet[$b][1][$a] = 1; //B is < than A 

    //Everything bigger than A is also bigger than B
    foreach($alphabet[$a][1] ?? [] as $letter => $filler) {
        $alphabet[$letter][0][$b] = 1; 
        $alphabet[$b][1][$letter] = 1; 
    }
}

echo "consistent" . PHP_EOL;
