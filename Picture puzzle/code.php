<?php

$start = microtime(1);

function checkBorders(array $sides, int $index): bool {
    global $W, $H, $border;

    $x = $index % $W;
    $y = intdiv($index, $W);

    //Checking left border
    if(($x == 0 && $sides["left"] != $border) || ($sides["left"] == $border && $x != 0)) return false;

    //Checking right border
    if(($x == $W - 1 && $sides["right"] != $border) || ($sides["right"] == $border && $x != $W - 1)) return false;

    //Checking top border
    if(($y == 0 && $sides["top"] != $border) || ($sides["top"] == $border && $y != 0)) return false;

    //Checking bottom border
    if(($y == $H - 1 && $sides["bottom"] != $border) || ($sides["bottom"] == $border && $y != $H - 1)) return false;

    return true;
}

function addPiece(array &$positions, int $index, array $sides) {
    global $W, $H;

    $x = $index % $W;
    $y = intdiv($index, $W);

    unset($positions[$index]);

    if($x > 0 && isset($positions[$index - 1])) $positions[$index - 1]["right"] = $sides["left"];
    if($x < $W - 1 && isset($positions[$index + 1])) $positions[$index + 1]["left"] = $sides["right"];
    if($y > 0 && isset($positions[$index - $W])) $positions[$index - $W]["bottom"] = $sides["top"];
    if($y < $H - 1 && isset($positions[$index + $W])) $positions[$index + $W]["top"] = $sides["bottom"];
}

function checkPosition(array $sides, int $index, array $usedPieces): bool {
    global $pieces, $W, $H;

    $x = $index % $W;
    $y = intdiv($index, $W);

    if($x > 0 && isset($usedPieces[$index - 1])) return true;
    if($x < $W - 1 && isset($usedPieces[$index + 1])) return true;
    if($y > 0 && isset($usedPieces[$index - $W])) return true;
    if($y < $H - 1 && isset($usedPieces[$index + $W])) return true;

    return false;
}

function draw(array $usedPieces) {
    global $pieces, $pieceSize, $W, $H, $pictureWidth, $pictureHeight;

    $answer = array_fill(0, $pictureHeight, str_repeat(" ", $pictureWidth));

    foreach($usedPieces as $indexPiece => $indexPosition) {

        $x = $indexPosition % $W;
        $y = intdiv($indexPosition, $W);

        $startX = $x * $pieceSize - $x;
        $startY = $y * $pieceSize - $y;

        error_log("$indexPiece -- $x $y -- $startX $startY");

        for($y = 0; $y < $pieceSize; ++$y) {
            for($x = 0; $x < $pieceSize; ++$x) {
                //error_log(($startX + $x2) . " " . ($startY + $y2) . " is " . $pieces[$usedPieces[$y * $W + $x]][0][$y2][$x2]);

                $answer[$startY + $y][$startX + $x] = $pieces[$indexPiece][0][$y][$x];
            }
        }
    }

    //error_log(var_export($answer, true));

    echo implode("\n", $answer) . PHP_EOL;
}

function solve(array $usedPieces, array $positions) {
    global $pieces, $start;

    //error_log(var_export($positions, true));
    //error_log(var_export($usedPieces, true));

    //error_log(count($usedPieces) . " " . (microtime(1) - $start));

    if(count($positions) == 0) {
        error_log("success!!!!!! " . (microtime(1) - $start));
        error_log(var_export($usedPieces, true));

        draw($usedPieces);

        exit();
    }

    foreach($positions as $indexPosition => $infoPosition) {
       // error_log("$indexPosition is free");


        //We only try to add a piece if at least one of the adjacent piece is already added
        if(count($infoPosition) == 0) {
          //  error_log("no adjacent we continue");
            continue;
        }

        error_log("adding a piece at $indexPosition");

        if($indexPosition == 2) {
            error_log(var_export($usedPieces, true));
            error_log(var_export($infoPosition, true));
        }

        foreach($pieces as $indexPiece => [$piece, $sides]) {
            //We are already using this piece
            if(isset($usedPieces[$indexPiece])) continue;

            if(checkBorders($sides, $indexPosition) == false) {
                //error_log("$indexPiece can't go here because of border");
                continue;
            }

            foreach($infoPosition as $direction => $pattern) {
                if($pattern != $sides[$direction]) {

                    if($indexPiece == 26) {
                        //error_log(var_export($infoPosition, true));
                    }

                    error_log("for $indexPiece $direction is " . $sides[$direction] . " we need $pattern at $indexPosition");

                    continue 2;
                }
            }

            error_log("we can add $indexPiece at $indexPosition");

            //We add the piece at this position

            $positions2 = $positions;
            addPiece($positions2, $indexPosition, $sides);

            solve($usedPieces + [$indexPiece => $indexPosition], $positions2);
        }

        error_log("finished working with $indexPosition");
        return;
    }
}

fscanf(STDIN, "%d %d", $pieceSize, $nPieces);
fscanf(STDIN, "%d %d", $W, $H);
fscanf(STDIN, "%d %d", $pictureWidth, $pictureHeight);

$border = str_repeat("#", $pieceSize);

for ($i = 0; $i < $nPieces; $i++) {
    $piece = [];
    $sides = ["top" => "", "bottom" => "", "left" => "", "right" => ""];

    for ($j = 0; $j < $pieceSize; $j++) {
        $line = stream_get_line(STDIN, $pieceSize + 1, "\n");

        if($j == 0) $sides["top"] = $line;
        elseif($j == $pieceSize - 1) $sides["bottom"] = $line;
        $sides["left"] .= $line[0];
        $sides["right"] .= $line[-1];

        $piece[] = $line;
    }

    //error_log(var_export($piece, true));

    $pieces[] = [$piece, $sides];
}

$positions = array_fill(0, $nPieces, []);

for($i = 0; $i < $nPieces; ++$i) {
    //We want to test the first piece (we know it's not rotated) at position $i

    if(checkBorders($pieces[0][1], $i) == false) continue;

    error_log("we test first piece at position $i");

    $positions2 = $positions;
    addPiece($positions2, $i, $pieces[0][1]);

    solve([0 => $i], $positions2);
}

error_log(microtime(1) - $start);
