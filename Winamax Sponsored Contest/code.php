<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d", $width, $height);
for ($i = 0; $i < $height; $i++) {
    fscanf(STDIN, "%s", $line);

    foreach(str_split($line) as $key => $value) {
        if(is_numeric($value)) $balls[] = [$i, $key, $value];
    }

    $map[] = $line;
}

error_log(var_export($map, true));

//Initial map & balls
$toCheck = [
    [$map, $balls]
];


while(count($toCheck)) {
    list($map, $balls) = array_pop($toCheck);
    list($y, $x, $moves) = $balls[0];

    //Ball is in a hole
    if($map[$y][$x] == "H") {
        //This hole is now occupied
        $map[$y][$x] = "O";

        //Remove the ball from the list
        array_shift($balls);

        //No more balls, we have found the solution
        if(count($balls) == 0) {
            //Only keep arrows & dots
            for($i = 0; $i < $height; ++$i) {
                echo str_replace("X", ".", str_replace("O", ".", $map[$i])) . "\n";
            }

            exit();
        } else {
            $toCheck[] = [$map, $balls];
            continue;
        }
    }

    //Ball can't move anymore
    if($moves == 0) continue;

    $updatedMoves = $moves - 1;

    //Ball can go up
    if(($y - $moves) >= 0) {
        $upMap = $map;
        $upMap[$y][$x] = "^";

        do {
            //Check if the path to move up is free
            for($i = 1; $i <= ($moves - 1); ++$i)  {
                if($upMap[$y - $i][$x] == "." || $upMap[$y - $i][$x] == "X") $upMap[$y - $i][$x] = "^";
                else break 2;
            }
    
            //The stop is a valid place
            if($upMap[$y - $moves][$x] == "." || $upMap[$y - $moves][$x] == "H") {
                $toCheck[] = [$upMap, array_replace($balls, [0 => [$y - $moves, $x, $updatedMoves]])];
            } 
        } while(1 == 2); //Just once, just doing it to be able to break
    } 


    //Ball can go down
    if($y < ($height - $moves)) {
        $downMap = $map;
        $downMap[$y][$x] = "v";

        do {
            //Check if the path to move down is free
            for($i = 1; $i <= ($moves - 1); ++$i)  {
                if($downMap[$y + $i][$x] == "." || $downMap[$y + $i][$x] == "X") $downMap[$y + $i][$x] = "v";
                else break 2;
            }

            //The stop is a valid place
            if($downMap[$y + $moves][$x] == "." || $downMap[$y + $moves][$x] == "H") {
                $toCheck[] = [$downMap, array_replace($balls, [0 => [$y + $moves, $x, $updatedMoves]])];
            } 
        } while(1 == 2); //Just once, just doing it to be able to break
    }

    //Ball can go left
    if(($x - $moves) >= 0) {
        $leftMap = $map;
        $leftMap[$y][$x] = "<";

        do {
            //Check if the path to move left is free
            for($i = 1; $i <= ($moves - 1); ++$i)  {
                if($leftMap[$y][$x - $i] == "." || $leftMap[$y][$x - $i] == "X") $leftMap[$y][$x - $i] = "<";
                else break 2;
            }

            //The stop is a valid place
            if($leftMap[$y][$x - $moves] == "." || $leftMap[$y][$x - $moves] == "H") {
                $toCheck[] = [$leftMap, array_replace($balls, [0 => [$y, $x - $moves, $updatedMoves]])];
            } 
        } while(1 == 2); //Just once, just doing it to be able to break
    }

    //Ball can go right
    if($x < ($width - $moves)) {
        $rightMap = $map;
        $rightMap[$y][$x] = ">";

        do {
            //Check if the path to move right is free
            for($i = 1; $i <= ($moves - 1); ++$i)  {
                if($rightMap[$y][$x + $i] == "." || $rightMap[$y][$x + $i] == "X") $rightMap[$y][$x + $i] = ">";
                else break 2;
            }

            //The stop is a valid place
            if($rightMap[$y][$x + $moves] == "." || $rightMap[$y][$x + $moves] == "H") {
                $toCheck[] = [$rightMap, array_replace($balls, [0 => [$y, $x + $moves, $updatedMoves]])];
            } 
        } while(1 == 2); //Just once, just doing it to be able to break
    }
}
?>
