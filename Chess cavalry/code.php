<?php

const MOVES = [[-2, -1], [-1, -2], [1, -2], [2, -1], [-2, 1], [-1, 2], [1, 2], [2 ,1]];

fscanf(STDIN, "%d %d", $W, $H);
for ($y = 0; $y < $H; ++$y) {
    fscanf(STDIN, "%s", $board[]);

    if(($x = strpos($board[$y], "B")) !== false) $start = [$x, $y];
}

$visited = [];
$turns = 1;
$toCheck = [$start];

while(count($toCheck)) {

    $newCheck = [];

    foreach($toCheck as [$x, $y]) {
        //Knight was already at this position before
        if(isset($visited[$y][$x])) continue;
        else $visited[$y][$x] = 1;

        //Test all the moves from the current position
        foreach(MOVES as [$xm, $ym]) {
            $xu = $x + $xm;
            $yu = $y + $ym;

            //We can move there
            if($xu >= 0 && $xu < $W && $yu >= 0 && $yu < $H) {

                //We reached the target position
                if($board[$yu][$xu] === "E") exit("$turns");
                
                if($board[$yu][$xu] !== "#") $newCheck[] = [$xu, $yu];
            } 
        }
    }

    ++$turns;
    $toCheck = $newCheck;
}

echo "Impossible" . PHP_EOL;
?>
