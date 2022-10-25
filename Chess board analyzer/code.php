<?php

function isPositionSafe(int $x, int $y, string $king, array $board): bool {

    //Check for Queen or Rook in cardinal directions
    foreach([[1, 0], [-1, 0], [0, 1], [0, -1]] as [$xd, $yd]) {
        $xm = $x;
        $ym = $y;

        while(true) {
            $xm += $xd;
            $ym += $yd;

            if($xm < 0 || $xm >= 8 || $ym < 0 || $ym >= 8) break;;

            if($board[$ym][$xm] != ".") {
                if(($king == "k" && ($board[$ym][$xm] == "R" || $board[$ym][$xm] == "Q")) || ($king == "K" && ($board[$ym][$xm] == "r" || $board[$ym][$xm] == "q"))) {
                    return false;
                }
                break;
            }
        }
    }

    //Check for Queen or Bishop in diagonal directions
    foreach([[-1, -1], [1, -1], [-1, 1], [1, 1]] as [$xd, $yd]) {
        $xm = $x;
        $ym = $y;

        while(true) {
            $xm += $xd;
            $ym += $yd;

            if($xm < 0 || $xm >= 8 || $ym < 0 || $ym >= 8) break;

            if($board[$ym][$xm] != ".") {
                if(($king == "k" && ($board[$ym][$xm] == "B" || $board[$ym][$xm] == "Q")) || ($king == "K" && ($board[$ym][$xm] == "b" || $board[$ym][$xm] == "q"))) {
                    return false;
                }
                break;
            }
        }
    }

    //Check for Knights
    foreach([[-1, -2], [1, -2], [-2, 1], [-2, -1], [-1, 2], [-1, 2], [2, 1], [2, -1]] as [$xd, $yd]) {
        $xm = $x + $xd;
        $ym = $y + $yd;

        //Outside of the map
        if($xm < 0 || $xm >= 8 || $ym < 0 || $ym >= 8) continue;

        if(($king == "k" && $board[$ym][$xm] == "N") || ($king == "K" && $board[$ym][$xm] == "n")) return false;
    }

    //Check for Pawns
    if(($king == "K" && $y > 0 && (($x > 0 && $board[$y - 1][$x - 1] == "p") || ($x < 7 && $board[$y - 1][$x + 1] == "p"))) || 
        $king == "k" && $y < 7 && (($x > 0 && $board[$y + 1][$x - 1] == "P") || ($x < 7 && $board[$y + 1][$x + 1] == "P"))) {
        return false;
    }

    //Check for other King
    for($y2 = max(0, $y - 1); $y2 < min(8, $y + 2); ++$y2) {
        for($x2 = max(0, $x - 1); $x2 < min(8, $x + 2); ++$x2) {
            if($board[$y2][$x2] == (($king == "K") ? "k" : "K")) return false;
        }
    }

    return true;
}

function isKingSafe(array $king, array $board): bool {
    [$kingX, $kingY, $piece] = $king;

    //Remove the king from the board
    $board[$kingY][$kingX] = ".";

    //Check all the positions the king can move to
    for($y = max(0, $kingY - 1); $y < min(8, $kingY + 2); ++$y) {
        for($x = max(0, $kingX - 1); $x < min(8, $kingX + 2); ++$x) {
            //The king can go to this position
            if($board[$y][$x] == "." || ($piece == "K" && $board[$y][$x] == strtolower($board[$y][$x])) || ($piece == "k" && $board[$y][$x] == strtoupper($board[$y][$x]))) {
                if(isPositionSafe($x, $y, $piece, $board)) return true;
            }
        }
    }

    return false;
}

for ($y = 0; $y < 8; ++$y) {
    $line = trim(fgets(STDIN));

    if(($x = strpos($line, "K")) !== false) $whiteKing = [$x, $y, "K"];
    if(($x = strpos($line, "k")) !== false) $blackKing = [$x, $y, "k"];

    $board[] = $line;
}

error_log(var_export($board, true));

if(isKingSafe($whiteKing, $board) == false) echo "B" . PHP_EOL;
elseif(isKingSafe($blackKing, $board) == false) echo "W" . PHP_EOL;
else echo "N" . PHP_EOL;
