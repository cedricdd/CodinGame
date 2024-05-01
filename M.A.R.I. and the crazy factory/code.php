<?php

//0 north 1 east 2 south 3 west
const MOVES = [[0, -1], [1, 0], [0, 1], [-1, 0]];

function applyInstruction(int $x, int $y, string $d, array $gear, array $door, bool $needKey, array $instructions): array {
    global $map, $doorPositions;

    $count = count($instructions);

    foreach($instructions as $i => $instruction) {
        if($instruction == "x2") {
            if($count == 1 || ($instructions[$i + 1] ?? "x2") == "x2") return [-1, -1, '', null, null, false, null];
            $instruction = $instructions[$i + 1]; //Run twice the next instruction
        }

        switch($instruction) {
            case "p2": //Go 2 squares forward
                $x += MOVES[$d][0];
                $y += MOVES[$d][1];
    
                if(($map[$y][$x] ?? '#') == '#' || isset($door[$y][$x])) return [-1, -1, '', null, null, false, null]; //Can't move there

                //We are pushing a gear
                if(isset($gear[$y][$x])) {
                    $xg = $x + MOVES[$d][0];
                    $yg = $y + MOVES[$d][1];

                    if(($map[$yg][$xg] ?? '#') == '#' || isset($door[$yg][$xg])) return [-1, -1, '', null, null, false, null]; //Can't push the gear

                    $gear = [$yg => [$xg => 1]];
                }
            case "p1": // Go 1 square forward
                $x += MOVES[$d][0];
                $y += MOVES[$d][1];
    
                if(($map[$y][$x] ?? '#') == '#' || isset($door[$y][$x])) return [-1, -1, '', null, null, false, null]; //Can't move there

                //We are pushing a gear
                if(isset($gear[$y][$x])) {
                    $xg = $x + MOVES[$d][0];
                    $yg = $y + MOVES[$d][1];

                    if(($map[$yg][$xg] ?? '#') == '#' || isset($door[$yg][$xg])) return [-1, -1, '', null, null, false, null]; //Can't push the gear

                    $gear = [$yg => [$xg => 1]];
                }
                break;
            case "bk": //Drop the remaining instructions in the set
                break 2; 
            case "zl": //Turn left then acts like a zr
                $instructions[$i] = "zr";
            case "tl": //Turn left
                $d = ($d - 1 + 4) % 4; 
                break;
            case "zr": //Turn right then acts like a zl
                $instructions[$i] = "zl";
            case "tr": //Turn right
                $d = ($d + 1) % 4; 
                break;
            case "nop": //Do nothing
                if($i != $count - 1) return [-1, -1, '', null, null, false, null]; //We can only have nop as last instruction
                break; 
            case "uk": //Use key (to slide the door)
                if($door == $doorPositions[0]) $door = $doorPositions[1];
                else $door = $doorPositions[0];
                break;
        }
    }

    if($needKey && $map[$y][$x] == 'k') $needKey = false; //We have found the key

    return [$x, $y, $d, $gear, $door, $needKey, $instructions];
}

function solve(int $xs, int $ys, string $ds, array $gear, array $door, bool $needKey, array $listIns, array $possibleIns, array $orderIns) {
    global $xd, $yd, $firstForced;
    static $history = [];

    //We reached the exit
    if(!$needKey && $xs == $xd && $ys == $yd) {
        $solution = [];
        $instructions = [];

        //Generate the instructions that bring M.A.R.I. to the exit
        foreach($orderIns as $i => [$index, $instruction]) {
            array_splice($instructions, $index, 0, $instruction);

            if($firstForced && $i == 0) continue;

            $solution[] = implode(" ", $instructions);
        }

        exit(implode(" ", $solution));
    }

    $count = count($listIns);
    $hash = serialize($orderIns);

    if(isset($history[$hash])) return;
    else $history[$hash] = 1;

    for($i = $count; $i >= 0; --$i) {
        foreach($possibleIns as $j => $instruction) {
            if($instruction == "uk" && $needKey) continue; //We can't slide the door without the key
            
            $listIns2 = $listIns;
            array_splice($listIns2, $i, 0, $instruction);

            [$x, $y, $d, $gear2, $door2, $needKey2, $listIns2] = applyInstruction($xs, $ys, $ds, $gear, $door, $needKey, $listIns2);

            //The set of instructions is valid
            if($x != -1 && $y != -1) {
                unset($possibleIns[$j]);

                $orderIns[$count] = [$i, $instruction];

                solve($x, $y, $d, $gear2, $door2, $needKey2, $listIns2, $possibleIns, $orderIns);

                $possibleIns[] = $instruction;
            }
        }
    }
}

$start = microtime(1);

$possibleIns = stream_get_line(STDIN, 40 + 1, "\n");
$needKey = false;
$door = [];
$doorPositions = [];
$orderIns = [];
$firstForced = false;
$gear = [];

if($possibleIns[0] != ' ') $firstForced = true;

$possibleIns = explode(" ", trim($possibleIns));

//The forced instruction is forced
if($firstForced) {
    $instruction = array_shift($possibleIns);
    $listIns[] = $instruction;
    $orderIns[] = [0, $instruction];
}
else $listIns = [];


for ($y = 0; $y < 7; ++$y) {
    $line = trim(fgets(STDIN));

    error_log($line);

    foreach(str_split($line) as $x => $c) {
        $map[$y][$x] = $c;

        if(ctype_digit($c)) {
            $xs = $x;
            $ys = $y;
            $d = $c;
        } elseif($c == 'E') {
            $xd = $x;
            $yd = $y;
        } elseif($c == 'k') {
            $needKey = true;
        } elseif($c == 'd') {
            $door[$y][$x] = 1;
        } elseif($c == 'r') {
            $xRail = $x;
            $yRail = $y;
        } elseif($c == 'G') {
            $gear[$y][$x] = 1;
        }
    }
}

//Find the different position of the door when it slides
if(isset($xRail) && isset($yRail)) {
    //Door is on the left
    if($xRail >= 2 && $map[$yRail][$xRail - 1] == 'd') {
        $doorPositions = [
            [$yRail => [$xRail - 2 => 1, $xRail - 1 => 1]],
            [$yRail => [$xRail - 1 => 1, $xRail => 1]],
        ];
    }
    //Door is on the right
    if($xRail <= 2 && $map[$yRail][$xRail + 1] == 'd') {
        $doorPositions = [
            [$yRail => [$xRail + 1 => 1, $xRail + 2 => 1]],
            [$yRail => [$xRail => 1, $xRail + 1 => 1]],
        ];
    }
}

solve($xs, $ys, $d, $gear, $door, $needKey, $listIns, $possibleIns, $orderIns);
