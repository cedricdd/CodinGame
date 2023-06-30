<?php

fgets(STDIN);
$inputs = str_replace(" ", "", trim(fgets(STDIN)));

$permutations = 0;

for($i = 0; $i < strlen($inputs); ++$i) {
    //For each 0 we simply move the 1 that's the closest from the end
    if($inputs[$i] == "0") {

        if(($position = strrpos($inputs, "1")) > $i) {
            $inputs[$position] = "0";
            ++$permutations;
        } //We have no 1 left to move, it's over
        else break;
    }
}

echo $permutations . PHP_EOL;
