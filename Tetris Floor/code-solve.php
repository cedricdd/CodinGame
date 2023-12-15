<?php

const TETROMINOES = [
    0 => [[0, 0], [1, 0], [2, 0], [3, 0]], //I
    1 => [[0, 0], [0, 1], [0, 2], [0, 3]], //I 180
    4 => [[0, 0], [1, 0], [0, 1], [1, 1]], //O
    8 => [[0, 0], [1, 0], [2, 0], [1, 1]], //T
    9 => [[0, 0], [0, 1], [0, 2], [-1, 1]], //T 90
    10 => [[0, 0], [1, 0], [2, 0], [1, -1]], //T 180
    11 => [[0, 0], [0, 1], [0, 2], [1, 1]], //T 270
    12 => [[0, 0], [1, 0], [2, 0], [0, 1]], //L
    13 => [[0, 0], [1, 0], [1, 1], [1, 2]], //L 90
    14 => [[0, 0], [1, 0], [2, 0], [2, -1]], //L 180
    15 => [[0, 0], [0, 1], [0, 2], [1, 2]], //L 270
    16 => [[0, 0], [1, 0], [2, 0], [2, 1]], //J
    17 => [[0, 0], [1, 0], [1, -1], [1, -2]], //J 90
    18 => [[0, 0], [0, 1], [1, 1], [2, 1]], //J 180
    19 => [[0, 0], [1, 0], [0, 1], [0, 2]], //J 270
    20 => [[0, 0], [1, 0], [1, 1], [2, 1]], //Z
    21 => [[0, 0], [0, 1], [-1, 1], [-1, 2]], //Z 90
    24 => [[0, 0], [1, 0], [1, -1], [2, -1]], //S
    25 => [[0, 0], [0, 1], [1, 1], [1, 2]], //S 90
];

function solve(string $floor, array $positions, array $counts, array $usage, int $price): array {
    
    static $history = [];
    global $pieces, $piecesType, $prices, $minPrice, $bestPrice;

    $results = [];
    $hashUsage = implode("-", $usage);
    $positionsLeft = count($positions);
    
    //We have filled all the positions
    if($positionsLeft == 0) {
        if($bestPrice > $price) $bestPrice = $price; //We have found a new best price
        
        return [$price => [$hashUsage => 1]];
    }
    
    //We have already encounter the case where the same positions are covered with the same set of blocks
    if(isset($history[$floor][$hashUsage])) return $history[$floor][$hashUsage];

    //We know that we can no longer beat the current best price
    if($price + ($minPrice * ($positionsLeft / 4)) > $bestPrice) return $results;
    
    //Get the next position to work on
    $min = INF;
    $position = 0;
    foreach($counts as $i => $v) {
        if($v < $min) {
            $min = $v;
            $position = $i;
        }
    }
    
    if($min == 0) return $results; //At least one of the position can't be covered anymore
    
    //We test all the pieces that can go in the position
    foreach($positions[$position] as $pieceID) {
        $pieceType = intdiv($piecesType[$pieceID], 4);
        
        $usage[$pieceType]++;
    
        //Copy info for recursive
        $positions2 = $positions;
        $counts2 = $counts;
        $floor2 = $floor;
        
        //Work on all the positions of the piece
        foreach($pieces[$pieceID] as $positionID) {
    
            $floor2[$positionID] = "#";
            
            if(!isset($positions2[$positionID])) continue;
            
            //All pieces in the position can no longer be used
            foreach($positions2[$positionID] as $pieceID2) {
                foreach($pieces[$pieceID2] as $positionID2) {
                    --$counts2[$positionID2]; 
                    unset($positions2[$positionID2][$pieceID2]); 
                }
            }
            
            //The position has been covered
            unset($positions2[$positionID]); 
            unset($counts2[$positionID]); 
        }
        
        $solutions = solve($floor2, $positions2, $counts2, $usage, $price + $prices[$pieceType]);
        
        foreach($solutions as $priceSolution => $listSolutions) {
            foreach ($listSolutions as $index => $count) {
                $results[$priceSolution][$index] = ($results[$priceSolution][$index] ?? 0) + $count;
            }
        }
    
        //Reset the value
        $usage[$pieceType]--;
    }
    
    return $history[$floor][$hashUsage] = $results;
}

$start = microtime(1);

fscanf(STDIN, "%d %d", $w, $h);

$prices = explode(" ", trim(fgets(STDIN)));

//Make things easier, convert prices to int
$prices = array_map(function($price) {
    return intval($price * 100);
}, $prices);

$floor = "";
for ($i = 0; $i < $h; $i++) $floor .= trim(fgets(STDIN));


$minPrice = min($prices);
$pieceID = 0;
$counts = array_fill(0, $w * $h, 0);
$positions = array_fill(0, $w * $h, []);
$piecesType = [];
$output = array_fill(0, $h * 2 + 1, str_repeat(" ", $w * 2 + 1));
$usage = array_fill(0, 7, 0);
$variations = 1;
$price = 0;

//Get all the pieces that can start at every positions
for($index = 0; $index < $h * $w; ++$index) {

    if($floor[$index] == '#') {
        unset($counts[$index]);
        unset($positions[$index]);
        continue;
    }
    
    foreach(TETROMINOES as $pieceType => $moves) {       
        $piecePositions = [];
        
        //Check if this piece could be added here
        foreach($moves as [$xm, $ym]) {
            $newIndex = $index + $xm + ($ym * $w);
            
            if($floor[$newIndex] !== '.') continue 2;
            
            $piecePositions[$newIndex] = $newIndex;
        }

        //For each positions this piece would occupy save the info
        foreach($piecePositions as $indexPosition) {
           $counts[$indexPosition]++;
           
           $positions[$indexPosition][$pieceID] = $pieceID;
        }
        
        $piecesType[$pieceID] = $pieceType;
        $pieces[$pieceID++] = $piecePositions;
    }
}

//When we work on a position we want to try the cheapest piece first
foreach($positions as $index => $filler) {
    uksort($positions[$index], function($a, $b) use ($prices, $piecesType) {
        return $prices[intdiv($piecesType[$a], 4)] <=> $prices[intdiv($piecesType[$b], 4)];
    });
}

//For each positions where there's a single possibility directly use the piece
while(($index = key($counts)) !== null) {
        
    if($counts[$index] == 1) {
        $pieceID = array_key_first($positions[$index]);
        
        $pieceType = intdiv($piecesType[$pieceID], 4);

        $usage[$pieceType]++;
        $price += $prices[$pieceType];
        
        //Work on all the positions of the piece
        foreach($pieces[$pieceID] as $positionID) {
            
            $floor[$positionID] = "#";
            
            if(!isset($positions[$positionID])) continue;
            
            //Any pieces that was using this position can no longer be used
            foreach($positions[$positionID] as $pieceID2) {
                foreach($pieces[$pieceID2] as $positionID2) { 
                    --$counts[$positionID2];
                    unset($positions[$positionID2][$pieceID2]);
                }
            }
            
            unset($positions[$positionID]);
            unset($counts[$positionID]);
        }
        
        reset($counts); //We restart from the start, adding a piece might create more position with a single possibility
    } else next($counts);
}

//Each "blocks" of empty spaces completely surrounded by walls is independent and can be solved independently
for($index = 0; $index < $h * $w; ++$index) {
    if($floor[$index] == "#") continue;
    
    //We start flood fill to find all the position we're gonna work on
    $toExplore = [$index];
    $positionsFlood = [];
    $countsFlood = [];
    
    while(count($toExplore)) {
        $index = array_pop($toExplore);
        
        if(isset($positionsFlood[$index])) continue;
        
        $positionsFlood[$index] = $positions[$index];
        $countsFlood[$index] = $counts[$index];
        
        //We can move up, down, left & right
        foreach([1, -1, $w, -$w] as $move) {
            if($floor[$index + $move] != '.') continue;
            
            $toExplore[] = $index + $move;
        }
    }
    
    $bestPrice = INF; //Best price for the current block

    $solutions = solve($floor, $positionsFlood, $countsFlood, $usage, $price);

    $bestPrice = min(array_keys($solutions));
    
    $usage = explode("-", array_key_first($solutions[$bestPrice]));
    $variations *= reset($solutions[$bestPrice]);
    $price = $bestPrice;
    
    foreach($positionsFlood as $index => $filler) $floor[$index] = "#"; //Mark all the positions that have been solved
}

echo number_format($price / 100, 2, ".", "") . PHP_EOL;
echo implode(" ", $usage) . PHP_EOL;
echo $variations . PHP_EOL;

error_log(microtime(1) - $start);
