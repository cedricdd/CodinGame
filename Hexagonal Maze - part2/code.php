<?php

$start = microtime(1);

fscanf(STDIN, "%d %d", $width, $height);

$map = "";
$moves = [
    0 => ["UL" => -$width - 1, "UR" =>  -$width, "L" => -1, "R" => 1, "DL" => $width - 1, "DR" => $width],
    1 => ["UL" => -$width, "UR" =>  -$width + 1, "L" => -1, "R" => 1, "DL" => $width, "DR" => $width + 1],
];

for ($y = 0; $y < $height; $y++) {
    $line = trim(fgets(STDIN));

    //We need the starting position
    if(($x = strpos($line, "S")) !== false) {
        $startPosition = $y * $width + $x;
        $line[$x] = ".";
    }

    $map .= $line;
}

$step = 0;
$visited = [];
$alphabet = array_flip(range("A", "Z"));
$toCheck = [[$startPosition, [], 0]];

while(count($toCheck)) {
    $newCheck = [];

    foreach($toCheck as [$position, $path, $keys]) {
        //Reached the target point
        if($map[$position] == "E") break 2;

        //We are slidding
        if($map[$position] == "_") {
            
            while(true) {
                $move = $moves[intdiv($position, $width) % 2][$path[$step -1]];
                $position += $move;

                //Reached a free space
                if($map[$position] == ".") {
                    break;
                } //Reached the end
                elseif($map[$position] == "E") break 3;
                //Reached a wall
                elseif($map[$position] == "#") {
                    $position -= $move;;
                    break;
                } //Reached a key or door
                elseif(ctype_alpha($map[$position])) {
                    //It's a door we can't open
                    if($map[$position] == ucfirst($map[$position]) && !($keys & (1 << $alphabet[$map[$position]]))) $position -= $move;
                    break;
                }
            }
        }

        //Already visited, can't be shortest path
        if(isset($visited[$position][$keys])) continue;
        else $visited[$position][$keys] = 1;

        //Reached a door or key
        if(ctype_alpha($map[$position])) {
            //Finding a key
            if($map[$position] == lcfirst($map[$position])) {
                $keys |= 1 << $alphabet[ucfirst($map[$position])];
            } //A door we can't open
            elseif(!($keys & (1 << $alphabet[$map[$position]]))) continue;
        }
        
        //Check the 6 directions 
        foreach($moves[intdiv($position, $width) % 2] as $d => $move) {
            if($map[$position + $move] != "#") $newCheck[] = [$position + $move, $path + [$step => $d], $keys];
        }
    }

    $toCheck = $newCheck;
    ++$step;
}

error_log(var_export(microtime(1) - $start, true));
echo implode(" ", $path);
?>
