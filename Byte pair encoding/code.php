<?php

fscanf(STDIN, "%d %d", $n, $m);

$line = "";
for ($i = 0; $i < $n; $i++) {
    $line .= trim(fgets(STDIN));
}

function findRepetitve(string $string): string {

    //Count the occurence of all the byte pairs
    for($i = 0; $i < strlen($string) - 1; ++$i) {
        $pair = substr($string, $i, 2); 

        if(!isset($repetitions[$pair])) {
            $repetitions[$pair] = substr_count($string, $pair);
        }
    }

    //It needs to be repeated at least twice
    $repetitions = array_filter($repetitions, function($repetition) {
        return $repetition > 1;
    });

    if(count($repetitions) == 0) return ""; //No pair is repeating
    else return array_search(max($repetitions), $repetitions); // We choose the first (leftmost) pair
}

$rules = [];
$characters = range("A", "Z");

while(true) {
    $repetition = findRepetitve($line);

    //The are no repeated byte pairs, it's over
    if(empty($repetition)) break;

    $character = array_pop($characters);

    $line = str_replace($repetition, $character, $line);
    $rules[] = "$character = $repetition";
}

echo $line . PHP_EOL;
echo implode("\n", $rules) . PHP_EOL;
?>
