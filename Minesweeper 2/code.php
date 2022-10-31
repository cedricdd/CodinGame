<?php

fscanf(STDIN, "%d %d", $h, $w);
fscanf(STDIN, "%d", $numberBombs);
$unknown = 0;

for ($i = 0; $i < $h; $i++) {
    $grid[] = trim(fgets(STDIN));
    $unknown += substr_count($grid[$i], "?");
}

$bombs = [];

// game loop
while (TRUE) {
    //Foreach position with a digit we get the number of neighbors that are "?" and the number of bombs that are still unknown
    for($y = 0; $y < $h; ++$y) {
        for($x = 0; $x < $w; ++$x) {
            if(!ctype_digit($grid[$y][$x])) continue;

            $bombsToFind = $grid[$y][$x];
            $neighbors = [];

            for($y2 = max(0, $y - 1); $y2 < min($h, $y + 2); ++$y2) {
                for($x2 = max(0, $x -1); $x2 < min($w, $x + 2); ++$x2) {
                    if($grid[$y2][$x2] === "B") --$bombsToFind;
                    elseif($grid[$y2][$x2] === "?") $neighbors[] = [$x2, $y2];
                }
            }

            //We know where all the bombs are
            if($bombsToFind == 0) {
                //If there are some other neighbors we are sure there's no bomb there
                if(count($neighbors) > 0) {
                    foreach($neighbors as [$safeX, $safeY]) {
                        $grid[$safeY][$safeX] = ".";
                        --$unknown;
                    }
                }
            }
            //The # of "?" in neighbors is the same as the # of bombs still to find, it's all bombs 
            elseif($bombsToFind == count($neighbors)) {
                foreach($neighbors as [$bombX, $bombY]) {
                    $bombs[] = [$bombX, $bombY];
                    $grid[$bombY][$bombX] = "B";
                    --$unknown;
                }

                $bombsToFind = 0;
            }

            
            $grid[$y][$x] = $bombsToFind;
        }
    }

    //Eveything still marked as "?" is a bomb
    if($unknown + count($bombs) == $numberBombs) {
        for($y = 0; $y < $h; ++$y) {
            for($x = 0; $x < $w; ++$x) {
                if($grid[$y][$x] == "?") {
                    $bombs[] = [$x, $y];
                }
            }
        }
        break;
    }

    //We have found all the bombs
    if($numberBombs == count($bombs)) break;
}

//Sort for output -- In column ascending order, then in line ascending order for the same column.
usort($bombs, function($a, $b) {
    if($a[0] == $b[0]) return $a[1] <=> $b[1];
    else return $a[0] <=> $b[0];
});

foreach($bombs as [$x, $y]) {
    echo $x . " " . $y . PHP_EOL;
}
