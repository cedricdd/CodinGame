<?php

$start = microtime(1);

//Add a piece at a given position
function addPiece(int $index, array $sides, array $positions): array {
    global $width, $height;

    $x = $index % $width;
    $y = intdiv($index, $width);

    unset($positions[$index]);

    //Update the positions that are still to found with the borders of the piece we are adding
    if($x > 0 && isset($positions[$index - 1])) $positions[$index - 1]["right"] = $sides["left"];
    if($x < $width - 1 && isset($positions[$index + 1])) $positions[$index + 1]["left"] = $sides["right"];
    if($y > 0 && isset($positions[$index - $width])) $positions[$index - $width]["bottom"] = $sides["top"];
    if($y < $height - 1 && isset($positions[$index + $width])) $positions[$index + $width]["top"] = $sides["bottom"];

    return $positions;
}

//Check if a piece can be placed at a given position based on the border character
function checkBorders(array $sides, int $index): bool {
    global $width, $height, $border;

    $x = $index % $width;
    $y = intdiv($index, $width);

    //Checking left border
    if(($x == 0 && $sides["left"] != $border) || ($sides["left"] == $border && $x != 0)) return false;

    //Checking right border
    if(($x == $width - 1 && $sides["right"] != $border) || ($sides["right"] == $border && $x != $width - 1)) return false;

    //Checking top border
    if(($y == 0 && $sides["top"] != $border) || ($sides["top"] == $border && $y != 0)) return false;

    //Checking bottom border
    if(($y == $height - 1 && $sides["bottom"] != $border) || ($sides["bottom"] == $border && $y != $height - 1)) return false;

    return true;
}

//We found the solution, draw it
function drawSolution(array $usedPieces) {
    global $pieces, $pieceSize, $width, $height, $start;
    
    $pictureWidth = 1 + ($pieceSize - 1) * $width;
    $pictureHeight = 1 + ($pieceSize - 1) * $height;

    $answer = array_fill(0, $pictureHeight, str_repeat(" ", $pictureWidth));

    foreach($usedPieces as $indexPiece => [$indexPosition, $rotation]) {
        $x = $indexPosition % $width;
        $y = intdiv($indexPosition, $width);

        $startX = $x * $pieceSize - $x; //The X start position of this piece in the solution
        $startY = $y * $pieceSize - $y; //The Y start position of this piece in the solution

        $piece = $pieces[$indexPiece][$rotation]["piece"];

        //Insert the piece in the solution
        for($y = 0; $y < $pieceSize; ++$y) {
            for($x = 0; $x < $pieceSize; ++$x) {
                $answer[$startY + $y][$startX + $x] = $piece[$y][$x];
            }
        }
    }

    echo implode("\n", $answer) . PHP_EOL;
    error_log(microtime(1) - $start);
}

function solve(array $usedPieces, array $positions) {
    global $pieces, $start;

    if(count($positions) == 0) {
        drawSolution($usedPieces);
        exit(); //There's only one solution, it's over
    }

    foreach($positions as $indexPosition => $infoPosition) {
        //We only try to add a piece if at least one of the adjacent piece is already added
        if(count($infoPosition) == 0) continue;

        //We try each of the pieces
        foreach($pieces as $indexPiece => $infoPiece) {

            //We are already using this piece in another position
            if(isset($usedPieces[$indexPiece])) continue;

            //Checks the 4 rotations of the piece
            foreach($infoPiece as $indexRotation => ["piece" => $piece, "sides" => $sides]) {

                if(checkBorders($sides, $indexPosition) == false) continue;
    
                foreach($infoPosition as $direction => $pattern) {
                    //The borders doesn't match, it's not the right piece
                    if($pattern != $sides[$direction]) continue 2;
                }
    
                //This rotation can be added at the current position
                $updatedPositions = addPiece($indexPosition, $sides, $positions);
    
                solve($usedPieces + [$indexPiece => [$indexPosition, $indexRotation]], $updatedPositions);
            }
        }

        return; //If none of the previous recursive find a solution one of the piece already added is wrong.
    }
}

fscanf(STDIN, "%d %d", $pieceSize, $nPieces);
fscanf(STDIN, "%d %d", $width, $height);
fscanf(STDIN, "%d %d", $pictureWidth, $pictureHeight);

$border = str_repeat("#", $pieceSize);

for ($i = 0; $i < $nPieces; $i++) {

    $piece = array_fill(0, 4, array_fill(0, $pieceSize, str_repeat(" ", $pieceSize)));

    $top = "";
    $bottom = "";
    $left = "";
    $right = "";

    for ($y = 0; $y < $pieceSize; ++$y) {
        foreach(str_split(stream_get_line(STDIN, $pieceSize + 1, "\n")) as $x => $c) {
            
            //Get the border of the piece with no rotation
            if($y == 0) $top .= $c;
            if($y == $pieceSize - 1) $bottom .= $c;
            if($x == 0) $left .= $c;
            if($x == $pieceSize - 1) $right .= $c;
    
            $piece[0][$y][$x] = $c; //0°
            $piece[1][$x][$pieceSize - 1 - $y] = $c; //90°
            $piece[2][$pieceSize - 1 - $y][$pieceSize - 1 - $x] = $c; //180°
            $piece[3][$pieceSize - 1 - $x][$y] = $c; //270°
        }
    }

    //Save the piece with it's rotations and the associated borders
    $pieces[$i] = [
        ["piece" => $piece[0], "sides" => ["top" => $top, "right" => $right, "bottom" => $bottom, "left" => $left]],
        ["piece" => $piece[1], "sides" => ["top" => strrev($left), "right" => $top, "bottom" => strrev($right), "left" => $bottom]],
        ["piece" => $piece[2], "sides" => ["top" => strrev($bottom), "right" => strrev($left), "bottom" => strrev($top), "left" => strrev($right)]],
        ["piece" => $piece[3], "sides" => ["top" => $right, "right" => strrev($bottom), "bottom" => $left, "left" => strrev($top)]],
    ];
}

//We know the first piece is not rotated so we start by adding that one
for($index = 0; $index < $nPieces; ++$index) {

    if(checkBorders($pieces[0][0]["sides"], $index) == false) continue;

    //The first piece can be placed at $index position, try to solve with that
    $positions = addPiece($index, $pieces[0][0]["sides"], array_fill(0, $nPieces, []));

    solve([0 => [$index, 0]], $positions);
}
