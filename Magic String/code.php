<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $names[] = trim(fgets(STDIN));
}

sort($names); //Sort names alphabetically

$index = ($N / 2) - 1; //Index of the last name of the first half

//Try to find a magic string shorter than the last name
for($i = 0; $i < min(strlen($names[$index]), strlen($names[$index + 1])) - 1; ++$i) {
    //The letter are different, we can create a magic string
    if($names[$index + 1][$i] != $names[$index][$i]) {
        echo substr($names[$index + 1], 0, $i) . chr(ord($names[$index][$i]) + 1) . PHP_EOL;
        exit();
    }
}

echo $names[$index] . PHP_EOL;
