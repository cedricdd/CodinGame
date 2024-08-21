<?php

fscanf(STDIN, "%d", $h);
fscanf(STDIN, "%d", $w);
for ($i = 0; $i < $h; $i++) {
    $pavement[] = stream_get_line(STDIN, 100 + 1, "\n");
}

error_log(var_export($pavement, true));

//Find pattern on width
for($pw = 1; $pw <= $w; ++$pw) {
    if($w % $pw != 0) continue; //We know that we only have full pattern 

    //Check if it works for all the lines
    for($y = 0; $y < $h; ++$y) {
        if(count(array_unique(str_split($pavement[$y], $pw))) != 1) continue 2;
    }

    break;
}

error_log("width $pw");

foreach($pavement as &$line) $line = substr($line, 0, $pw);

//Find the pattern on height
for($ph = 1; $ph <= $h; ++$ph) {
    if($h % $ph != 0) continue; //We know that we only have full pattern 

    if(count(array_unique(array_chunk($pavement, $ph), SORT_REGULAR)) == 1) break;
}

echo implode("\n", array_slice($pavement, 0, $ph)) . PHP_EOL;
