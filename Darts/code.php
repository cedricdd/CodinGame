<?php

fscanf(STDIN, "%d", $size);
$radius = $size / 2;
fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $competitors[trim(fgets(STDIN))] = 0;
}
$competitors = array_reverse($competitors, true);

fscanf(STDIN, "%d", $T);
for ($i = 0; $i < $T; $i++) {
    fscanf(STDIN, "%s %d %d", $name, $x, $y);

    //Inside diamond
    if(abs($x) + abs($y) <= $radius) {
        $competitors[$name] += 15;
    } //Inside circle
    elseif(sqrt(pow($x, 2) + pow($y, 2)) <= $radius) {
        $competitors[$name] += 10;
    } //Inside square
    elseif(abs($x) <= $radius && abs($y) <= $radius) {
        $competitors[$name] += 5;
    }
}

//Sort by score and in order of appearance in the input list in case of a tie.
array_multisort($competitors, SORT_DESC, range(1,count($competitors)), SORT_DESC);

foreach($competitors as $name => $score) {
    echo $name . " " . $score . PHP_EOL;
}
