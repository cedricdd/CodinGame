<?php
function pick_option_index(int $options): int {
    static $seed = 0;
    
    return ($seed += 7) % $options;
}

$t = explode(" ", trim(fgets(STDIN)));
fscanf(STDIN, "%d", $d);
fscanf(STDIN, "%d", $l);
$s = stream_get_line(STDIN, 1000 + 1, "\n");

//Create the lookup table
for($i = 0; $i < count($t) - $d; ++$i) {
    $text = implode(" ", array_slice($t, $i, $d));

    if(!in_array($t[$i + $d], $lookup[$text] ?? [])) {
        $lookup[$text][] = $t[$i + $d];
    }
}

$output = explode(" ", $s);

//Create the n-gram Markov chain of $l length
for($i = count($output) - $d; count($output) < $l; ++$i) {
    $reference = implode(" ", array_slice($output, $i, $l));

    $output[] = $lookup[$reference][pick_option_index(count($lookup[$reference]))];
}

echo implode(" ", $output) . PHP_EOL;
