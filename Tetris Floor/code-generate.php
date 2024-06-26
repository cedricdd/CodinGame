<?php

//https://fr.wikipedia.org/wiki/Tetris

$start = microtime(1);

//Function to rotate 90° to the left
function rotateLeft(array $floor): array {
    $rotated = [];
    
    $h = count($floor);
    $w = strlen($floor[0]);
    
    for($x = 0; $x < $w; ++$x) {
        $line = "";
        
        for($y = $h - 1; $y >= 0; --$y) $line .= $floor[$y][$x];
        
        $rotated[] = $line;
    }
    
    return $rotated;
}

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


$floor = [
    "####################################################################################################",
    "#...#.......#..##.......##....#......#......#.#..##...#.......#..##.......##....#......#......#.#..#",
    "#.........#.#.#..#.#....##..##..#..#.#.#.#.......##.........#.#.#..#.#....##..##..#..#.#.#.#.......#",
    "#........#..#......#....###.........##..#..#.#.#.##........#..#......#....###.........##..#..#.#.#.#",
    "#.........#.#....#.....###..#..#....##.........#.##.........#.#....#.....###..#..#....##.........#.#",
    "#.##........#.#.........###...#..#.#.#......#...###.##........#.#.........###...#..#.#.#......#...##",
    "#........#..#...#.......##..#........#.......#...##........#..#...#.......##..#........#.......#...#",
    "#.#.#..#...###...#......##........##.#.........#.##.#.#..#...###...#......##........##.#.........#.#",
    "##....#..#..#.#.........##.#.........##.....#....###....#..#..#.#.........##.#.........##.....#....#",
    "##.........##.#.#.#..#..##..#........#....#......###.........##.#.#.#..#..##..#........#....#......#",
    "#.#..#..##..#.......#.#.##.#.........#....#.#..#.##.#..#..##..#.......#.#.##.#.........#....#.#..#.#",
    "#......#....#..#.#......##.......#...#.......##..##......#....#..#.#......##.......#...#.......##..#",
    "####################################################################################################",
    "#...........##.....#....##......#...##.##........##...........##.....#....##......#...##.##........#",
    "#.....#....##..##.#.....##...........#.....#.##..##.....#....##..##.#.....##...........#.....#.##..#",
    "#..........##.....#.....##.#.#..##.#.#...#.......##..........##.....#.....##.#.#..##.#.#...#.......#",
    "#........#..#..##.......##.#....##.#.#.....#..#..##........#..#..##.......##.#....##.#.#.....#..#..#",
    "##....#.....##.##.......##...........#...........###....#.....##.##.......##...........#...........#",
    "#.##....#.#.#......#..#.##.#.#....##.#.#..#......##.##....#.#.#......#..#.##.#.#....##.#.#..#......#",
    "#...........#...........##.....#....##.......##.###...........#...........##.....#....##.......##.##",
    "#.#.##....#.#..#..#.....##..#........#.......##..##.#.##....#.#..#..#.....##..#........#.......##..#",
    "#.#.##..#.#.#.......#...###..........#.....#.....##.#.##..#.#.#.......#...###..........#.....#.....#",
    "#...........#..##.#.....###....#.....#.....#.##..##...........#..##.#.....###....#.....#.....#.##..#",
    "##...#......#........##.##...........#....#.....####...#......#........##.##...........#....#.....##",
    "####################################################################################################",
    "####################################################################################################",
    "#...#.......#..##.......##....#......#......#.#..##...#.......#..##.......##....#......#......#.#..#",
    "#.........#.#.#..#.#....##..##..#..#.#.#.#.......##.........#.#.#..#.#....##..##..#..#.#.#.#.......#",
    "#........#..#......#....###.........##..#..#.#.#.##........#..#......#....###.........##..#..#.#.#.#",
    "#.........#.#....#.....###..#..#....##.........#.##.........#.#....#.....###..#..#....##.........#.#",
    "#.##........#.#.........###...#..#.#.#......#...###.##........#.#.........###...#..#.#.#......#...##",
    "#........#..#...#.......##..#........#.......#...##........#..#...#.......##..#........#.......#...#",
    "#.#.#..#...###...#......##........##.#.........#.##.#.#..#...###...#......##........##.#.........#.#",
    "##....#..#..#.#.........##.#.........##.....#....###....#..#..#.#.........##.#.........##.....#....#",
    "##.........##.#.#.#..#..##..#........#....#......###.........##.#.#.#..#..##..#........#....#......#",
    "#.#..#..##..#.......#.#.##.#.........#....#.#..#.##.#..#..##..#.......#.#.##.#.........#....#.#..#.#",
    "#......#....#..#.#......##.......#...#.......##..##......#....#..#.#......##.......#...#.......##..#",
    "####################################################################################################",
    "#...........##.....#....##......#...##.##........##...........##.....#....##......#...##.##........#",
    "#.....#....##..##.#.....##...........#.....#.##..##.....#....##..##.#.....##...........#.....#.##..#",
    "#..........##.....#.....##.#.#..##.#.#...#.......##..........##.....#.....##.#.#..##.#.#...#.......#",
    "#........#..#..##.......##.#....##.#.#.....#..#..##........#..#..##.......##.#....##.#.#.....#..#..#",
    "##....#.....##.##.......##...........#...........###....#.....##.##.......##...........#...........#",
    "#.##....#.#.#......#..#.##.#.#....##.#.#..#......##.##....#.#.#......#..#.##.#.#....##.#.#..#......#",
    "#...........#...........##.....#....##.......##.###...........#...........##.....#....##.......##.##",
    "#.#.##....#.#..#..#.....##..#........#.......##..##.#.##....#.#..#..#.....##..#........#.......##..#",
    "#.#.##..#.#.#.......#...###..........#.....#.....##.#.##..#.#.#.......#...###..........#.....#.....#",
    "#...........#..##.#.....###....#.....#.....#.##..##...........#..##.#.....###....#.....#.....#.##..#",
    "##...#......#........##.##...........#....#.....####...#......#........##.##...........#....#.....##",
    "####################################################################################################",
];

$w = 100;
$h = 50;

$toAdd = 0;
while($toAdd) {
    
    do {
        $x = random_int(1, $w - 1);
        $y = random_int(1, $h - 1);
    } while($floor[$y][$x] == "#");
    
    $floor[$y][$x] = "#";
    
    --$toAdd;
}

$prices = [
    81.11, 16.64, 81.55, 10.31, 1.38, 93.48, 40.61,
];

echo implode(" ", $prices) . PHP_EOL;
echo implode("\n", $floor) . PHP_EOL;
echo PHP_EOL . PHP_EOL . PHP_EOL;


//$floor = rotateLeft($floor);
//$floor = rotateLeft($floor);
//foreach($floor2 as $y => $line) $floor[$y] .= $line;
//
//$floor3 = rotateLeft($floor2);
//foreach($floor3 as $y => $line) $floor[$y] .= $line;
//
//$floor4 = rotateLeft($floor3);
//foreach($floor4 as $y => $line) $floor[$y] .= $line;
//
//echo implode("\n", $floor) . PHP_EOL;
//exit();

const USE_OPTIMS = true;

$prices = array_map(function($price) {
    return str_replace(".", "", strval($price));
}, $prices);

//Get all the pieces that can start at every positions
function getPossiblePieces(array $floor, int $w, int $h): array {
    $pieceID = 0;
    $counts = [];
    $pieces = [];
    $positions = [];
    $piecesType = [];
    
    
    for($y = 0; $y < $h; ++$y) {
        for($x = 0; $x < $w; ++$x) {
            if($floor[$y][$x] == '#') continue;
            
            foreach(TETROMINOES as $pieceType => $moves) {
                $piecePositions = [];
                
                //Check if this piece could be added here
                foreach($moves as [$xm, $ym]) {
                    if($floor[$y + $ym][$x + $xm] !== '.') continue 2;
                    
                    $newIndex = (($y + $ym) * $w) + $x + $xm;
                    
                    $piecePositions[$newIndex] = $newIndex;
                }
                
                //For each position this piece would occupy save the info
                foreach($piecePositions as $indexPosition) {
                    $counts[$indexPosition] = ($counts[$indexPosition] ?? 0) + 1;
                    
                    $positions[$indexPosition][$pieceID] = $pieceID;
                }
                
                $piecesType[$pieceID] = $pieceType;
                $pieces[$pieceID++] = $piecePositions;
            }
        }
    }
    
    return [$pieces, $positions, $counts, $piecesType];
}

$minPrice = min($prices);
$usage = array_fill(0, 7, 0);
$history = [];
$variations = 1;
$price = 0;

//For each position where there's a single possibility directly use the piece
if(USE_OPTIMS) {
    [$pieces, $positions, $counts, $piecesType] = getPossiblePieces($floor, $w, $h);
    
    do {
        $pieceAdded = false;
        
        foreach($counts as $index => $count) {
            if($count == 1) {
                if(!isset($positions[$index])) continue;
                
                $pieceID = array_key_first($positions[$index]);
                
                $pieceType = intdiv($piecesType[$pieceID], 4);
                
                error_log("We need to set position $index with piece ID $pieceID -- type $pieceType");
                
                $usage[$pieceType]++;
                $price += $prices[$pieceType];
                
                //Work on all the positions of the piece
                foreach($pieces[$pieceID] as $positionID) {
                    
                    $floor[intdiv($positionID, $w)][$positionID % $w] = "#";
                    
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
                
                $pieceAdded = true;
            }
        }
    } while($pieceAdded);
}

echo implode("\n", $floor) . PHP_EOL;

//Each "blocks" of empty spaces completely surrounded by walls is independent and can be solved independently
for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        if($floor[$y][$x] == "#") continue;
    
        //if($x != 58 || $y != 1) continue;
        
        error_log("We are starting a flood at $x $y");
        
        //We start flood fill to find all the position we're going to work on
        $toExplore = [[$x, $y]];
        
        $minX = $minY = INF;
        $maxX = $maxY = -INF;
    
        $positionsInfo = [];
        $positionsBlock = [];
        $countsBlock = [];
        
        while(count($toExplore)) {
            [$xp, $yp] = array_pop($toExplore);
            
            if($floor[$yp][$xp] == "#") continue;
            else $floor[$yp][$xp] = "#";
            
            $minX = min($xp, $minX);
            $maxX = max($xp, $maxX);
            $minY = min($yp, $minY);
            $maxY = max($yp, $maxY);
            
            $index = $yp * $w + $xp;
    
            $positionsInfo[] = [$xp, $yp];
            
            //We can move up, down, left & right
            foreach([[1, 0], [-1, 0], [0, 1], [0, -1]] as [$xm, $ym]) {
                $toExplore[] = [$xp + $xm, $yp + $ym];
            }
        }
        
        $countPositions = count($positionsInfo);
        
        error_log("we need to fill $countPositions positions");
        
        //We generate the "block" we're going to solve
        $sizeY = $maxY - $minY + 3;
        $sizeX = $maxX - $minX + 3;
        $blockFloor = array_fill(0, $sizeY, str_repeat('#', $sizeX));
        
        foreach($positionsInfo as [$xp, $yp]) {
            $blockFloor[$yp - $minY + 1][$xp - $minX + 1] = ".";
        }
        
        $blockFloorString = implode("", $blockFloor);
    
        if(intdiv($countPositions, 4) != ($countPositions / 4)) {
            print_r(str_split($blockFloorString, $sizeX));
            
            error_log("The number of pieces isn't a multiple of 4");
            exit();
        }
        
        //If we haven't encountered this type of floor yet, we need to solve it
        if(!isset($history[$blockFloorString])) {
    
            [$piecesBlock, $positionsBlock, $countsBlock, $piecesTypeBlock] = getPossiblePieces($blockFloor, $sizeX, $sizeY);
            
            //When we work on a position we want to try the cheapest piece first
            /*
            foreach($positionsBlock as $index => $filler) {
                uksort($positionsBlock[$index], function($a, $b) use ($prices, $piecesTypeBlock) {
                    $priceA = $prices[intdiv($piecesTypeBlock[$a], 4)];
                    $priceB = $prices[intdiv($piecesTypeBlock[$b], 4)];
                    
                    if($priceA == $priceB) return $a <=> $b;
                    else return $priceA <=> $priceB;
                });
            }
            */
    
            print_r(str_split($blockFloorString, $sizeX));
            
            $bestPrice = INF; //Best price for the current block
            
            $solutions = solve($piecesBlock, $piecesTypeBlock, $blockFloorString, $positionsBlock, $countsBlock, array_fill(0, 7, 0), 0.0);
            
            $bestPrice = min(array_keys($solutions));
            
            error_log("The best price after this block is $bestPrice");
            
            print_r($solutions[$bestPrice]);
            
            if(count($solutions[$bestPrice]) > 1) {
                error_log("There are multiple solutions for this flood, no need to continue");
                
                print_r($solutions[$bestPrice]);
                exit();
            }
    
            //Tetris pieces can be rotated so any rotation of the "block" will produce the same results
            for($i = 0; $i < 4; ++$i) {
                $blockFloor = rotateLeft($blockFloor);
                
                $history[implode("", $blockFloor)] = [$bestPrice, array_key_first($solutions[$bestPrice]), reset($solutions[$bestPrice])];
            }
        }
        
        //Update the global results
        foreach(explode("-", $history[$blockFloorString][1]) as $i => $v) $usage[$i] += $v;
        $variations *= $history[$blockFloorString][2];
        $price += $history[$blockFloorString][0];
        
        echo(microtime(1) - $start) . PHP_EOL;
    }
}

echo "The final cost is: " . number_format($price / 100, 2, ".", "") . PHP_EOL;
echo "The usage is: " . implode(" ", $usage) . PHP_EOL;
echo "The number of variations is: $variations" . PHP_EOL;

echo(microtime(1) - $start);

function generateOutput(array $listPieces) {
    global $pieces, $piecesType, $w, $h;
    
    $output = array_fill(0, $h * 2 + 1, str_repeat(" ", $w * 2 + 1));
    
    for($y = 0; $y < $h * 2 + 1; ++$y) {
        for($x = 0; $x < $w * 2 + 1; ++$x) {
            if($y % 2 == 0) $output[$y][$x] = ($x % 2 == 0) ? '+' : '-';
            elseif($x % 2 == 0) $output[$y][$x] = '|';
        }
    }
    
    $quantities = array_fill(0, 7, 0);
    
    foreach($listPieces as $pieceID => $filler) {
        $position = reset($pieces[$pieceID]);
        
        $quantities[intdiv($piecesType[$pieceID], 4)]++;
        
        $xs = ($position % $w) * 2 + 1;
        $ys = intdiv($position, $w) * 2 + 1;
        
        //error_log("$xs $ys " . $piecesType[$pieceID]);
        
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
function solve(array &$pieces, array &$piecesType, string $floor, array $positions, array $counts, array $usage, int $price, array $list = []): array {
   
    static $history = [];
    global $prices, $minPrice, $bestPrice;
    
    $results = [];
    $hashUsage = implode("-", $usage);
    $positionsLeft = count($positions);
    
    //The matrix is empty we have found a solution
    if($positionsLeft == 0) {
        $bestPrice = min($bestPrice, $price);
        
        //if($price == 55610) generateOutput($list);
        
        return [strval($price) => [$hashUsage => 1]];
    }
    
    if(USE_OPTIMS && isset($history[$floor][$hashUsage])) {
        return $history[$floor][$hashUsage];
    }
    
    if(USE_OPTIMS && $price + ($minPrice * ($positionsLeft / 4)) > $bestPrice) {
        return $results;
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
    
    if($min == 0) return $results;
    
    foreach ($positions[$position] as $pieceID) {
        
        $pieceType = intdiv($piecesType[$pieceID], 4);
        
        $usage[$pieceType]++;
        
        $list[$pieceID] = 1;
        
        //Copy info for recursive
        $positions2 = $positions;
        $counts2 = $counts;
        $floor2 = $floor;
        
        foreach($pieces[$pieceID] as $positionID) {
            
            $floor2[$positionID] = "#";
            
            if(!isset($positions2[$positionID])) continue;
            
            foreach($positions2[$positionID] as $pieceID2) {
                foreach($pieces[$pieceID2] as $positionID2) {
                    --$counts2[$positionID2];
                    unset($positions2[$positionID2][$pieceID2]);
                }
            }
            
            unset($positions2[$positionID]);
            unset($counts2[$positionID]);
        }
        
        $solutions = solve($pieces, $piecesType, $floor2, $positions2, $counts2, $usage, $price + $prices[$pieceType], $list);
        
        foreach($solutions as $priceSolution => $listSolutions) {
            foreach ($listSolutions as $index => $count) {
                $results[$priceSolution][$index] = ($results[$priceSolution][$index] ?? 0) + $count;
            }
        }
        
        //Reset the values
        $usage[$pieceType]--;
        unset($list[$pieceID]);
    }
    
    return $history[$floor][$hashUsage] = $results;
}
