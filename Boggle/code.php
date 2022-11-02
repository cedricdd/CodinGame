<?php

const DIRECTIONS = [[-1, -1], [0, -1], [1, -1], [-1, 0], [1, 0], [-1, 1], [0, 1], [1, 1]];

function explore(int $x, int $y, string $word, array $grid): bool {
    $toCheck = [[$x, $y, 0, []]];
    
    while(count($toCheck)) {
        [$x, $y, $i, $visited] = array_pop($toCheck);

        //Each cell of the grid may be used only once.
        if(isset($visited[$x . " " . $y])) continue;
        else $visited[$x . " " . $y] = 1;

        //Make sure it's the right letter to continue the word
        if($word[$i] != $grid[$y][$x]) continue;
        elseif($i + 1 == strlen($word)) return true;

        //Check the 8 directions we can move to
        foreach(DIRECTIONS as [$xm, $ym]) {
            $xu = $x + $xm;
            $yu = $y + $ym;

            if($xu >= 0 && $xu < 4 && $yu >= 0 && $yu < 4) $toCheck[] = [$xu, $yu, $i + 1, $visited];
        }
    }

    return false;
}

fscanf(STDIN, "%s", $grid[]);
fscanf(STDIN, "%s", $grid[]);
fscanf(STDIN, "%s", $grid[]);
fscanf(STDIN, "%s", $grid[]);

error_log(var_export($grid, true));

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    fscanf(STDIN, "%s", $word);

    for($y = 0; $y < 4; ++$y) {
        for($x = 0; $x < 4; ++$x) {
            if($grid[$y][$x] == $word[0]) {
                if(explore($x, $y, $word, $grid)) {
                    echo "true\n";
                    continue 3;
                }
            }
        }
    }

    echo "false\n";
}
