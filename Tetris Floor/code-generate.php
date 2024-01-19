<?php

//https://fr.wikipedia.org/wiki/Tetris

$start = microtime(1);

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
    "##################################################",
    "#.....#..#..#....###....##....###....#.....#..#..#",
    "#..#......#.#.#...#...#.##.#...#...#.#..#......#.#",
    "#....#.#....#..#..#..#..##..#..#..#..#....#.#....#",
    "#..##...##..#...#...#...##...#...#...#..##...##..#",
    "#...#.#..#..##...#.#....###...#.#....#...#.#..#..#",
    "##....#....###.#..#..#.####.#..#..#.###....#....##",
    "#..#..#.#...#....#.#...###....#.#...##..#..#.#...#",
    "#..##...##..#...#...#...##...#...#...#..##...##..#",
    "#....#.#....#...#.#.#...##...#.#.#...#....#.#....#",
    "#.#......#..#.#...#...#.##.#...#...#.#.#......#..#",
    "#..#..#.....#....###....##....###....#..#..#.....#",
    "##################################################",
    "#.....#..#..#....###....##....###....#.....#..#..#",
    "#..#......#.#.#...#...#.##.#...#...#.#..#......#.#",
    "#....#.#....#..#..#..#..##..#..#..#..#....#.#....#",
    "#..##...##..#...#...#...##...#...#...#..##...##..#",
    "#...#.#..#..##...#.#....###...#.#....#...#.#..#..#",
    "##....#....###.#..#..#.####.#..#..#.###....#....##",
    "#..#..#.#...#....#.#...###....#.#...##..#..#.#...#",
    "#..##...##..#...#...#...##...#...#...#..##...##..#",
    "#....#.#....#...#.#.#...##...#.#.#...#....#.#....#",
    "#.#......#..#.#...#...#.##.#...#...#.#.#......#..#",
    "#..#..#.....#....###....##....###....#..#..#.....#",
    "##################################################",
    "##################################################",
    "#.....#..#..#....###....##....###....#.....#..#..#",
    "#..#......#.#.#...#...#.##.#...#...#.#..#......#.#",
    "#....#.#....#..#..#..#..##..#..#..#..#....#.#....#",
    "#..##...##..#...#...#...##...#...#...#..##...##..#",
    "#...#.#..#..##...#.#....###...#.#....#...#.#..#..#",
    "##....#....###.#..#..#.####.#..#..#.###....#....##",
    "#..#..#.#...#....#.#...###....#.#...##..#..#.#...#",
    "#..##...##..#...#...#...##...#...#...#..##...##..#",
    "#....#.#....#...#.#.#...##...#.#.#...#....#.#....#",
    "#.#......#..#.#...#...#.##.#...#...#.#.#......#..#",
    "#..#..#.....#....###....##....###....#..#..#.....#",
    "##################################################",
    "#.....#..#..#....###....##....###....#.....#..#..#",
    "#..#......#.#.#...#...#.##.#...#...#.#..#......#.#",
    "#....#.#....#..#..#..#..##..#..#..#..#....#.#....#",
    "#..##...##..#...#...#...##...#...#...#..##...##..#",
    "#...#.#..#..##...#.#....###...#.#....#...#.#..#..#",
    "##....#....###.#..#..#.####.#..#..#.###....#....##",
    "#..#..#.#...#....#.#...###....#.#...##..#..#.#...#",
    "#..##...##..#...#...#...##...#...#...#..##...##..#",
    "#....#.#....#...#.#.#...##...#.#.#...#....#.#....#",
    "#.#......#..#.#...#...#.##.#...#...#.#.#......#..#",
    "#..#..#.....#....###....##....###....#..#..#.....#",
    "##################################################",
];
$w = 50;
$h = 50;

$prices = [
    27.70,
6.38,
27.70,
57.31,
69.36,
83.07,
13.50,
];

const USE_OPTIMS = false;

echo implode(" ", $prices) . PHP_EOL;
echo implode("\n", $floor) . PHP_EOL;

$prices = array_map(function($price) {
    return str_replace(".", "", $price);
}, $prices);

$minPrice = min($prices);
$usage = array_fill(0, 7, 0);
$history = [];
$variations = 1;
$price = 0;

//Each "blocks" of empty spaces completely surrounded by walls is independent and can be solved independently
for($y = 0; $y < $h; ++$y) {
    for($x = 0; $x < $w; ++$x) {
        if($floor[$y][$x] == "#") continue;
    
        error_log("We are starting a flood at $x $y");
        
        //We start flood fill to find all the position we're gonna work on
        $toExplore = [[$x, $y]];
        $positions = [];
        $minX = $minY = INF;
        $maxX = $maxY = -INF;
        
        while(count($toExplore)) {
            [$xp, $yp] = array_pop($toExplore);
    
            if($floor[$yp][$xp] == "#") continue;
            else $floor[$yp][$xp] = "#";
            
            $minX = min($xp, $minX);
            $maxX = max($xp, $maxX);
            $minY = min($yp, $minY);
            $maxY = max($yp, $maxY);
            
            $positions[] = [$xp, $yp];
            
            //We can move up, down, left & right
            foreach([[1, 0], [-1, 0], [0, 1], [0, -1]] as [$xm, $ym]) {
                $toExplore[] = [$xp + $xm, $yp + $ym];
            }
        }
    
        error_log("we need to fill " . count($positions) . " positions");
        
        $sizeY = $maxY - $minY + 3;
        $sizeX = $maxX - $minX + 3;
        $blockFloor = array_fill(0, $sizeY, str_repeat("#", $sizeX));
        
        foreach($positions as [$xp, $yp]) $blockFloor[$yp - $minY + 1][$xp - $minX + 1] = ".";
    
        error_log(implode("\n", $blockFloor));
        
        $blockFloor = implode("", $blockFloor);
        
        //If we haven't encountered this type of floor yet, we need to solve it
        if(!isset($history[$blockFloor])) {
            $pieceID = 0;
            $counts = [];
            $pieces = [];
            $positions = [];
            $piecesType = [];
            
            //Get all the pieces that can start at every positions
            for($index = 0; $index < $sizeX * $sizeY; ++$index) {
                
                if($blockFloor[$index] == '#') continue;
                
                foreach(TETROMINOES as $pieceType => $moves) {
                    $piecePositions = [];
                    
                    //Check if this piece could be added here
                    foreach($moves as [$xm, $ym]) {
                        $newIndex = $index + $xm + ($ym * $sizeX);
                        
                        if($blockFloor[$newIndex] !== '.') continue 2;
                        
                        $piecePositions[$newIndex] = $newIndex;
                    }
                    
                    //For each positions this piece would occupy save the info
                    foreach($piecePositions as $indexPosition) {
                        $counts[$indexPosition] = ($counts[$indexPosition] ?? 0) + 1;
                        
                        $positions[$indexPosition][$pieceID] = $pieceID;
                    }
                    
                    $piecesType[$pieceID] = $pieceType;
                    $pieces[$pieceID++] = $piecePositions;
                }
            }
            
            //For each positions where there's a single possibility directly use the piece
            if(USE_OPTIMS) {
                while(($index = key($counts)) !== null) {
        
                    if($counts[$index] == 1) {
                        $pieceID = array_key_first($positions[$index]);
            
                        $pieceType = intdiv($piecesType[$pieceID], 4);
    
                        error_log("we need to set position $index with piece ID $pieceID -- type $pieceType");
            
                        $usage[$pieceType]++;
                        $price += $prices[$pieceType];
            
                        //Work on all the positions of the piece
                        foreach($pieces[$pieceID] as $positionID) {
                
                            $blockFloor[$positionID] = "#";
                
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
            }
            
            //When we work on a position we want to try the cheapest piece first
            foreach($positions as $index => $filler) {
                uksort($positions[$index], function($a, $b) use ($prices, $piecesType) {
                    return $prices[intdiv($piecesType[$a], 4)] <=> $prices[intdiv($piecesType[$b], 4)];
                });
            }
    
            error_log("we have " . count($pieces) . " pieces for this input");
            
            $bestPrice = INF; //Best price for the current block
            
            $solutions = solve($blockFloor, $positions, $counts, array_fill(0, 7, 0), 0.0);
            
            $bestPrice = min(array_keys($solutions));
    
            error_log("The best price after this block is $bestPrice");
    
            print_r($solutions[$bestPrice]);
    
            if(count($solutions[$bestPrice]) > 1) {
                error_log("There are multiple solutions for this flood, no need to continue");
        
                print_r($solutions[$bestPrice]);
                exit();
            }
            
            $history[$blockFloor] = [$bestPrice, array_key_first($solutions[$bestPrice]), reset($solutions[$bestPrice])];
        }
        
        //Update the global results
        foreach(explode("-", $history[$blockFloor][1]) as $i => $v) $usage[$i] += $v;
        $variations *= $history[$blockFloor][2];
        $price += $history[$blockFloor][0];
    
        echo(microtime(1) - $start) . PHP_EOL;
    }
}

echo "The final cost is: " . number_format($price / 100, 2, ".", "") . PHP_EOL;
echo "The usage is: " . implode(" ", $usage) . PHP_EOL;
echo "The number of variations is: $variations" . PHP_EOL;

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
function solve(string $floor, array $positions, array $counts, array $usage, int $price, array $list = []): array {
    
    static $history = [];
    global $pieces, $piecesType, $prices, $minPrice, $output, $bestPrice;
    
    $results = [];
    $hashUsage = implode("-", $usage);
    $positionsLeft = count($positions);
    
    //The matrix is empty we have found a solution
    if($positionsLeft == 0) {
        $bestPrice = min($bestPrice, $price);
        
        //if($price ==  86803) generateOutput($output, $list);
        
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
        
        $solutions = solve($floor2, $positions2, $counts2, $usage, $price + $prices[$pieceType], $list);
        
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
