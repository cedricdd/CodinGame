<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $N);
for ($c = 1; $c <= 6; $c++) {
    for ($y = 0; $y < $N; $y++) {
        fscanf(STDIN, "%s", $line);
        
        $map[$c][] = str_split($line);

        if(preg_match("/([<>^v])/", $line, $match)) {
            $sx = $px = strpos($line, $match[0]);
            $sy = $py = $y;
            $sc = $pc = $c;
    
            switch($match[0]) {
                case "<": $direction = "LEFT"; break;
                case ">": $direction = "RIGHT"; break;
                case "^": $direction = "UP"; break;
                case "v": $direction = "DOWN"; break;
            }
        }
    }
}

fscanf(STDIN, "%s", $side);

//Replace starting postion
$map[$pc][$py][$px] = 0;

for ($c = 1; $c <= 6; $c++) {
    error_log(var_export("Cube #" . $c, true));
    for ($y = 0; $y < $N; $y++) {
        error_log(var_export(implode('', $map[$c][$y]), true));
    }
}

function getNewPosition($c, $x, $y, $d, $values) {
    global $N;

    $uc = $c;
    $uy = $y + $values[0];
    $ux = $x + $values[1];

    switch($c) {
        case 1:
            //Moving out from the bottom
            if($uy == $N) {
                $uc = 3;
                $uy = 0;
            } //Moving out from the top
            else if($uy == -1) {
                $uc = 6;
                $uy = $N - 1;
            } //Moving out from the right
            elseif($ux == $N) {
                $uc = 4;
                $ux = $N - $y - 1;
                $uy = 0;
                $d = "DOWN";
            } //Moving out from the left
            else if($ux == -1) {
                $uc = 2;
                $ux = $y;
                $uy = 0;
                $d = "DOWN";
            }
            break;

        case 2:
            //Moving out from the bottom
            if($uy == $N) {
                $uc = 5;
                $ux = 0;
                $uy = $N - $x - 1;
                $d = "RIGHT";
            } //Moving out from the top
            else if($uy == -1) {
                $uc = 1;
                $ux = 0;
                $uy = $x;
                $d = "RIGHT";
            } //Moving out from the right
            elseif($ux == $N) {
                $uc = 3;
                $ux = 0;
            } //Moving out from the left
            else if($ux == -1) {
                $uc = 6;
                $ux = 0;
                $uy = $N - $y - 1;
                $d = "RIGHT";
            }
            break;

        case 3:
            //Moving out from the bottom
            if($uy == $N) {
                $uc = 5;
                $uy = 0;
            } //Moving out from the top
            else if($uy == -1) {
                $uc = 1;
                $uy = $N - 1;
            } //Moving out from the right
            elseif($ux == $N) {
                $uc = 4;
                $ux = 0;
            } //Moving out from the left
            else if($ux == -1) {
                $uc = 2;
                $ux = $N - 1;
            }
            break;

        case 4:
            //Moving out from the bottom
            if($uy == $N) {
                $uc = 5;
                $ux = $N - 1;
                $uy = $x;
                $d = "LEFT";
            } //Moving out from the top
            else if($uy == -1) {
                $uc = 1;
                $ux = $N - 1;
                $uy = $N - $x - 1;
                $d = "LEFT";
            } //Moving out from the right
            elseif($ux == $N) {
                $uc = 6;
                $ux = $N - 1;
                $d = "LEFT";
                $uy = $N - $y - 1;
            } //Moving out from the left
            else if($ux == -1) {
                $uc = 3;
                $ux = $N - 1;
            }
            break;

        case 5:
            //Moving out from the bottom
            if($uy == $N) {
                $uc = 6;
                $uy = 0;
            } //Moving out from the top
            else if($uy == -1) {
                $uc = 3;
                $uy = $N - 1;
            } //Moving out from the right
            elseif($ux == $N) {
                $uc = 4;
                $uy = $N - 1;
                $ux = $y;
                $d = "UP";
            } //Moving out from the left
            else if($ux == -1) {
                $uc = 2;
                $uy = $N - 1;
                $ux = $N - $y - 1;
                $d = "UP";
            }
            break;

    case 6:
        //Moving out from the bottom
        if($uy == $N) {
            $uc = 1;
            $uy = 0;
        } //Moving out from the top
        else if($uy == -1) {
            $uc = 5;
            $uy = $N - 1;
        } //Moving out from the right
        elseif($ux == $N) {
            $uc = 4;
            $ux = $N - 1;
            $uy = $N - $y - 1;
            $d = "LEFT";
        } //Moving out from the left
        else if($ux == -1) {
            $uc = 2;
            $ux = 0;
            $uy = $N - $y - 1;
            $d = "RIGHT";
        }
        break;
    }

    return [$uc, $ux, $uy, $d];
}


if($side == "L") {
    $directions = [
        "RIGHT" => ["UP" => [-1, 0], "RIGHT" => [0, 1], "DOWN" => [1, 0], "LEFT" => [0, -1]],
        "UP" => ["LEFT" => [0, -1], "UP" => [-1, 0], "RIGHT" => [0, 1], "DOWN" => [1, 0]],
        "LEFT" => ["DOWN" => [1, 0], "LEFT" => [0, -1], "UP" => [-1, 0], "RIGHT" => [0, 1]],
        "DOWN" => ["RIGHT" => [0, 1], "DOWN" => [1, 0], "LEFT" => [0, -1], "UP" => [-1, 0]],
    ];
} else {
    $directions = [
        "RIGHT" => ["DOWN" => [1, 0], "RIGHT" => [0, 1], "UP" => [-1, 0], "LEFT" => [0, -1]],
        "UP" => ["RIGHT" => [0, 1], "UP" => [-1, 0], "LEFT" => [0, -1], "DOWN" => [1, 0]],
        "LEFT" => ["UP" => [-1, 0], "LEFT" => [0, -1], "DOWN" => [1, 0], "RIGHT" => [0, 1]],
        "DOWN" => ["LEFT" => [0, -1], "DOWN" => [1, 0], "RIGHT" => [0, 1], "UP" => [-1, 0]],
    ];
}

//Check if we can't move at all
$blocked = 0;

foreach([[0, 1], [0, -1], [1, 0], [-1, 0]] as $values) {
    list($uc, $ux, $uy, $ud) = getNewPosition($pc, $px, $py, $direction, $values);

    if($map[$uc][$uy][$ux] === "#") ++$blocked;
}

if($blocked != 4) {

    while(true) {

        //Find the new direction to take
        foreach($directions[$direction] as $newDirection => $values) {

            list($uc, $ux, $uy, $ud) = getNewPosition($pc, $px, $py, $newDirection, $values);

            //The first available path
            if($map[$uc][$uy][$ux] !== "#") {
                $direction = $ud;
                $pc = $uc;
                $py = $uy;
                $px = $ux;
                break;
            }
        }

        $map[$pc][$py][$px]++;
   
        //Back at the start
        if($pc == $sc && $px == $sx && $py == $sy) break;
    }
}

for ($c = 1; $c <= 6; $c++) {
    for ($y = 0; $y < $N; $y++) {
        echo implode('', $map[$c][$y]) . "\n";
    }
}
?>
