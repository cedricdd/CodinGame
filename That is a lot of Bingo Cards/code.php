<?php

fscanf(STDIN, "%d", $numOfBalls);
fscanf(STDIN, "%d", $height);
for ($i = 0; $i < $height; $i++) {
    $card[] = rtrim(fgets(STDIN));
}

error_log(var_export($card, true));

$numColumn = ceil(strlen($card[0]) / 3);
$bases = [];

for($i = 0; $i < $numColumn; ++$i) {
    $count = 0;

    for($j = 1; $j < $height; ++$j) {
        if($card[$j][$i * 3 + 1] == ".") ++$count;
    }

    //Add the numbers based on how many dot there is on this column
    for($j = 0; $j < $count; ++$j) {
        $base = $numOfBalls / $numColumn - $j;
        $bases[$base] = (isset($bases[$base]) ? $bases[$base] : 0) + 1;
    }
}

foreach($bases as $base => $power) {
    if($power == 1) $answer[] = $base;
    else $answer[] = $base . "^" . $power;
}

echo implode(" * ", $answer) . PHP_EOL;
