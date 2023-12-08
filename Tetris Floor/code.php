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

$grid = [
    "#........#",
    ".#......#.",
    "..#....#..",
    "...#..#...",
    "....##....",
    "....##....",
    "...#..#...",
    "..#....#..",
    ".#......#.",
    "#........#",
];

$w = 10;
$h = 10;

$grid = [
    ".....",
    ".....",
    "..#..",
    ".....",
    ".....",
];

$w = 5;
$h = 5;

/*
$grid = [
    "......",
    "......",
    "......",
    "......",
];

$w = 6;
$h = 4;
*/

$availabilities = [
    10,
    10,
    10,
    10,
    10,
    10,
    10,
];

$prices = [
  10.0,
  10.0,
  10.0,
  10.0,
  10.0,
  1.0,
  1.0,
];

$lowestPrice = min($prices);
$pieceID = 0;
$counts = array_fill(0, $w * $h, 0);
$positions = array_fill(0, $w * $h, []);
$piecesType = [];
$nbrPieces = 0;
$bestPrice = INF;
$bestList = [];
$output = array_fill(0, $h * 2 + 1, str_repeat(" ", $w * 2 + 1));

for($y = 0; $y < $h * 2 + 1; ++$y) {
    for($x = 0; $x < $w * 2 + 1; ++$x) {
        if($y % 2 == 0) $output[$y][$x] = ($x % 2 == 0) ? '+' : '-';
        elseif($x % 2 == 0) $output[$y][$x] = '|';
    }
}

for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        if($grid[$y][$x] === '#') {
            $index = $y * $w + $x;
            
            unset($counts[$index]);
            unset($positions[$index]);
            
            $output[$y * 2 + 1][$x * 2 + 1] = "#";
            
            continue;
        }
    
        $nbrPieces++;
        
        foreach($tetrominoes as $pieceType => $moves) {
            
            $piecePositions = [];
            
            if($availabilities[intdiv($pieceType, 4)] == 0) continue;
            
            foreach($moves as [$xm, $ym]) {
                $xu = $x + $xm;
                $yu = $y + $ym;
                
                if($xu < 0 || $xu >= $w || $yu < 0 || $yu >= $h || $grid[$yu][$xu] !== '.') continue 2;
    
                $index = $yu * $w + $xu;
                $piecePositions[$index] = $index;
            }
            
            //echo "at $x $y we can have a piece $i" . PHP_EOL;
            
            foreach($piecePositions as $index) {
               $counts[$index]++;
               
               $positions[$index][$pieceID] = $pieceID;
            }
            
            $piecesType[$pieceID] = $pieceType;
            $pieces[$pieceID++] = $piecePositions;
        }
    }
}

$nbrPieces /= 4;


foreach($positions as $index => $filler) {
    uksort($positions[$index], function($a, $b) use ($prices, $piecesType) {
        return $prices[intdiv($piecesType[$a], 4)] <=> $prices[intdiv($piecesType[$b], 4)];
    });
}

error_log("we have " . count($pieces) . " pieces for this input");

function generateOutput(array $listPieces) {
    global $pieces, $piecesType, $w, $h;
    
    $output = array_fill(0, $h, str_repeat("#", $w));
    
    foreach($listPieces as $pieceID) {
        foreach($pieces[$pieceID] as $position) {
            $x = $position % $w;
            $y = intdiv($position, $w);
            
            $output[$y][$x] = $piecesType[$pieceID];
        }
    }
    
    echo implode("\n", $output) . PHP_EOL;
}

function generateOutput2(array $output, array $listPieces) {
    global $pieces, $piecesType, $w, $h;
    
    foreach($listPieces as $pieceID) {
        $position = reset($pieces[$pieceID]);
        
        $xs = ($position % $w) * 2 + 1;
        $ys = intdiv($position, $w) * 2 + 1;
        
        error_log("piece $pieceID is of type " . $piecesType[$pieceID] . " -- start at $xs $ys");
        
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
    
    echo implode("\n", $output) . PHP_EOL;
}

//We are solving by using https://en.wikipedia.org/wiki/Knuth%27s_Algorithm_X
function solve(array $pieces, array $positions, array $counts, array $availabilities, int $nbrPieces, array $list, float $price) {
    
    global $piecesType, $prices, $lowestPrice, $bestList, $bestPrice;
    $debug = false;
    
    if($debug) error_log($nbrPieces . " " . implode("-", $list));
    
    //The matrix is empty we have found a solution
    if($nbrPieces == 0) {
        echo "We found a solution!!! $price -- " . PHP_EOL;
        
        //We have a new best price, reset the list of solutions
        if($bestPrice != $price) $bestList = [];
    
        $bestList[] = $list;
        $bestPrice = $price;
        
        return;
    }
    
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
    if($min == 0) return;
    
    if($debug) error_log("working on $position with $min");
    
    //Foreach rows that have a 1 in the column we have just selected
    foreach ($positions[$position] as $pieceID) {
    
        if($debug) error_log("at $position we can use the piece $pieceID");
    
        $pieceType = intdiv($piecesType[$pieceID], 4);
        
        if($availabilities[$pieceType] == 0) continue;
        else $availabilities[$pieceType]--;
    
        $piecePrice = $prices[$pieceType];
        
        if($price + $piecePrice + ($nbrPieces - 1 * $lowestPrice) > $bestPrice) continue;
        
        $list[$nbrPieces] = $pieceID;
        
        //Copy info for recursive
        $positions2 = $positions;
        $counts2 = $counts;
        $pieces2 = $pieces;
        
        //Foreach columns that have a 1 in the row we are testing we need to remove them
        foreach($pieces2[$pieceID] as $positionID) {
    
            //if($debug) error_log("piece $pieceID is affecting the position $positionID");
            
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
        
        solve($pieces2, $positions2, $counts2, $availabilities, $nbrPieces - 1, $list, $price + $piecePrice);
    
        $availabilities[$pieceType]++;
    }
}

solve($pieces, $positions, $counts, $availabilities, $nbrPieces, [], 0.0);

error_log("we have " . count($bestList) . " solutions with $bestPrice");

foreach($bestList as $list) {
    //generateOutput($list);
    generateOutput2($output, $list);
}

error_log(microtime(1) - $start);
