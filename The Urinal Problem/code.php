<?php

fscanf(STDIN, "%d", $N);
preg_match_all("/U+/", stream_get_line(STDIN, 100 + 1, "\n"), $matches, PREG_OFFSET_CAPTURE); //Get all the sequences with at least 1 free urinal

foreach($matches[0] as $match) {
    $size = strlen($match[0]);

    if($match[1] == 0) $positions[0] = $size - 1; //We start at start of the line
    elseif($match[1] + $size == $N) $positions[$N - 1] = $size - 1; //We end at the end of the line
    else $positions[$match[1] + intdiv($size, 2)] = $size - intdiv($size, 2) - 1; //Best is the urinal at the center
}

asort($positions);

echo array_key_last($positions);
?>
