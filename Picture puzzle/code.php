<?php

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

        //Insert the piece in the solution
        for($y = 0; $y < $pieceSize; ++$y) {
            for($x = 0; $x < $pieceSize; ++$x) {
                switch($rotation) {
                    case 0: $answer[$startY + $y][$startX + $x] = $pieces[$indexPiece][$y][$x]; break; //0°
                    case 1: $answer[$startY + $x][$startX + $pieceSize - 1 - $y] = $pieces[$indexPiece][$y][$x]; break; //90°
                    case 2: $answer[$startY + $pieceSize - 1 - $y][$startX + $pieceSize - 1 - $x] = $pieces[$indexPiece][$y][$x]; break; //180°
                    case 3: $answer[$startY + $pieceSize - 1 - $x][$startX + $y] = $pieces[$indexPiece][$y][$x]; break; //270°
                }
            }
        }
    }

    echo implode("\n", $answer) . PHP_EOL;
    error_log(microtime(1) - $start);
}

function solve(array $usedPieces, array $positions) {
    global $sides, $start;

    if(count($positions) == 0) {
        drawSolution($usedPieces);
        exit(); //There's only one solution, it's over
    }

    foreach($positions as $indexPosition => $infoPosition) {
        //We only try to add a piece if at least one of the adjacent piece is already added
        if(count($infoPosition) == 0) continue;

        //We try each of the pieces
        foreach($sides as $indexPiece => $infoSides) {

            //We are already using this piece in another position
            if(isset($usedPieces[$indexPiece])) continue;

            //Checks the 4 rotations of the piece
            foreach($infoSides as $indexRotation => $sidesRotation) {

                if(checkBorders($sidesRotation, $indexPosition) == false) continue;
    
                foreach($infoPosition as $direction => $pattern) {
                    //The borders doesn't match, it's not the right piece
                    if($pattern != $sidesRotation[$direction]) continue 2;
                }
    
                //This rotation can be added at the current position
                $updatedPositions = addPiece($indexPosition, $sidesRotation, $positions);
    
                solve($usedPieces + [$indexPiece => [$indexPosition, $indexRotation]], $updatedPositions);
            }
        }

        return; //If none of the previous recursive find a solution one of the piece already added is wrong.
    }
}

$start = microtime(1);

fscanf(STDIN, "%d %d", $pieceSize, $nPieces);
fscanf(STDIN, "%d %d", $width, $height);
fscanf(STDIN, "%d %d", $pictureWidth, $pictureHeight);

$border = str_repeat("#", $pieceSize);

for ($i = 0; $i < $nPieces; $i++) {

    $piece = [];

    for ($y = 0; $y < $pieceSize; ++$y) {
        $piece[] = stream_get_line(STDIN, $pieceSize + 1, "\n");
    }
    
    $top = $piece[0];
    $bottom = $piece[$pieceSize - 1];
    $left = implode("", array_map(function($line) { return $line[0]; }, $piece));
    $right = implode("", array_map(function($line) use ($pieceSize) { return $line[$pieceSize - 1]; }, $piece));

    //Save the piece with the borders for each rotations
    $pieces[] = $piece;
    $sides[] = [
        ["top" => $top, "right" => $right, "bottom" => $bottom, "left" => $left], //0°
        ["top" => strrev($left), "right" => $top, "bottom" => strrev($right), "left" => $bottom], //90°
        ["top" => strrev($bottom), "right" => strrev($left), "bottom" => strrev($top), "left" => strrev($right)], //180°
        ["top" => $right, "right" => strrev($bottom), "bottom" => $left, "left" => strrev($top)], //270°
    ];
}

//We know the first piece is not rotated so we start by adding that one
for($index = 0; $index < $nPieces; ++$index) {

    if(checkBorders($sides[0][0], $index) == false) continue;

    //The first piece can be placed at $index position, try to solve with that
    $positions = addPiece($index, $sides[0][0], array_fill(0, $nPieces, []));

    solve([0 => [$index, 0]], $positions);
}
