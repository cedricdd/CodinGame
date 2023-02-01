<?php

function plantTree(array $trees, array $toCheck, int $turns): array {

    global $W, $H;

    for($i = 0; $i <= $turns; ++$i) {
        $newCheck = [];
    
        foreach($toCheck as [$x, $y]) {

            $index = $y * $W + $x;
            
            //Another tree will add a seed here faster
            if(isset($trees[$index]) && $trees[$index] <= $i) continue;
            //There will be a tree here at year 33
            else $trees[$y * $W + $x] = $i;
    
            //Trees produce 4 seeds around them
            foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;
    
                if($xu >= 0 && $xu < $W && $yu >= 0 && $yu < $H) $newCheck[] = [$xu, $yu];
            }
        }

        $toCheck = $newCheck;
    }

    return $trees;
}

$trees = [];

fscanf(STDIN, "%d", $W);
fscanf(STDIN, "%d", $H);

for($y = 0; $y < $H; ++$y) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        if($c == "Y") $trees = plantTree($trees, [[$x, $y]], 3);
    }
}

$answer = 0;

for($y = 0; $y < $H; ++$y) {
    for($x = 0; $x < $W; ++$x) {
        //This position can't be the best initial position
        if(($trees[$y * $W + $x] ?? INF) <= 1) continue;
        
        //Test planting the initial seed at this position
        $answer = max(count(plantTree($trees, [[$x, $y]], 2)), $answer);
    }
}

echo $answer . PHP_EOL;
