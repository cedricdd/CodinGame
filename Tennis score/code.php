<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

$names = explode(" ", stream_get_line(STDIN, 31 + 1, "\n"));
fscanf(STDIN, "%d", $n);
$points = explode(" ", stream_get_line(STDIN, 255 + 1, "\n"));

$finished = false;
$set = 1;
$games = [[0, [1 => 0]], [0, [1 => 0]]];
$scores = [0, 0];
$tieBreak = false;

foreach ($points as $point) {
    $binary = str_pad(base_convert($point, 16, 2), 8, '0', STR_PAD_LEFT); 


    foreach(str_split($binary) as $byte) {
        $scores[$byte]++;

        //Has a player won a game?
        if($scores[$byte] >= ($tieBreak ? ($n == $set ? 10 : 7) : 4) && $scores[$byte] - $scores[($byte + 1) % 2] >= 2) {
            $games[$byte][1][$set]++;

            //Has a player won a set?
            if($games[$byte][1][$set] >= 6 && $games[$byte][1][$set] - $games[($byte + 1) % 2][1][$set] >= ($tieBreak ? 1 : 2)) {

                //We were in a tie-break, reset it
                if($tieBreak) $tieBreak = false;

                $games[$byte][0]++;

                //Game is over one of the player won enough sets
                if($games[$byte][0] > ($n >> 1)) {
                    $finished = true;
                    break 2;
                }

                $set++;
                $games[0][1][$set] = 0;
                $games[1][1][$set] = 0;
            } //We reached 6 - 6 => entering tie-break
            elseif($games[$byte][1][$set] == 6 && $games[($byte + 1) % 2][1][$set] == 6) {
                $tieBreak = true;
            }

            $scores = [0, 0];
        }
    }
}

$a = [0 => 0, 1 => 15, 2 => 30, 3 => 40];

if($tieBreak || $finished) $outputScores = $scores;
//We need to change the scores of the current game
elseif($scores[0] >= 4 || $scores[1] >= 4) {
    //Equality
    if($scores[0] == $scores[1]) {
        $outputScores[0] = $outputScores[1] = 40;
    } //Avantage player 1 
    elseif($scores[0] > $scores[1]) {
        $outputScores[0] = "AV";
        $outputScores[1] = "-";
    } //Avantage player 2 
    else {
        $outputScores[0] = "-";
        $outputScores[1] = "AV";
    } 
} else {
    $outputScores[0] = $a[$scores[0]];
    $outputScores[1] = $a[$scores[1]];
}

//Game is over
if($finished) {
    echo str_pad($names[0], 15, ".") . " " . implode(" ", $games[0][1]) . "\n";
    echo str_pad($names[1], 15, ".") . " " . implode(" ", $games[1][1]) . "\n";
    echo (($games[0][0] > $games[1][0]) ? $names[0] : $names[1]) . " wins\n";
} //Game is onging
else {
    echo str_pad($names[0], 15, ".") . " " . implode(" ", $games[0][1]) . " | " . $outputScores[0] . "\n";
    echo str_pad($names[1], 15, ".") . " " . implode(" ", $games[1][1]) . " | " . $outputScores[1] . "\n";
    echo("Game in progress\n");
}

?>
