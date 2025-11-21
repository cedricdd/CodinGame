<?php

const CHECK = [4, 0, 2, 6, 8, 1, 3, 5, 7];
const WIN = [[0,1,2], [3,4,5], [6,7,8], [0,3,6], [1,4,7], [2,5,8], [0,4,8], [2,4,6]];

function checkWinner(string $ticTacToe): bool {
    foreach(WIN as [$i, $j, $k]) {
        if($ticTacToe[$i] != '.' && $ticTacToe[$i] == $ticTacToe[$j] && $ticTacToe[$j] == $ticTacToe[$k]) return true;
    }

    return false;
}

$ticTacToe = "";

$m = stream_get_line(STDIN, 1 + 1, "\n");
$o = ($m == "X" ? "O" : "X");

for ($i = 0; $i < 3; $i++) {
    $ticTacToe .= stream_get_line(STDIN, 3 + 1, "\n");
}

error_log("Next $m");

//Game is over
if(strpos($ticTacToe, ".") === false) exit(implode(PHP_EOL, str_split($ticTacToe, 3)));

//Someone already won
if(checkWinner($ticTacToe)) exit(implode(PHP_EOL, str_split($ticTacToe, 3)));

//Empty grid
if($ticTacToe == str_repeat(".", 9)) exit(implode(PHP_EOL, str_split("....X....", 3)));

//Player can win in 1 move
foreach(CHECK as $i) {
    if($ticTacToe[$i] == '.') {
        $ticTacToe[$i] = $m;

        if(checkWinner($ticTacToe)) exit(implode(PHP_EOL, str_split($ticTacToe, 3)));

        $ticTacToe[$i] = '.';
    }
}

//Adversary can win in 1 more
foreach(CHECK as $i) {
    if($ticTacToe[$i] == '.') {
        $ticTacToe[$i] = $o;

        if(checkWinner($ticTacToe)) {
            $ticTacToe[$i] = $m;

            exit(implode(PHP_EOL, str_split($ticTacToe, 3)));
        }

        $ticTacToe[$i] = '.';
    }
}

$bestIndex = null;
$bestBlock = 10;

//Find the best move
foreach(CHECK as $index) {
    if($ticTacToe[$index] == '.') {
        $ticTacToe2 = $ticTacToe;
        $ticTacToe2[$index] = $m;
        $win = [];

        foreach(WIN as $indexWin => [$i, $j, $k]) {
            $a = count_chars($ticTacToe2[$i] . $ticTacToe2[$j] . $ticTacToe2[$k], 1);
            // error_log(var_export($a, 1));

            if(($a[46] ?? 0) == 1 && ($a[ord($m)] ?? 0) == 2) $win[] = $indexWin;
        }

        if(count($win) == 2) exit(implode(PHP_EOL, str_split($ticTacToe2, 3)));
        elseif(count($win) == 1) {
            [$i, $j, $k] = WIN[array_pop($win)];

            //The opp will block the win
            if($ticTacToe2[$i] == '.') $ticTacToe2[$i] = $o;
            if($ticTacToe2[$j] == '.') $ticTacToe2[$j] = $o;
            if($ticTacToe2[$k] == '.') $ticTacToe2[$k] = $o;

            $oppWin = 0;

            foreach(WIN as [$i, $j, $k]) {
                $a = count_chars($ticTacToe2[$i] . $ticTacToe2[$j] . $ticTacToe2[$k], 1);
                // error_log(var_export($a, 1));

                if(($a[46] ?? 0) == 1 && ($a[ord($o)] ?? 0) == 2) ++$oppWin;
            }

            error_log("at $index opp win is $oppWin");

            if($oppWin < $bestBlock) {
                $bestIndex = $index;
                $bestBlock = $oppWin;
            }
        }
    }
}

$ticTacToe[$bestIndex] = $m;
echo implode(PHP_EOL, str_split($ticTacToe, 3));
