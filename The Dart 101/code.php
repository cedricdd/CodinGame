<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $players[] = stream_get_line(STDIN, 1024 + 1, "\n");
}

$winner = "";
$bestScore = 0;
$bestRounds = INF;

for ($player = 0; $player < $N; ++$player) {
    $shoots = explode(" ", stream_get_line(STDIN, 1024 + 1, "\n"));

    $round = 1;
    $score = 0;
    $index = 0;
    
    while($index < count($shoots)) {
        $roundScore = 0;

        //At most 3 shoots per round
        for($i = 0; $i < 3; ++$i) {
            if($shoots[$index + $i] == "X") {
                $roundScore -= 20;
                //Missing twice consecutively
                if($i > 0 && $shoots[$index + $i - 1] == "X") $roundScore -= 10;
                //Missing three times in the same round
                if($i == 2 && $shoots[$index + $i - 1] == "X" && $shoots[$index + $i - 2] == "X") $roundScore = $score * -1;
            } else $roundScore += eval("return " . $shoots[$index + $i] . ";");

            //Player has reached exactly 101 points
            if($score + $roundScore == 101) {
                $score = 101;
                break 2;
            }
            //Score is above 101, round ends, you score nothing
            elseif($score + $roundScore > 101) {
                $roundScore = 0;
                ++$index;
                break;
            }
        }
        
        $score = max(0, $score + $roundScore); //Not specified by the rules if the score can go below 0 or not, I assume it can't
        $index += $i;
        ++$round;
    }

    //This player reached 101 in less rounds or ended with an higher score than the current winner
    if($score > $bestScore || ($score == 101 && $round < $bestRounds)) {
        $winner = $players[$player];
        $bestScore = $score;
        $bestRounds = $round;
    }
}

echo $winner . PHP_EOL;
