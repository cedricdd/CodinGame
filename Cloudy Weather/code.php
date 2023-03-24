<?php

$start = microtime(1);

const MOVES = [
    8 => ["L" => 4, "U" => 2, "R" => 8, "D" => 8],
    4 => ["L" => 4, "U" => 1, "R" => 8, "D" => 4],
    2 => ["L" => 1, "U" => 2, "R" => 2, "D" => 8],
    1 => ["L" => 1, "U" => 1, "R" => 2, "D" => 4],
];

const TOP = 12; //1000 or 0100 => 1100 => 12
const BOTTOM = 3; //0010 or 0001 => 0011 => 3
const RIGHT = 5; //0100 or 0001 => 0101 => 5;
const LEFT = 10; //1000 or 0010 => 1010 => 10;

//Get the size of the map needed to contain all the clouds
function getMapSize(array $clouds): array {
    $maxX = $maxY = -INF;
    $minX = $minY = INF;
    
    foreach($clouds as [$x, $y, $w, $h, $c]) {
        if($x < $minX) $minX = $x;
        if($x + $w > $maxX) $maxX = $x + $w;
        if($y < $minY) $minY = $y;
        if($y + $h > $maxY) $maxY = $y + $h;
    }
    
    return [($maxX - $minY + 2), ($maxY - $minY + 2)];
}

//We get all the positions where the robot can't move
function generateShade(array $clouds): array {
    
    foreach($clouds as [$x, $y, $w, $h, $c]) {
        if($c == "S") {
            $start = ["x" => $x, "y" => $y];
        }
        elseif($c == "E") {
            $end = ["x" => $x, "y" => $y];
        }
        else {
            for($y2 = $y; $y2 < $y + $h; ++$y2) {
                for($x2 = $x; $x2 < $x + $w; ++$x2) {
                    $shade[$y2][$x2] = 1;
                }
            }
        }
    }
    
    return [$shade, $start, $end];
}

//Reduce the number of lines in the map
function reduceLines(array $clouds): array {

    usort($clouds, function($a, $b) {
        if($a[1] == $b[1]) return $b[0] <=> $a[0];
        else return $b[1] <=> $a[1];
    });
    
    [$x, $y, $w, $h, $c] =  array_pop($clouds);
    $newLine = 1;
    $oldLine = $y;
    $newClouds = [];
    $rows = [];
    $toAdd = [[$x, $w, $h, $c]];
    
    while(true) {
        //How many lines do we have before the next cloud is starting
        if(count($clouds)) {
            [$x, $y, $w, $h, $c] = array_pop($clouds);
            $space = $y - $oldLine;
        } else $space = INF;
        
        while($space > 0) {
            //We have some cloud to work on
            if(count($toAdd)) {
                $height = $space;
                
                //Get the min height among the clouds we are working on
                foreach($toAdd as [, , $h2,]) {
                    $height = min($height, $h2);
                }
                
                //For all the clouds we are working on, we merge $height lines
                foreach($toAdd as $i => [$x2, $w2, $h2, $c2]) {
                    $newClouds[$newLine . "-" . $x2 . "-" . $w2] = [$x2, $newLine, $w2, 1, $c2];
                    
                    if(($toAdd[$i][2] -= $height) == 0) unset($toAdd[$i]);
                }
                
                $rows[$newLine++] = $height;
                $space -= $height;
            } //We are just merging empty lines
            else {
                if(count($clouds) == 0) break 2;
                else {
                    $rows[$newLine++] = $space;
                    break;
                }
            }
        }
        
        $toAdd[] = [$x, $w, $h, $c];
        $oldLine = $y;
    }
    
    $rows = array_merge([1], $rows, [1]); 
    
    //We try to merge the newly created clouds
    foreach($newClouds as $index => [$x, $y, $w, $h, $c]) {
        if(!isset($newClouds[$index])) continue; //We have merged this cloud previously
        
        $shift = 1;
        
        while(true) {
            $nextIndex = ($y + $shift++) . "-" . $x . "-" . $w;
            
            if(!isset($newClouds[$nextIndex])) break;
            
            $newClouds[$index][3]++;
            
            unset($newClouds[$nextIndex]);
        }
        
    }
    
    return [$newClouds, $rows];
}

//Reduce the number of columns in the map
function reduceColumns(array $clouds): array {

    usort($clouds, function($a, $b) {
        if($a[0] == $b[0]) return $b[1] <=> $a[1];
        else return $b[0] <=> $a[0];
    });
    
    [$x, $y, $w, $h, $c] =  array_pop($clouds);
    $newColumn = 1;
    $oldColumn = $x;
    $newClouds = [];
    $cols = [];
    $toAdd = [[$y, $w, $h, $c]];
    
    while(true) {
        //How many columns do we have before the next cloud is starting
        if(count($clouds)) {
            [$x, $y, $w, $h, $c] = array_pop($clouds);
            $space = $x - $oldColumn;
        } else $space = INF;
    
        while($space > 0) {
             //We have some cloud to work on
            if(count($toAdd)) {
                $width = $space;
                
                //Get the min width among the clouds we are working on
                foreach($toAdd as [, $w2, ,]) {
                    $width = min($width, $w2);
                }
                
                //For all the clouds we are working on, we merge $width cols
                foreach($toAdd as $i => [$y2, $w2, $h2, $c2]) {
                    $newClouds[$newColumn . "-" . $y2 . "-" . $h2] = [$newColumn, $y2, 1, $h2, $c2];
                    
                    if(($toAdd[$i][1] -= $width) == 0) unset($toAdd[$i]);
                }
                
                $cols[$newColumn++] = $width;
                $space -= $width;
            } //We are just merging empty lines
            else {
                if(count($clouds) == 0) break 2;
                else {
                    $cols[$newColumn++] = $space;
                    break;
                }
            }
        }
        
        $toAdd[] = [$y, $w, $h, $c];
        $oldColumn = $x;
    }
    
    $cols = array_merge([1], $cols, [1]);
    
    //We try to merge the newly created clouds
    foreach($newClouds as $index => [$x, $y, $w, $h, $c]) {
        if(!isset($newClouds[$index])) continue; //We have merged this cloud previously
        
        $shift = 1;
        
        while(true) {
            $nextIndex = ($x + $shift++) . "-" . $y . "-" . $h;
            
            if(!isset($newClouds[$nextIndex])) break;
            
            $newClouds[$index][2]++;
            
            unset($newClouds[$nextIndex]);
        }
        
    }
    
    return [$newClouds, $cols];
}


fscanf(STDIN, "%d %d", $xs, $ys);
fscanf(STDIN, "%d %d", $xd, $yd);
fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d %d %d", $xi, $yi, $wi, $hi);

    $clouds[] = [$xi, $yi, $wi, $hi, "#"];
}

$clouds[] = [$xs, $ys, 1, 1, "S"];
$clouds[] = [$xd, $yd, 1, 1, "E"];

[$clouds, $rows] = reduceLines($clouds);
[$clouds, $cols] = reduceColumns($clouds);

error_log("End Compressing " . (microtime(1) - $start));

[$shade, $s, $end] = generateShade($clouds);
[$width, $height] = getMapSize($clouds);

$queue[] = [[$s["x"], $s["y"], 1, 0]];
$priority = 0;

while(true) {   

    //We have checked all the position with the current priority
    if(count($queue[$priority]) == 0) {
        unset($queue[$priority]);

        $priority = min(array_keys($queue)); //Get the next priority to check
    }

    [$x, $y, $position, $count] = array_pop($queue[$priority]);

    if(isset($shade[$y][$x])) continue;
    else $shade[$y][$x] = 1; //We don't want to move there anymore

    if($x == $end["x"] && $y == $end["y"]) {
        echo $count . PHP_EOL;
        error_log("Found Solution " . (microtime(1) - $start));
        exit();
    }
    
    //Going UP
    if($y > 0 && !isset($shade[$y - 1][$x])) {
        $newCount = $count + (($position & TOP) ? 1 : $rows[$y]);
        $newPriority = $newCount +  abs($x - $end["x"]) + abs($y - 1 - $end["y"]);

        $queue[$newPriority][] = [$x, $y - 1, MOVES[$position]["U"], $newCount];
    }
    //Going DOWN
    if($y < $height - 1 && !isset($shade[$y + 1][$x])) {
        $newCount = $count + (($position & BOTTOM) ? 1 : $rows[$y]);
        $newPriority = $newCount + abs($x - $end["x"]) + abs($y + 1 - $end["y"]);

        $queue[$newPriority][] = [$x, $y + 1, MOVES[$position]["D"], $newCount];
    }
    //Going LEFT
    if($x > 0 && !isset($shade[$y][$x - 1])) {
        $newCount = $count + (($position & LEFT) ? 1 : $cols[$x]);
        $newPriority = $newCount + abs($x - 1 - $end["x"]) + abs($y - $end["y"]);

        $queue[$newPriority][] = [$x - 1, $y, MOVES[$position]["L"], $newCount];
    }
    //Going RIGHT
    if($x < $width - 1 && !isset($shade[$y][$x + 1])) {
        $newCount = $count + (($position & RIGHT) ? 1 : $cols[$x]);
        $newPriority = $newCount + abs($x + 1 - $end["x"]) + abs($y - $end["y"]);

        $queue[$newPriority][] = [$x + 1, $y, MOVES[$position]["R"], $newCount];
    }
}
