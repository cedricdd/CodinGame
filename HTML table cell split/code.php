<?php

$alphabet = range("A", "Z");

$index = 0;

fscanf(STDIN, "%d", $h);
for ($j = 0; $j < $h; $j++) {
    $startX = 0;

    $input = trim(fgets(STDIN));

    foreach(explode(" ", $input) as $i => $info) {
        while(isset($table[$j][$startX])) ++$startX; //This position is already occupied

        [$x1, $y1] = explode(",", $info);

        $output[$j][$i] = [$x1, $y1];

        $letter = $alphabet[$index];

        for($y2 = $j; $y2 < $j + $y1; ++$y2) {
            for($x2 = $startX; $x2 < $startX + $x1; ++$x2) {
                //We save the position of the first occurence of each letters
                if(!isset($positions[$letter])) $positions[$letter] = [$x2, $y2];

                $table[$y2][$x2] = $letter;
            }
        }

        $letters[$letter] = [$i, $j]; //We need to know what couple of values is the letter associated with
        ++$index;
        $startX += $x1;
    }
}

$w = count($table[0]);

foreach($table as $line) {
    error_log(implode($line));
}

fscanf(STDIN, "%d %s", $IS, $DS);

[$x, $y] = $positions[$alphabet[$IS]];
[$i, $j] = $letters[$alphabet[$IS]];
[$c, $r] = $output[$j][$i];
$updated = [$alphabet[$IS] => 1];

//Split into two columns
if($DS == "C") {
    //Insert the new cell
    array_splice($output[$j], $i, 1, [[1, $r], [1, $r]]);

    //Increase the colspan of every cells directyly above & below 
    for($y2 = $y - 1; $y2 >= 0; --$y2) {
        $letter = $table[$y2][$x];

        if(!isset($updated[$letter])) {
            $updated[$letter] = 1;
            
            [$i, $j] = $letters[$letter];

            $output[$j][$i][0]++;
        }
    }
    for($y2 = $y + 1; $y2 < $h; ++$y2) {
        $letter = $table[$y2][$x];

        if(!isset($updated[$letter])) {
            $updated[$letter] = 1;
            
            [$i, $j] = $letters[$letter];

            $output[$j][$i][0]++;
        }
    }
} //Split into two rows
else {
    //Insert the new cell, it will be the only one of the row
    array_splice($output, $j + 1, 0, [[[$c, $r]]]);

    //Increase the rowspan of every cells directyly left & right
    for($x2 = $x - 1; $x2 >= 0; --$x2) {
        $letter = $table[$y][$x2];

        if(!isset($updated[$letter])) {
            $updated[$letter] = 1;
            
            [$i, $j] = $letters[$letter];

            $output[$j][$i][1]++;
        }
    }
    for($x2 = $x + 1; $x2 < $w; ++$x2) {
        $letter = $table[$y][$x2];

        if(!isset($updated[$letter])) {
            $updated[$letter] = 1;
            
            [$i, $j] = $letters[$letter];

            $output[$j][$i][1]++;
        }
    }
}

// error_log(var_export($output, 1));

echo implode(PHP_EOL, array_map(function($line) {
    return implode(" ", array_map(function($info) {
        return implode(",", $info);
    }, $line));
}, $output)) . PHP_EOL;
