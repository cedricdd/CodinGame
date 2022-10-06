<?php

const CARDINALS = [[1, 0, ">"], [-1, 0, "<"], [0, 1, "v"], [0, -1, "^"]];
const DIAGONALS = [[-1, -1, "o"], [1, -1, "o"], [-1, 1, "o"], [1, 1, "o"]];

function solveWarrior(array $start, array $end): array {

    global $W, $H, $map;

    $toCheck = [[$start, 2, []]];
    $visited = [];
    //$test = false;

    while(count($toCheck)) {
        $newCheck = [];

        foreach($toCheck as [$position, $score, $list]) {

            //error_log("we are at " . implode("-", $position) . " -- score $score"); 

            if($position == $end) {
                //$test = true;
                //error_log("found one Warrior $score"); 
                return ["WARRIOR", $score, $list];
            }

            [$x, $y] = $position;

            $step = count($list);

            if(isset($visited[$y][$x])) continue;
            else $visited[$y][$x] = $step;

            foreach(CARDINALS as [$xm, $ym, $direction]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if(($xu >= 0 && $xu < $W && $yu >= 0 && $yu < $H) && $map[$yu][$xu] != "#") {
                    $list[$step] = [$x, $y, $direction];
                    $newCheck[] = [[$xu, $yu], $score + 2, $list];
                }
            }
        }

        //if($test) break;
        $toCheck = $newCheck;
    }

    return ["WARRIOR", INF, []];
}

function solveElf(array $start, array $end): array {

    global $W, $H, $map;
    
    $toCheck = [[$start, 4, []]];
    $visited = [];
    //$test = false;

    while(count($toCheck)) {
        $newCheck = [];

        foreach($toCheck as [$position, $score, $list]) {

            //error_log("we are at " . implode("-", $position) . " -- score $score"); 

            if($position == $end) {
                //$test = true;
                //error_log("found one Elf $score"); 
                return ["ELF", $score, $list];
            }

            [$x, $y] = $position;

            $step = count($list);

            if(isset($visited[$y][$x])) continue;
            else $visited[$y][$x] = $step;

            foreach(array_merge(CARDINALS, (($step > 0) ? DIAGONALS : [])) as [$xm, $ym, $direction]) {
                $xu = $x + $xm;
                $yu = $y + $ym;

                if($xu >= 0 && $xu < $W && $yu >= 0 && $yu < $H && $map[$yu][$xu] != "#") {

                    //error_log("can move to $xu $yu"); 

                    $list[$step] = [$x, $y, $direction];
                    $newCheck[] = [[$xu, $yu], $score + 4, $list];
                }
            }
        }

        //if($test) break;
        $toCheck = $newCheck;
    }

    return ["ELF", INF, []];
}

function solveDwarf(array $start, array $end): array {

    global $W, $H, $map;
    
    $toCheck = [[$start, 3, []]];
    $visited = [];
    //$test = false;

    while(count($toCheck)) {
        $newCheck = [];

        foreach($toCheck as [$position, $score, $list]) {

            //error_log("we are at " . implode("-", $position) . " -- score $score"); 

            if($position == $end) {
                //$test = true;
                //error_log("found one Dward $score"); 
                return ["DWARF", $score, $list];
            }

            [$x, $y] = $position;

            $step = count($list);

            if(isset($visited[$y][$x])) continue;
            else $visited[$y][$x] = $step;

            
            foreach(CARDINALS as [$xm, $ym, $direction]) {
                $x1 = $x + $xm;
                $y1 = $y + $ym;
                $x2 = $x1 + $xm;
                $y2 = $y1 + $ym;

                if(($x1 >= 0 && $x1 < $W && $y1 >= 0 && $y1 < $H) && ($map[$y1][$x1] != "#" || ($x2 > 0 && $x2 < $W && $y2 > 0 && $y2 < $H && $map[$y2][$x2] == "."))) {
                    $list[$step] = [$x, $y, $direction];
                    $newCheck[] = [[$x1, $y1], $score + 3, $list];
                }
            }
        }

        //if($test) break;
        $toCheck = $newCheck;
    }

    return ["DWARF", INF, []];
}

function solveMage(array $start, array $end): array {

    global $W, $H, $map;

    $toCheck = [[$start, 5, []]];
    $visited = [];
    //$test = false;

    while(count($toCheck)) {
        $newCheck = [];

        foreach($toCheck as [$position, $score, $list]) {

            if($position == $end) {
                //$test = true;
                //error_log("found one Mage $score"); 
                return ["MAGE", $score, $list];
            }

            [$x, $y] = $position;

            $step = count($list);

            if(isset($visited[$y][$x]) && $visited[$y][$x] < $step) continue;
            else $visited[$y][$x] = $step;

           // error_log("we are at " . implode("-", $position) . " -- score $score"); 

            //Right
            if($x < $W - 1 && $map[$y][$x + 1] != "#") {
                $xu = $x + 1;

                do {
                    if($xu == $W - 1 || $map[$y + 1][$xu] != "#" || $map[$y - 1][$xu] != "#") {
                        $list[$step] = [$x, $y, ">"];
                        $newCheck[] = [[$xu, $y], $score + 5, $list];
                    }

                    $xu += 1; 
                } while($xu < $W && $map[$y][$xu] != "#");
            }

            //Left
            if($x > 0 && $map[$y][$x - 1] != "#") {
                $xu = $x - 1;

                do {
                    if($xu == 0 || $map[$y + 1][$xu] != "#" || $map[$y - 1][$xu] != "#") { 
                        $list[$step] = [$x, $y, "<"];
                        $newCheck[] = [[$xu, $y], $score + 5, $list];
                    }

                    $xu -= 1; 
                } while($xu >= 0 && $map[$y][$xu] != "#"); 
            }

            //Bottom
            if($y < $H - 1 && $map[$y + 1][$x] != "#") {
                $yu = $y + 1;

                do {
                    if($yu == $H - 1 || $map[$yu][$x + 1] != "#" || $map[$yu][$x - 1] != "#") {
                        $list[$step] = [$x, $y, "v"];
                        $newCheck[] = [[$x, $yu], $score + 5, $list];
                    }

                    $yu += 1; 
                } while($yu < $H && $map[$yu][$x] != "#");
            }

            //Top
            if($y > 0 && $map[$y - 1][$x] != "#") {
                $yu = $y - 1;

                do {
                    if($yu == 0 || $map[$yu][$x + 1] != "#" || $map[$yu][$x - 1] != "#") {
                        $list[$step] = [$x, $y, "^"];
                        $newCheck[] = [[$x, $yu], $score + 5, $list];
                    }

                    $yu -= 1; 
                } while($yu >= 0 && $map[$yu][$x] != "#");
            }
        }

        //if($test) break;
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
            switch($line[$x]) {
                case ">": if($x == 0)  {
                        $start = [$x, $y]; 
                        $initDirection = ">";
                    } else $end = [$x, $y]; 
                    break;
                case "<": if($x == $W - 1) {
                        $start = [$x, $y];
                        $initDirection = "<";
                    } else $end = [$x, $y]; 
                    break;
                case "v": if($y == 0) {
                        $start = [$x, $y]; 
                        $initDirection = "v";
                    } else $end = [$x, $y]; 
                    break;
                case "^": if($y == $H - 1) {
                        $start = [$x, $y];
                        $initDirection = "^";
                    } else $end = [$x, $y]; 
                    break;
            }
        }
    }

    $map[] = $line;
}

error_log("Start " . implode("-", $start) . " -- End ". implode("-", $end)); 
error_log(var_export($map, true)); 

$results[] = solveWarrior($start, $end);
$results[] = solveDwarf($start, $end);
$results[] = solveElf($start, $end);
$results[] = solveMage($start, $end);

usort($results, function($a, $b) {
    return $a[1] <=> $b[1];
});

[$champion, $score, $list] = array_shift($results);

//error_log(var_export($list, true)); 

for($i = 1; $i < count($list); ++$i) {
    [$x, $y, $direction] = $list[$i];

    $map[$y][$x] = $direction;
}

echo $champion . " " . $score . PHP_EOL;
echo implode("\n", $map) . PHP_EOL;

error_log(var_export("It took: " . (microtime(1) - $startTime), true));
?>
