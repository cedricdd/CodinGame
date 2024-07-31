<?php

function removePositions(array &$grid, array &$rows, int $x, int $y) {
    for($i = 0; $i < 8; ++$i) {
        unset($grid[$y][$x + $i]);
        unset($grid[$y][$x - $i]);
        unset($grid[$y + $i][$x]);
        unset($grid[$y - $i][$x]);
        unset($grid[$y + $i][$x + $i]);
        unset($grid[$y + $i][$x - $i]);
        unset($grid[$y - $i][$x + $i]);
        unset($grid[$y - $i][$x - $i]);
    }

    unset($rows[$y]);
}

$rows = array_fill(0, 8, 1);
$grid = array_fill(0, 8, array_fill(0, 8, 1));

for ($y = 0; $y < 8; ++$y) {
    $output[] = trim(fgets(STDIN));

    foreach(str_split($output[$y]) as $x => $c) {
        if($c == 'Q') removePositions($grid, $rows, $x, $y);
    }
}

$toCheck = [[$grid, $rows, $output]];

while(true) {
    [$grid, $rows, $output] = array_pop($toCheck);

    foreach($rows as $rowID => $filler) {
        $count = count($grid[$rowID]);

        if($count == 0) continue 2; //Invalid
        elseif($count == 1) { //Only one possibility, addidng it
            $x = array_key_first($grid[$rowID]);

            removePositions($grid, $rows, $x, $rowID);

            $output[$rowID][$x] = 'Q';
        } //We need to test mulitple possibilities
        else {
            foreach($grid[$rowID] as $x => $filler) {
                $grid2 = $grid;
                $rows2 = $rows;
                $output2 = $output;

                removePositions($grid2, $rows2, $x, $rowID);

                $output2[$rowID][$x] = 'Q';

                $toCheck[] = [$grid2, $rows2, $output2];
            }

            continue 2;
        }
    }

    if(count($rows) == 0) {
        echo implode("\n", $output) . PHP_EOL;
        break;
    }
}
