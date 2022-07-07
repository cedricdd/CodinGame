<?php
//Flip an array diagonnaly, rows becomes columns
function flipDiagonally($arr) {
    $out = array();
    foreach ($arr as $key => $subarr) {
        foreach (str_split($subarr) as $subkey => $subvalue) {
            $out[$subkey] = ($out[$subkey] ?? "") . $subvalue;
        }
    }
    return $out;
}

fscanf(STDIN, "%d %d %d", $width, $height, $boxCount);
for ($y = 0; $y < $height; ++$y) {
    $line = stream_get_line(STDIN, 30 + 1, "\n");

    //Find all the targets
    preg_match_all("/\*/", $line, $matches, PREG_OFFSET_CAPTURE);

    foreach($matches[0] as $match) {
        $winState[] = $match[1] + $y * $width;
    }

    $map[] = $line;
}

//The state when there's a box on all the target
$winState = implode("-", $winState);

error_log(var_export($map, true));

$toBan = [];

//You can't push a box in a corner if the corner is not a target
for($y = 1; $y < $height - 1; ++$y) {
    for($x = 1; $x < $width - 1; ++$x) {
        if($map[$y][$x] == ".") {
            if(($map[$y - 1][$x] == "#" && $map[$y][$x - 1] == "#") 
                || ($map[$y - 1][$x] == "#" && $map[$y][$x + 1] == "#")
                || ($map[$y + 1][$x] == "#" && $map[$y][$x - 1] == "#") 
                || ($map[$y + 1][$x] == "#" && $map[$y][$x + 1] == "#")) {
                $toBan[] = [$x, $y];
            } 
        }
    }
}

//You can't push a box against a wall if the box becomes stuck to that wall and there's no target on the line
for ($y = 1; $y < $height - 1; ++$y) {
    preg_match_all("/#([\.]+)(?=#)/", $map[$y], $matches, PREG_OFFSET_CAPTURE);

    foreach($matches[0] as $match) {
        $size = strlen($match[0]) - 1;
        $check = str_repeat("#", $size);

        if(substr($map[$y - 1], $match[1] + 1, $size) === $check || substr($map[$y + 1], $match[1] + 1, $size) === $check) {
            for($x = $match[1] + 2; $x < $match[1] + $size; ++$x) $toBan[] = [$x, $y];
        }
    }
}

$mapFlipped = flipDiagonally($map);

//You can't push a box against a wall if the box becomes stuck to that wall and there's no target on the column
for ($x = 1; $x < $width - 1; ++$x) {
    preg_match_all("/#([\.]+)(?=#)/", $mapFlipped[$x], $matches, PREG_OFFSET_CAPTURE);

    foreach($matches[0] as $match) {
        $size = strlen($match[0]) - 1;
        $check = str_repeat("#", $size);

        if(substr($mapFlipped[$x - 1], $match[1] + 1, $size) === $check || substr($mapFlipped[$x + 1], $match[1] + 1, $size) === $check) {
            for($y = $match[1] + 2; $y < $match[1] + $size; ++$y) $toBan[] = [$x, $y];
        }
    }
}

//Generate the map with extra filtering (all the positions we can't move boxes to)
$mapFiltered = $map;
foreach($toBan as $position) {
    list($x, $y) = $position;
    $mapFiltered[$y][$x] = "#";
}

$moves = "";
$step = 0;

// game loop
while (TRUE) {
    fscanf(STDIN, "%d %d", $x, $y);

    for ($i = 0; $i < $boxCount; $i++) {
        fscanf(STDIN, "%d %d", $bx, $by);
        $boxes[$bx + $by * $width] = 1;
    }

    //Generate the current state
    ksort($boxes);
    $state = implode("-", array_keys($boxes));

    //First turn, generate the list of moves
    if(empty($moves)) {

        $toCheck = [[$x, $y, $boxes, $state, '', ""]];
        $checked = [];

        while(true) {
            
            $newChecks = [];

            foreach($toCheck as $info) {
                list($x, $y, $boxes, $state, $d, $history) = $info;

                //We have a winning list of moves
                if($state == $winState) {
                    $moves = $history;
                    break 2;
                }

                //The current position of the person
                $p = ($x + $y * $width);
                
                //We have already checked this config
                if(isset($checked[$state][$p])) continue;

                //The move is pushing a box
                if(isset($boxes[$p])) {
                    $cx = $x;
                    $cy = $y;
                    $bp = $p;

                    switch($d) {
                        case "U":
                            $bp -= $width;
                             --$cy; 
                             break;
                        case "D": 
                            $bp += $width;
                            ++$cy;
                            break;
                        case "R": 
                            ++$bp;
                            ++$cx; 
                            break;
                        case "L": 
                            --$bp;
                            --$cx; 
                            break;
                    }

                    //We can't push a box into a wall or into another box
                    if($mapFiltered[$cy][$cx] == "#" || isset($boxes[$bp])) continue;

                    //Update box position
                    unset($boxes[$p]);
                    $boxes[$bp] = 1;

                    //Box was not pushed on a target, check if is stuck in current position
                    if($map[$cy][$cx] != "*") {
                        $bt = isset($boxes[$cx + ($cy - 1) * $width]);
                        $br = isset($boxes[($cx + 1) + $cy * $width]);
                        $bb = isset($boxes[$cx + ($cy + 1) * $width]);
                        $bl = isset($boxes[($cx - 1) + $cy * $width]);

                        if($map[$cy][$cx + 1] == "#" && (($bt && $map[$cy - 1][$cx + 1] == "#") || ($bb && $map[$cy + 1][$cx + 1] == "#"))) {
                            continue;
                        }
                        if($map[$cy + 1][$cx] == "#" && (($br && $map[$cy + 1][$cx + 1] == "#") || ($bl && $map[$cy + 1][$cx - 1] == "#"))) {
                            continue;
                        }
                        if($map[$cy][$cx - 1] == "#" && (($bb && $map[$cy + 1][$cx - 1] == "#") || ($bt && $map[$cy - 1][$cx - 1] == "#"))) {
                            continue;
                        }
                        if($map[$cy - 1][$cx] == "#" && (($br && $map[$cy - 1][$cx + 1] == "#") || ($bl && $map[$cy - 1][$cx - 1] == "#"))) {
                            continue;
                        }
                    }

                    //Generate new state
                    ksort($boxes);
                    $state = implode("-", array_keys($boxes));
                }

                //Move is valid
                $history .= $d;
                $checked[$state][$p] = 1;

                //Test the 4 cardinal direction
                foreach([[0, -1, 'U'], [-1, 0, 'L'], [0, 1, 'D'], [1, 0, 'R']] as $move) {
                    $ux = $x + $move[0];
                    $uy = $y + $move[1];

                    //Person can't move into a wall
                    if($map[$uy][$ux] != "#") $newChecks[] = [$ux, $uy, $boxes, $state, $move[2], $history];
                }
            }

            $toCheck = $newChecks;
        }
    }

    echo $moves[$step++] . "\n";
}
?>
