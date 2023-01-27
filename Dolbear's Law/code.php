<?php

$inputs = [];

fscanf(STDIN, "%d", $M);
for ($i = 0; $i < $M; $i++) {
    //Save all the inputs in a single array
    $inputs = array_merge($inputs, explode(" ", trim(fgets(STDIN))));
}

//Get the N60 value
$N60 = number_format(array_sum(array_map(function($chunk) {
    return 10 + (array_sum($chunk) - 40) / 7;
}, array_chunk($inputs, 15))) / $M, 1);

echo $N60 . PHP_EOL;

//Temperature is eligible for N8
if($N60 >= 5 && $N60 <= 30) {
    if(count($inputs) & 1) array_pop($inputs); //Odd number of inputs, remove the last one

    $N8 = number_format(array_sum(array_map(function($chunk) {
        return array_sum($chunk) + 5;
    }, array_chunk($inputs, 2))) / (count($inputs) >> 1), 1);
    
    echo $N8 . PHP_EOL;
}
