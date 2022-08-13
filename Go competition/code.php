<?php

function floodFill(int $x, int $y): void {
    global $grid, $visited, $L, $scores;

    $toCheck[] = [$x, $y];
    $foundB = false;
    $foundW = false;
    $cells = 0;

    while(count($toCheck)) {
        [$x, $y] = array_pop($toCheck);

        if($x < 0 || $x == $L || $y < 0 || $y == $L) continue; //Out of the grid

        if($grid[$y][$x] == "B") {
            $foundB = true;
            continue;
        }
        if($grid[$y][$x] == "W") {
            $foundW = true;
            continue;
        }

        if(isset($visited[$y][$x])) continue; //Already explored
        $visited[$y][$x] = 1;

        ++$cells;

        //Check the 4 directions
        foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$mx, $my]) {
            $toCheck[] = [$x + $mx, $y + $my];
        }
    }

    if($foundB && !$foundW) $scores["B"] += $cells; //Add the empty to score of B
    if(!$foundB && $foundW) $scores["W"] += $cells; //Add the empty to score of W
}

fscanf(STDIN, "%d", $L);
for ($i = 0; $i < $L; $i++) {
    $grid[] = stream_get_line(STDIN, 1024 + 1, "\n");
}

$scores = ["B" => 0, "W" => 6.5];
$visited = [];
$scoreB = 0;
$scoreW = 6.5;

for($y = 0; $y < $L; ++$y) {
    for($x = 0; $x < $L; ++$x) {
        if($grid[$y][$x] == "B") ++$scores["B"]; //Black stone
        elseif($grid[$y][$x] == "W") ++$scores["W"]; //White stone
        elseif(!isset($visited[$y][$x])) floodFill($x, $y); //Empty cell we haven't explored yet
    }
}

echo "BLACK : " . $scores["B"] . "\n";
echo "WHITE : " . $scores["W"] . "\n";
echo (($scores["B"] > $scores["W"]) ? "BLACK" : "WHITE") . " WINS\n";
?>
