<?php

function addPercentages(array &$ingredients, int &$min, int &$max, int &$lastID, int $currentID, int $next) {
    error_log("min is $min - currentId $currentID -- lastID $lastID -- max $max -- next $next");

    while(--$lastID >= $currentID) {
            if($lastID == 0) $ingredients[$lastID][1] = $next - $max;
            else $ingredients[$lastID][1] = $ingredients[$lastID + 1][1] ?? 1;
            $ingredients[$lastID][2] = floor(($next - $min) / ($lastID - $currentID + 1));
        

        $min += $ingredients[$lastID][1];
        $max += $ingredients[$lastID][2];

        if($ingredients[$lastID][1] == $ingredients[$lastID][2]) unset($ingredients[$lastID][2]);
    }
}

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $ingredients[] = explode(" ", trim(fgets(STDIN)));
}

error_log(var_export($ingredients, true));

$max = 0;
$min = 0;
$prev = 1;
$next = 100;
$lastID = $N;

for($i = count($ingredients) - 1; $i >= 0; --$i) {
    if(count($ingredients[$i]) != 1) {  
         error_log("we have id $i & lastid $lastID");
        if($i == $lastID - 1) {
            error_log("for id $i we just add the min");
            $lastID--;
        } else addPercentages($ingredients, $min, $max, $lastID, $i + 1, $ingredients[$i][1]);

        $min += $ingredients[$i][1];
        $max += $ingredients[$i][1];
    } 
}

addPercentages($ingredients, $min, $max, $lastID, 0, 100);

echo implode("\n", array_map(function($line) {
    return implode(" ", $line);
}, $ingredients)) . PHP_EOL;
