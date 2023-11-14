<?php

fscanf(STDIN, "%d", $n);

$output = array_fill(0, $n, str_repeat(".", $n));

for ($y = 0; $y < $n; ++$y) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        //It's a digit, need to get the info
        if(ctype_digit($c)) {

            $neighbors = [];

            //Get all the neighbors of this position
            for($y2 = max(0, $y - 1); $y2 <= min($n - 1, $y + 1); ++$y2) {
                for($x2 = max(0, $x - 1); $x2 <= min($n - 1, $x + 1); ++$x2) {
                    $neighbors[] = [$x2, $y2];
                }
            }

            $info[] = [$c, $neighbors];
        }
    }
}

while($info) {
    foreach($info as $i => [$count, $neighbors]) {
        $possibilities = [];
        $occupied = [];

        //Check all the neighbors to see how many are occupied and how many could be occupied
        foreach($neighbors as [$x, $y]) {
            if($output[$y][$x] === '.') $possibilities[] = [$x, $y];
            elseif($output[$y][$x] === '#') $occupied[] = [$x, $y];
        }

        $countPossibility = count($possibilities);
        $countOccupied = count($occupied);

        //This digit is aready satisfied
        if($countOccupied == $count) {
            unset($info[$i]);

            //We know all these have to be empty
            if($countPossibility > 0) foreach($possibilities as [$x, $y]) $output[$y][$x] = '@';

        } elseif($countPossibility + $countOccupied == $count) {
            //Mark them all as occupied
            foreach($possibilities as [$x, $y]) $output[$y][$x] = '#';

            unset($info[$i]);
        }
    }
}

echo implode(PHP_EOL, array_map(function($line) {
    return str_replace("@", ".", $line);
}, $output)) . PHP_EOL;
