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



/*
$floor = [
    "######################",
    "##.......#..#.......##",
    "###......#..#......###",
    "#..#......##......#..#",
    "##..#....#..#....#..##",
    "#....#...#..#...#....#",
    "##....#..#..#..#....##",
    "##.....###..###.....##",
    "#.##..............##.#",
    "#...###........###...#",
    "#......########......#",
    "#......########......#",
    "#...###........###...#",
    "#.##..............##.#",
    "##.....##....##.....##",
    "##....#..#..#..#....##",
    "#....#...#..#...#....#",
    "##..#....#..#....#..##",
    "#..#......##......#..#",
    "#.#......#..#......#.#",
    "##.......#..#.......##",
    "######################",
];

$w = 22;
$h = 22;

$prices = [
    54.51, 96.47, 1.32, 8.10, 94.37, 19.01, 83.60,
];

"#########################################################################################",
"#..........#..........#..........#..........#..........#..........#..........#..........#",
"#..#...#...#...#...#..#..#...#...#...#...#..#..#...#...#...#...#..#..#...#...#...#...#..#",
"#..#..#....#....#..#..#..#..#....#....#..#..#..#..#....#....#..#..#..#..#....#....#..#..#",
"#..#...#...#...#...#..#..#...#...#...#...#..#..#...#...#...#...#..#..#...#...#...#...#..#",
"#..........#..........#..........#..........#..........#..........#..........#..........#",
"#########################################################################################",
*/

$floor = [
"############",
"#..........#",
"#...#...#..#",
"#....#..#..#",
"#...#...#..#",
"#..........#",
"############",
];

$w = 12;
$h = 7;

$prices = [
    55.34,
13.13,
92.59,
66.95,
83.07,
85.98,
84.75,
];

echo implode(" ", $prices) . PHP_EOL;

echo implode("\n", $floor) . PHP_EOL;

$prices = array_map(function($price) {
    return intval($price * 100);
}, $prices);

$floor = implode("", $floor);

asort($prices);
$minPrice = reset($prices);

$pieceID = 0;
$counts = array_fill(0, $w * $h, 0);
$positions = array_fill(0, $w * $h, []);
$piecesType = [];
$output = array_fill(0, $h * 2 + 1, str_repeat(" ", $w * 2 + 1));
$usage = array_fill(0, 7, 0);

$variations = 1;
$price = 0;

$patterns = [
    "#.{" . ($w - 2) . "}#\.#.{" . ($w - 2) . "}#", //A single empty
    
    "##.{" . ($w - 3) . "}#\.\.#.{" . ($w - 3) . "}##", //2 empty horizontally
    "###.{" . ($w - 4) . "}#\.\.\.#.{" . ($w - 4) . "}###", //3 empty horizontally
    
    "###.{" . ($w - 4) . "}#\.\.\.#.{" . ($w - 5) . "}#\.\.\.#.{" . ($w - 4) . "}###", //2*3 empty horizontally
    
    "#.{" . ($w - 2) . "}#\.#.{" . ($w - 3) . "}#\.#.{" . ($w - 2) . "}#", //2 empty vertically
    "#.{" . ($w - 2) . "}#\.#.{" . ($w - 3) . "}#\.#.{" . ($w - 3) . "}#\.#.{" . ($w - 2) . "}#", //3 empty vertically
    
    "##.{" . ($w - 3) . "}#\.\.#.{" . ($w - 4) . "}#\.\.#.{" . ($w - 4) . "}#\.\.#.{" . ($w - 3) . "}#", //3*2 empty vertically
    
    "###.{" . ($w - 4) . "}#\.\.\.#.{" . ($w - 5) . "}#\.\.\.#.{" . ($w - 5) . "}#\.\.\.#.{" . ($w - 4) . "}#", //3*3 empty
];

for($y = 0; $y < $h * 2 + 1; ++$y) {
    for($x = 0; $x < $w * 2 + 1; ++$x) {
        if($y % 2 == 0) $output[$y][$x] = ($x % 2 == 0) ? '+' : '-';
        elseif($x % 2 == 0) $output[$y][$x] = '|';
    }
}

for($index = 0; $index < $h * $w; ++$index) {

    if($floor[$index] == '#') {
        unset($counts[$index]);
        unset($positions[$index]);
        
        $y = intdiv($index, $w);
        $x = $index % $w;
        $output[$y * 2 + 1][$x * 2 + 1] = "#";
        continue;
    }
    
    foreach($tetrominoes as $pieceType => $moves) {
        
        $piecePositions = [];
        $floorWithPiece = $floor;
        
        foreach($moves as [$xm, $ym]) {
            $newIndex = $index + $xm + ($ym * $w);
            
            if($floor[$newIndex] !== '.') continue 2;
            
            $piecePositions[$newIndex] = $newIndex;
            $floorWithPiece[$newIndex] = "#";
        }
        
        /*
        if(preg_match("/" . implode("|", $patterns) . "/", $floorWithPiece)) {
            //error_log("invalid piece $pieceType at $index");
            
            //print_r(str_split($floorWithPiece, $w));
            
            continue;
        }
        */
        
        foreach($piecePositions as $indexPosition) {
           $counts[$indexPosition]++;
           
           $positions[$indexPosition][$pieceID] = $pieceID;
        }
        
        $piecesType[$pieceID] = $pieceType;
        $pieces[$pieceID++] = $piecePositions;
    }
}

foreach($positions as $index => $filler) {
    uksort($positions[$index], function($a, $b) use ($prices, $piecesType) {
        return $prices[intdiv($piecesType[$a], 4)] <=> $prices[intdiv($piecesType[$b], 4)];
    });
}

error_log("we have " . count($pieces) . " pieces for this input");

//Directly set all the positions where we can only use 1 piece
while(($index = key($counts)) !== null) {
    
    if($counts[$index] == 1) {
        $pieceID = array_key_first($positions[$index]);
        
        error_log("we need to set position $index with piece ID $pieceID");
        
        $pieceType = intdiv($piecesType[$pieceID], 4);
        
        $usage[$pieceType]++;
        $price += $prices[$pieceType];
        
        foreach($pieces[$pieceID] as $positionID) {
            
            $floor[$positionID] = "#";
            
            if(!isset($positions[$positionID])) continue;
            
            foreach($positions[$positionID] as $pieceID2) {
                
                if(!isset($pieces[$pieceID2])) continue;
                
                foreach($pieces[$pieceID2] as $positionID2) {
                    
                    --$counts[$positionID2];
                    unset($positions[$positionID2][$pieceID2]);
                }
            }
            
            unset($positions[$positionID]);
            unset($counts[$positionID]);
        }
        
        reset($counts);
    } else next($counts);
}

/*
$bestPrice = INF;
$solutions = solve($hash, $pieces, $positions, $counts, $usage, $price);

$min = min(array_keys($solutions));
echo "The final cost is: $min" . PHP_EOL;
print_r($solutions[$min]);

echo("Calls $calls") . PHP_EOL;
echo(microtime(1) - $start);
exit();
*/

for($index = 0; $index < $h * $w; ++$index) {
    if($floor[$index] == "#") continue;
    
    error_log("We are starting a flood at $index");
    
    //We start flood fill to find all the position we're gonna work on
    $toExplore = [$index];
    $positionsFlood = [];
    $countsFlood = [];
    $piecesFlood = [];
    
    while(count($toExplore)) {
        $index = array_pop($toExplore);
        
        if(isset($positionsFlood[$index])) continue;
        
        $positionsFlood[$index] = $positions[$index];
        $countsFlood[$index] = $counts[$index];
        
        foreach($positions[$index] as $pieceID) $piecesFlood[$pieceID] = $pieces[$pieceID];
        
        foreach([1, -1, $w, -$w] as $move) {
            if($floor[$index + $move] != '.') continue;
            
            $toExplore[] = $index + $move;
        }
    }
    
    error_log("we need to fill " . count($positionsFlood) . " positions");

    $bestPrice = INF;

    $solutions = solve($floor, $piecesFlood, $positionsFlood, $countsFlood, $usage, $price);

    $bestPrice = min(array_keys($solutions));
    
    error_log("The best price after this block is $bestPrice");

    print_r($solutions[$bestPrice]);
    
    if(count($solutions[$bestPrice]) > 1) {
        error_log("There are multiple solutions for this flood, no need to continue");

        print_r($solutions[$bestPrice]);
        exit();
    }
    
    $usage = explode("-", array_key_first($solutions[$bestPrice]));
    $variations *= reset($solutions[$bestPrice]);
    $price = $bestPrice;
    
    foreach($positionsFlood as $index => $filler) $floor[$index] = "#";
}

echo "The final cost is: " . number_format($price / 100, 2, ".", "") . PHP_EOL;
echo "The usage is: " . implode(" ", $usage) . PHP_EOL;
echo "The number of variations is: $variations" . PHP_EOL;

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
function solve(string $floor, array $pieces, array $positions, array $counts, array $usage, int $price, array $list = []): array {
    
    static $history = [];
    global $piecesType, $prices, $minPrice, $calls, $output, $bestPrice;
    $debug = false;
    
    //error_log($floor . " " . implode("-", array_keys($list)));
    
    $results = [];
    $hashUsage = implode("-", $usage);
    $positionsLeft = count($positions);
    
    //The matrix is empty we have found a solution
    if($positionsLeft == 0) {
        if($debug) echo "We found a solution!!! $price -- " . PHP_EOL;
    
        $bestPrice = min($bestPrice, $price);
        
        //if(strval($price) ==  96.1) generateOutput($output, $list);
        
        return [strval($price) => [$hashUsage => 1]];
    }
    
    if(isset($history[$floor][$hashUsage])) {
        //error_log("!!!!!!! history $floor $hashUsage");
        return $history[$floor][$hashUsage];
    }

    if($price + ($minPrice * ($positionsLeft / 4)) > $bestPrice) {
        //error_log("!!!!!!! too expensive " . ($price + $minPrice * $positionsLeft / 4) . " > " . $bestPrice);
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
    
    //error_log("working on $position with $min");
    
    foreach ($positions[$position] as $pieceID) {
    
        // error_log("at $position we can use the piece $pieceID");
    
        $pieceType = intdiv($piecesType[$pieceID], 4);
        
        $usage[$pieceType]++;
    
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
                
                //unset($pieces2[$pieceID2]); //Remove the row
            }
            
            unset($positions2[$positionID]); //Remove the column
            unset($counts2[$positionID]); //Column has been removed, we also need to remove the count
            
            //error_log("unsetting count $positionID");
        }
        
        $solutions = solve($floor2, $pieces2, $positions2, $counts2, $usage, $price + $piecePrice, $list);
        
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
