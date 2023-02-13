<?php

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

function solve(int $indexPosition, array $usedPieces, array $positions) {
    global $width, $height, $borders, $picBorder;

    if($indexPosition == $width * $height) {
        drawSolution($usedPieces);
        exit(); //There's only one solution, it's over
    }

    $x = $indexPosition % $width;
    $y = intdiv($indexPosition, $width);

    $top = $positions[$indexPosition - $width]["bottom"] ?? $picBorder; //The bottom border of the piece on top
    $left = $positions[$indexPosition - 1]["right"] ?? $picBorder; //The right border of the piece on left

    //We try each of the possible pieces based on the borders of the piece on top & left
    foreach($borders[$top . $left] ?? [] as [$indexPiece, $indexRotation, $sides]) {

        //We are already using this piece in another position
        if(isset($usedPieces[$indexPiece])) continue;

        if($x < $width - 1 && $sides["right"] == $picBorder) continue; //Picture border can't be on the left
        if($y < $height - 1 && $sides["bottom"] == $picBorder) continue; //Picture border can't be on the bottom
 
        //This rotation can be added at the current position
        $positions[$indexPosition] = $sides;

        solve($indexPosition + 1, $usedPieces + [$indexPiece => [$indexPosition, $indexRotation]], $positions);
    }

    return; //If none of the previous recursive call have found the solution then one of the piece already added is wrong.
}

$start = microtime(1);

fscanf(STDIN, "%d %d", $pieceSize, $nPieces);
fscanf(STDIN, "%d %d", $width, $height);
fscanf(STDIN, "%d %d", $pictureWidth, $pictureHeight);

$positions = array_fill(0, $nPieces, []);
$picBorder = str_repeat("#", $pieceSize);

for ($index = 0; $index < $nPieces; $index++) {

    $piece = [];

    for ($y = 0; $y < $pieceSize; ++$y) {
        $piece[] = stream_get_line(STDIN, $pieceSize + 1, "\n");
    }
    
    $top = $piece[0];
    $topInv = strrev($top);

    $bottom = $piece[$pieceSize - 1];
    $bottomInv = strrev($bottom);

    $left = implode("", array_map(function($line) { return $line[0]; }, $piece));
    $leftInv = strrev($left);

    $right = implode("", array_map(function($line) { return $line[-1]; }, $piece));
    $rightInv = strrev($right);

    //Save the piece 
    $pieces[] = $piece;

    //The rotation of the first piece is certain
    if($index == 0) {
        $borders[$top . $left][] = [$index, 0, ["top" => $top, "right" => $right, "bottom" => $bottom, "left" => $left]];
    }
    else {
        $borders[$top . $left][] = [$index, 0, ["top" => $top, "right" => $right, "bottom" => $bottom, "left" => $left]]; //0°
        $borders[$leftInv . $bottom][] = [$index, 1, ["top" => $leftInv, "right" => $top, "bottom" => $rightInv, "left" => $bottom]]; //90°
        $borders[$bottomInv . $rightInv][] = [$index, 2, ["top" => $bottomInv, "right" => $leftInv, "bottom" => $topInv, "left" => $rightInv]]; //180°
        $borders[$right . $topInv][] = [$index, 3, ["top" => $right, "right" => $bottomInv, "bottom" => $left, "left" => $topInv]]; //270°
    }
}

solve(0, [], $positions);
