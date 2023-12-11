<?php

//https://fr.wikipedia.org/wiki/Tetris

$start = microtime(1);

$tetrominoes = [
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

$floor = [
    "..........#..........#..........#..........#..........#..........#..........#..........",
    "..#...#...#..#...#...#..#...#...#..#...#...#..#...#...#..#...#...#..#...#...#..#...#...",
    "...#...#..#...#...#..#...#...#..#...#...#..#...#...#..#...#...#..#...#...#..#...#...#..",
    "..........#..........#..........#..........#..........#..........#..........#..........",
];

$w = 21;
$h = 4;

$availabilities = [
    100,
    0,
    1000,
    0,
    100,
    0,
    2,
];

$prices = [
    10, 10, 10, 10, 1, 10, 1,
];

//3 -- 2 => 45
//3 -- 1 => 54

/*
$floor = [
    "......#......#......",
    "...#.....##.....#...",
    "..###....##....###..",
    "...#..#..##..#..#...",
    "...#..#..##..#..#...",
    "..###....##....###..",
    "...#.....##.....#...",
    "......#......#......",
];

$w = 20;
$h = 8;

echo implode("\n", $floor) . PHP_EOL;

$availabilities = [
    1000,
    0,
    0,
    1000,
    4,
    4,
    4,
];

$prices = [
    59.4, 10, 51.3, 10.4, 36.9, 84, 89.2,
];*/

asort($prices);

$pieceID = 0;
$counts = array_fill(0, $w * $h, 0);
$positions = array_fill(0, $w * $h, []);
$piecesType = [];
$output = array_fill(0, $h * 2 + 1, str_repeat(" ", $w * 2 + 1));

$price = 0.0;
$listPieces = [];
$hash = "";

for($y = 0; $y < $h * 2 + 1; ++$y) {
    for($x = 0; $x < $w * 2 + 1; ++$x) {
        if($y % 2 == 0) $output[$y][$x] = ($x % 2 == 0) ? '+' : '-';
        elseif($x % 2 == 0) $output[$y][$x] = '|';
    }
}

for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        $hash .= $floor[$y][$x];
        
        if($floor[$y][$x] == '#') {
            $index = $y * $w + $x;
            
            unset($counts[$index]);
            unset($positions[$index]);
            
            $output[$y * 2 + 1][$x * 2 + 1] = "#";
            
            continue;
        }
        
        foreach($tetrominoes as $pieceType => $moves) {
            
            $piecePositions = [];
            
            if($availabilities[intdiv($pieceType, 4)] == 0) continue;
            
            foreach($moves as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;
                
                if($xu < 0 || $xu >= $w || $yu < 0 || $yu >= $h || $floor[$yu][$xu] !== '.') continue 2;
    
                $index = $yu * $w + $xu;
                $piecePositions[$index] = $index;
            }
            
            foreach($piecePositions as $index) {
               $counts[$index]++;
               
               $positions[$index][$pieceID] = $pieceID;
            }
            
            $piecesType[$pieceID] = $pieceType;
            $pieces[$pieceID++] = $piecePositions;
        }
    }
}

foreach($positions as $index => $filler) {
    uksort($positions[$index], function($a, $b) use ($prices, $piecesType) {
        return $prices[intdiv($piecesType[$a], 4)] <=> $prices[intdiv($piecesType[$b], 4)];
    });
}

error_log("we have " . count($pieces) . " pieces for this input");

$solutions = solve($hash, $pieces, $positions, $counts, $availabilities, 0.0);

$min = min(array_keys($solutions));

echo "The final cost is: $min" . PHP_EOL;
print_r($solutions[$min]);


echo("Calls $calls") . PHP_EOL;
echo(microtime(1) - $start);

function generateOutput(array $output, array $listPieces) {
    global $pieces, $piecesType, $w, $h;
    
    $quantities = array_fill(0, 7, 0);
    
    foreach($listPieces as $pieceID => $filler) {
        $position = reset($pieces[$pieceID]);
    
        $quantities[intdiv($piecesType[$pieceID], 4)]++;
        
        $xs = ($position % $w) * 2 + 1;
        $ys = intdiv($position, $w) * 2 + 1;
        
        switch($piecesType[$pieceID]) {
            case 0:
                    $output[$ys][$xs + 1] = $output[$ys][$xs + 3] = $output[$ys][$xs + 5] = " ";
                break;
            case 1:
                $output[$ys + 1][$xs] = $output[$ys + 3][$xs] = $output[$ys + 5][$xs] = " ";
                break;
            case 4:
                $output[$ys][$xs + 1] = $output[$ys + 1][$xs] = $output[$ys + 1][$xs + 1] =  $output[$ys + 2][$xs + 1] = $output[$ys + 1][$xs + 2]  = " ";
                break;
            case 8:
                $output[$ys][$xs + 1] = $output[$ys][$xs + 3] =  $output[$ys + 1][$xs + 2] = " ";
                break;
            case 9:
                $output[$ys + 1][$xs] = $output[$ys + 3][$xs] =  $output[$ys + 2][$xs - 1] = " ";
                break;
            case 10:
                $output[$ys][$xs + 1] = $output[$ys][$xs + 3] =  $output[$ys - 1][$xs + 2] = " ";
                break;
            case 11:
                $output[$ys + 1][$xs] = $output[$ys + 3][$xs] =  $output[$ys + 2][$xs + 1] = " ";
                break;
            case 12:
                $output[$ys][$xs + 1] = $output[$ys][$xs + 3] =  $output[$ys + 1][$xs] = " ";
                break;
            case 13:
                $output[$ys][$xs + 1] = $output[$ys + 1][$xs + 2] =  $output[$ys + 3][$xs + 2] = " ";
                break;
            case 14:
                $output[$ys][$xs + 1] = $output[$ys][$xs + 3] =  $output[$ys - 1][$xs + 4] = " ";
                break;
            case 15:
                $output[$ys + 1][$xs] = $output[$ys + 3][$xs] =  $output[$ys + 4][$xs + 1] = " ";
                break;
            case 16:
                $output[$ys][$xs + 1] = $output[$ys][$xs + 3] =  $output[$ys + 1][$xs + 4] = " ";
                break;
            case 17:
                $output[$ys][$xs + 1] = $output[$ys - 1][$xs + 2] =  $output[$ys - 3][$xs + 2] = " ";
                break;
            case 18:
                $output[$ys + 1][$xs] = $output[$ys + 2][$xs + 1] =  $output[$ys + 2][$xs + 3] = " ";
                break;
            case 19:
                $output[$ys][$xs + 1] = $output[$ys + 1][$xs] =  $output[$ys + 3][$xs] = " ";
                break;
            case 20:
                $output[$ys][$xs + 1] = $output[$ys + 1][$xs + 2] =  $output[$ys + 2][$xs + 3] = " ";
                break;
            case 21:
                $output[$ys + 1][$xs] = $output[$ys + 2][$xs - 1] =  $output[$ys + 3][$xs - 2] = " ";
                break;
            case 24:
                $output[$ys][$xs + 1] = $output[$ys - 1][$xs + 2] =  $output[$ys - 2][$xs + 3] = " ";
                break;
            case 25:
                $output[$ys + 1][$xs] = $output[$ys + 2][$xs + 1] =  $output[$ys + 3][$xs + 2] = " ";
                break;
        }
    }
    
    echo implode(" ", $quantities) . PHP_EOL;
    echo implode("\n", $output) . PHP_EOL;
}

//We are solving by using https://en.wikipedia.org/wiki/Knuth%27s_Algorithm_X
function solve(string $floor, array $pieces, array $positions, array $counts, array $availabilities, float $price, array $list = []): array {
    
    static $history = [], $bestLocalPrice = INF;
    global $piecesType, $prices, $calls, $output;
    $debug = false;
    
    if($debug) error_log($floor . " " . implode("-", $list));
    
    $results = [];
    $hashAvailabilities = implode("-", $availabilities);
    $positionsLeft = count($positions);
    
    //The matrix is empty we have found a solution
    if($positionsLeft == 0) {
        //echo "We found a solution!!! $price -- " . PHP_EOL;
    
        $bestLocalPrice = min($bestLocalPrice, $price);
        
        //if($index == 1023.80) generateOutput($output, $list);
        
        return [strval($price) => [$hashAvailabilities => 1]];
    }
    
    if(isset($history[$floor][$hashAvailabilities])) {
        //error_log("!!!!!!! history $floor $hashAvailabilities");
        return $history[$floor][$hashAvailabilities];
    }
    
    $piecesToAdd = $positionsLeft / 4;
    $minAdditionalPrice = 0.0;
    
    foreach($prices as $i => $v) {
        $min = ($availabilities[$i] > $piecesToAdd) ? $piecesToAdd : $availabilities[$i];
    
        $minAdditionalPrice += $v * $min;
        
        if(($piecesToAdd -= $min) == 0) break;
    }
    
    if($price + $minAdditionalPrice > $bestLocalPrice) {
        //error_log("!!!!!!! too expensive " . ($price + $minAdditionalPrice) . " > " . $bestLocalPrice);
        return $results;
    }
    
    ++$calls;
    
    //Get the lowest number of 1s in any column and the index of the first column with the lowest number
    $min = INF;
    $position = 0;
    foreach($counts as $i => $v) {
        if($v < $min) {
            $min = $v;
            $position = $i;
        }
    }
    
    //The lowest number of 1s is zero => invalid
    if($min == 0) return $results;
    
    if($debug) error_log("working on $position with $min");
    
    foreach ($positions[$position] as $pieceID) {
    
        if($debug) error_log("at $position we can use the piece $pieceID");
    
        $pieceType = intdiv($piecesType[$pieceID], 4);
        
        if($availabilities[$pieceType] == 0) continue;
        else $availabilities[$pieceType]--;
    
        $piecePrice = $prices[$pieceType];
        
        $list[$pieceID] = 1;
        
        //Copy info for recursive
        $positions2 = $positions;
        $counts2 = $counts;
        $pieces2 = $pieces;
        $floor2 = $floor;
        
        //Foreach columns that have a 1 in the row we are testing we need to remove them
        foreach($pieces2[$pieceID] as $positionID) {
    
            //if($debug) error_log("piece $pieceID is affecting the position $positionID");
    
            $floor2[$positionID] = "#";
            
            if(!isset($positions2[$positionID])) continue;
            
            //Foreach rows that have a 1 in the column we are removing we need to remove them
            foreach($positions2[$positionID] as $pieceID2) {
    
                //if($debug) error_log("at position $positionID we need to invalid piece $pieceID2");
                
                if(!isset($pieces2[$pieceID2])) continue; //Row was already removed
                
                //Foreach columns that have a 1 in the row we are removing we need to update the count and remove the row from it's 1 position
                foreach($pieces2[$pieceID2] as $positionID2) {
    
                    //if($debug) error_log("piece $pieceID2 is updating position $positionID2");
                    
                    --$counts2[$positionID2]; //Update the count of 1s in the column
                    unset($positions2[$positionID2][$pieceID2]); //Remove the row from the position of the 1s in the column
                }
                
                unset($pieces2[$pieceID2]); //Remove the row
            }
            
            unset($positions2[$positionID]); //Remove the column
            unset($counts2[$positionID]); //Column has been removed, we also need to remove the count
            
            if($debug) error_log("unsetting count $positionID");
        }
        
        $solutions = solve($floor2, $pieces2, $positions2, $counts2, $availabilities, $price + $piecePrice, $list);
        
        foreach($solutions as $priceSolution => $listSolutions) {
            foreach ($listSolutions as $index => $count) {
                $results[$priceSolution][$index] = ($results[$priceSolution][$index] ?? 0) + $count;
                
                //if(!isset($results[$priceSolution][$index])) $results[$priceSolution][$index] = [];
                
                //array_push($results[$priceSolution][$index], ...$listPieces);
                //$results[$priceSolution][$index] = array_merge($results[$priceSolution][$index], $listPieces);
            }
        }
    
        //Reset the values
        $availabilities[$pieceType]++;
        unset($list[$pieceID]);
    }
    
    return $history[$floor][$hashAvailabilities] = $results;
}
