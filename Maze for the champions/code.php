<?php

const CARDINALS = [[1, 0, ">"], [-1, 0, "<"], [0, 1, "v"], [0, -1, "^"]];
const DIAGONALS = [[-1, -1, "o"], [1, -1, "o"], [-1, 1, "o"], [1, 1, "o"]];

function solveWarrior(int $startX, int $startY, int $endX, int $endY): array {

    global $W, $H, $map;

    $toCheck = [[$startX, $startY, 2, 0, []]];
    $visited = [];

    while(count($toCheck)) {
        $newCheck = [];

        foreach($toCheck as [$x, $y, $score, $turn, $list]) {

            if($x == $endX && $y == $endY) return ["WARRIOR", $score, $list];

            if(isset($visited[$y][$x])) continue; //Warrior was already here
            else $visited[$y][$x] = 1;

            //Warrior can simply move in the 4 cardinal directions
            foreach(CARDINALS as [$xm, $ym, $direction]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $W && $yu >= 0 && $yu < $H && $map[$yu][$xu] != "#") {
                    $list[$turn] = [$x, $y, $direction];
                    $newCheck[] = [$xu, $yu, $score + 2, $turn + 1, $list];
                }
            }
        }

        $toCheck = $newCheck;
    }

    return ["WARRIOR", INF, []];
}

function solveElf(int $startX, int $startY, int $endX, int $endY): array {

    global $W, $H, $map;
    
    $toCheck = [[$startX, $startY, 4, 0, []]];
    $visited = [];

    while(count($toCheck)) {
        $newCheck = [];

        foreach($toCheck as [$x, $y, $score, $turn, $list]) {

            if($x == $endX && $y == $endY) return ["ELF", $score, $list];

            if(isset($visited[$y][$x])) continue; //Elf was already here
            else $visited[$y][$x] = 1;

            //Elf can move in the 4 cardinal directions + the 4 diagonal directions (except for the first turn)
            foreach(array_merge(CARDINALS, (($turn > 0) ? DIAGONALS : [])) as [$xm, $ym, $direction]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $W && $yu >= 0 && $yu < $H && $map[$yu][$xu] != "#") {
                    $list[$turn] = [$x, $y, $direction];
                    $newCheck[] = [$xu, $yu, $score + 4, $turn + 1, $list];
                }
            }
        }

        $toCheck = $newCheck;
    }

    return ["ELF", INF, []];
}

function solveDwarf(int $startX, int $startY, int $endX, int $endY): array {

    global $W, $H, $map;
    
    $toCheck = [[$startX, $startY, 3, 0, []]];
    $visited = [];

    while(count($toCheck)) {
        $newCheck = [];

        foreach($toCheck as [$x, $y, $score, $turn, $list]) {

            if($x == $endX && $y == $endY) return ["DWARF", $score, $list];

            if(isset($visited[$y][$x])) continue; //Dwarf was already here
            else $visited[$y][$x] = 1;

            //Dwarf can move in the 4 cardinal directions & break walls
            foreach(CARDINALS as [$xm, $ym, $direction]) {
                $x1 = $x + $xm;
                $y1 = $y + $ym;
                $x2 = $x1 + $xm;
                $y2 = $y1 + $ym;

                if($x1 >= 0 && $x1 < $W && $y1 >= 0 && $y1 < $H && ($map[$y1][$x1] != "#" || ($x2 > 0 && $x2 < $W && $y2 > 0 && $y2 < $H && $map[$y2][$x2] == "."))) {
                    $list[$turn] = [$x, $y, $direction];
                    $newCheck[] = [$x1, $y1, $score + 3, $turn + 1, $list];
                }
            }
        }

        $toCheck = $newCheck;
    }

    return ["DWARF", INF, []];
}

function solveMage(int $startX, int $startY, int $endX, int $endY): array {

    global $W, $H, $map;

    $toCheck = [[$startX, $startY, 5, 0, []]];
    $visited = [];

    while(count($toCheck)) {
        $newCheck = [];

        foreach($toCheck as [$x, $y, $score, $turn, $list]) {

            if($x == $endX && $y == $endY) return ["MAGE", $score, $list];

            if(isset($visited[$y][$x]) && $visited[$y][$x] < $turn) continue; //Mage was already here with a better score
            else $visited[$y][$x] = $turn;

            //Right
            if($x < $W - 1 && $map[$y][$x + 1] != "#") {
                $xu = $x + 1;

                do {
                    //Find all the position the mage might stop (an empty cell at the top or bottom)
                    if($xu == $W - 1 || $map[$y + 1][$xu] != "#" || $map[$y - 1][$xu] != "#") {
                        $list[$turn] = [$x, $y, ">"];
                        $newCheck[] = [$xu, $y, $score + 5, $turn + 1, $list];
                    }

                    $xu += 1; 
                } while($xu < $W && $map[$y][$xu] != "#");
            }

            //Left
            if($x > 0 && $map[$y][$x - 1] != "#") {
                $xu = $x - 1;

                do {
                    //Find all the position the mage might stop (an empty cell at the top or bottom)
                    if($xu == 0 || $map[$y + 1][$xu] != "#" || $map[$y - 1][$xu] != "#") { 
                        $list[$turn] = [$x, $y, "<"];
                        $newCheck[] = [$xu, $y, $score + 5, $turn + 1, $list];
                    }

                    $xu -= 1; 
                } while($xu >= 0 && $map[$y][$xu] != "#"); 
            }

            //Bottom
            if($y < $H - 1 && $map[$y + 1][$x] != "#") {
                $yu = $y + 1;

                do {
                    //Find all the position the mage might stop (an empty cell at the left or right)
                    if($yu == $H - 1 || $map[$yu][$x + 1] != "#" || $map[$yu][$x - 1] != "#") {
                        $list[$turn] = [$x, $y, "v"];
                        $newCheck[] = [$x, $yu, $score + 5, $turn + 1, $list];
                    }

                    $yu += 1; 
                } while($yu < $H && $map[$yu][$x] != "#");
            }

            //Top
            if($y > 0 && $map[$y - 1][$x] != "#") {
                $yu = $y - 1;

                do {
                     //Find all the position the mage might stop (an empty cell at the left or right)
                    if($yu == 0 || $map[$yu][$x + 1] != "#" || $map[$yu][$x - 1] != "#") {
                        $list[$turn] = [$x, $y, "^"];
                        $newCheck[] = [$x, $yu, $score + 5, $turn + 1, $list];
                    }

                    $yu -= 1; 
                } while($yu >= 0 && $map[$yu][$x] != "#");
            }
        }

        $toCheck = $newCheck;
    }

    return ["MAGE", INF, []];
}

$startTime = microtime(1);

fscanf(STDIN, "%d", $W);
fscanf(STDIN, "%d", $H);
for ($y = 0; $y < $H; $y++) {
    fscanf(STDIN, "%s", $line);

    for($x = 0; $x < $W; $x++) {
        if($line[$x] != "#" && $line[$x] != ".") {
            //Find starting & ending positions
            switch($line[$x]) {
                case ">": 
                    if($x == 0)  {
                        [$startX, $startY] = [$x, $y]; 
                        $initDirection = ">";
                    } else [$endX, $endY] = [$x, $y]; 
                    break;
                case "<": 
                    if($x == $W - 1) {
                        [$startX, $startY] = [$x, $y]; 
                        $initDirection = "<";
                    } else [$endX, $endY] = [$x, $y]; 
                    break;
                case "v": 
                    if($y == 0) {
                        [$startX, $startY] = [$x, $y]; 
                        $initDirection = "v";
                    } else [$endX, $endY] = [$x, $y]; 
                    break;
                case "^": 
                    if($y == $H - 1) {
                        [$startX, $startY] = [$x, $y];  
                        $initDirection = "^";
                    } else [$endX, $endY] = [$x, $y]; 
                    break;
            }
        }
    }

    $map[] = $line;
}

error_log(var_export($map, true)); 

$results[] = solveWarrior($startX, $startY, $endX, $endY);
$results[] = solveDwarf($startX, $startY, $endX, $endY);
$results[] = solveElf($startX, $startY, $endX, $endY);
$results[] = solveMage($startX, $startY, $endX, $endY);

//We want the solution that's the fastest
usort($results, function($a, $b) {
    return $a[1] <=> $b[1];
});

[$champion, $score, $list] = array_shift($results);

for($i = 1; $i < count($list); ++$i) {
    [$x, $y, $direction] = $list[$i];

    $map[$y][$x] = $direction;
}

echo $champion . " " . $score . PHP_EOL;
echo implode("\n", $map) . PHP_EOL;

error_log(var_export("It took: " . (microtime(1) - $startTime), true));
