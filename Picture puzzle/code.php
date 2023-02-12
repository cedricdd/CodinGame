<?php

//Add a piece at a given position
function addPiece(int $index, array $sides, array $positions): array {
    global $width, $height;

    $x = $index % $width;
    $y = intdiv($index, $width);

    //Update the positions that are still to found with the borders of the piece we are adding
    if($x > 0) $positions[$index - 1]["right"] = $sides["left"];
    if($x < $width - 1) $positions[$index + 1]["left"] = $sides["right"];
    if($y > 0) $positions[$index - $width]["bottom"] = $sides["top"];
    if($y < $height - 1) $positions[$index + $width]["top"] = $sides["bottom"];

    return $positions;
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

//We use integer to represent the borders, comparing int is faster than string
function getBorderID(string $name): int {
    static $ID = 0;
    static $borders = [];

    if(isset($borders[$name])) return $borders[$name];
    else {
        $borders[$name] = $ID;
        return $ID++;
    }
}

function solve(int $indexPosition, array $usedPieces, array $positions) {
    global $sides, $nPieces, $start;

    if($indexPosition == $nPieces) {
        drawSolution($usedPieces);
        exit(); //There's only one solution, it's over
    }

    //We try each of the pieces
    foreach($sides as $indexPiece => $infoSides) {

        //We are already using this piece in another position
        if(isset($usedPieces[$indexPiece])) continue;

        //Checks the 4 rotations of the piece
        foreach($infoSides as $indexRotation => $sidesRotation) {

            foreach($positions[$indexPosition] as $direction => $pattern) {
                //The borders doesn't match, it's not the right piece
                if($pattern != $sidesRotation[$direction]) continue 2;
            }

            //This rotation can be added at the current position
            $updatedPositions = addPiece($indexPosition, $sidesRotation, $positions);

            solve($indexPosition + 1, $usedPieces + [$indexPiece => [$indexPosition, $indexRotation]], $updatedPositions);
        }
    }

    return; //If none of the previous recursive find a solution one of the piece already added is wrong.
}

$start = microtime(1);

fscanf(STDIN, "%d %d", $pieceSize, $nPieces);
fscanf(STDIN, "%d %d", $width, $height);
fscanf(STDIN, "%d %d", $pictureWidth, $pictureHeight);

$positions = array_fill(0, $nPieces, []);
getBorderID(str_repeat("#", $pieceSize)); //Set the picture border as ID 0

//Set the borders of the piece that are at the border of the picture
for($y = 0; $y < $height; ++$y) {
    for($x = 0; $x < $width; ++$x) {
        $index = $y * $width + $x;

        if($x == 0) $positions[$index]["left"] = 0;
        if($x == $width - 1) $positions[$index]["right"] = 0;
        if($y == 0) $positions[$index]["top"] = 0;
        if($y == $height - 1) $positions[$index]["bottom"] = 0;
    }
}

for ($index = 0; $index < $nPieces; $index++) {

    $piece = [];

    for ($y = 0; $y < $pieceSize; ++$y) {
        $piece[] = stream_get_line(STDIN, $pieceSize + 1, "\n");
    }
    
    $top = $piece[0];
    $topID = getBorderID($top);
    $topInvID = getBorderID(strrev($top));

    $bottom = $piece[$pieceSize - 1];
    $bottomID = getBorderID($bottom);
    $bottomInvID = getBorderID(strrev($bottom));

    $left = implode("", array_map(function($line) { return $line[0]; }, $piece));
    $leftID = getBorderID($left);
    $leftInvID = getBorderID(strrev($left));

    $right = implode("", array_map(function($line) { return $line[-1]; }, $piece));
    $rightID = getBorderID($right);
    $rightInvID = getBorderID(strrev($right));

    //Save the piece with the borders for each rotations
    $pieces[] = $piece;

    //The first piece can't be rotated
    if($index == 0) $sides[] = [["top" => $topID, "right" => $rightID, "bottom" => $bottomID, "left" => $leftID]];
    else {
        $sides[] = [
            ["top" => $topID, "right" => $rightID, "bottom" => $bottomID, "left" => $leftID], //0°
            ["top" => $leftInvID, "right" => $topID, "bottom" => $rightInvID, "left" => $bottomID], //90°
            ["top" => $bottomInvID, "right" => $leftInvID, "bottom" => $topInvID, "left" => $rightInvID], //180°
            ["top" => $rightID, "right" => $bottomInvID, "bottom" => $leftID, "left" => $topInvID], //270°
        ];
    }
}

solve(0, [], $positions);
