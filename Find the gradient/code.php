<?php

fscanf(STDIN, "%d", $h);
fscanf(STDIN, "%d", $w);
for ($i = 0; $i < $h; $i++) {
    $pavement[] = stream_get_line(STDIN, 100 + 1, "\n");
}

//Find pattern on width
for($pw = 1; $pw <= $w; ++$pw) {
    if($w % $pw != 0) continue; //We know that we only have full pattern 

    if(count(array_unique(str_split($pavement[0], $pw))) == 1) break;
}

foreach($pavement as &$line) $line = substr($line, 0, $pw);

//Find the pattern on height
for($ph = 1; $ph <= $h; ++$ph) {
    if($h % $ph != 0) continue; //We know that we only have full pattern 

    if(count(array_unique(array_chunk($pavement, $ph), SORT_REGULAR)) == 1) break;
}

echo implode("\n", array_slice($pavement, 0, $ph)) . PHP_EOL;
