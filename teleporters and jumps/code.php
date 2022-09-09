<?php

const MOVES = [[0, -1], [-1, 0], [0, 1], [1, 0]];

fscanf(STDIN, "%d", $width);
fscanf(STDIN, "%d", $height);
for ($y = 0; $y < $height; $y++) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        //Starting position
        if($c == "S") {
            $xStart = $x;
            $yStart = $y;
            $c = "_";
        } //Exit of a teleporter
        elseif(ctype_alpha($c) && $c != "E" && $c == ucfirst($c)) {
            $jumps[lcfirst($c)] = [$x, $y];
            $c = "_";
        }

        $map[$y][$x] = $c;
    }
}

$step = 0;
$visited = [];
$toCheck = [[$xStart, $yStart]];

while(count($toCheck)) {
    $newCheck = [];
    
    foreach($toCheck as [$x, $y]) {
     
        //Reached the target point
        if($map[$y][$x] == "E") die("$step");

        //Outside or in wall
        if($x < 0 || $x >= $width || $y < 0 || $y >= $height || $map[$y][$x] == "#") continue; 

        //Already visited
        if(isset($visited[$y][$x])) continue;
        else $visited[$y][$x] = 1;

        //It's jumping time until we land on an empty cell or the target point
        while($map[$y][$x] != "_") {
            switch($map[$y][$x]) {
                case "E": die("$step");
                case "<": $x -= 2; break;
                case ">": $x += 2; break;
                case "^": $y -= 2; break;
                case "v": $y += 2; break;
                default: [$x, $y] = $jumps[$map[$y][$x]];
            }
        }
        
        foreach(MOVES as [$xm, $ym]) {
            $newCheck[] = [$x + $xm, $y + $ym];
        }
    }

    $toCheck = $newCheck;
    ++$step;
}

echo "-1\n"; //Impossible to reach the end
?>
