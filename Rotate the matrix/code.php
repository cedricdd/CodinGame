<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $matrix[] = explode("-", trim(fgets(STDIN)));
}

//We start at the top right corner
$x1 = $N - 1;
$y1 = 0;

while(true) {
    $x2 = $x1;
    $y2 = $y1;
    $line = [];

    //Get all the characters of the next line
    while($x2 < $N && $y2 < $N) {
        $line[] = $matrix[$y2][$x2];
        $x2++;
        $y2++;
    }

    echo str_pad(implode(" ", $line), $N * 2 - 1, " ", STR_PAD_BOTH) . PHP_EOL; //Print with the spaces

    if($x1 > 0) --$x1;
    elseif($y1 < $N - 1) ++$y1;
    else break;
}
