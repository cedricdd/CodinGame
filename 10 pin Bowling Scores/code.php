<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++){
    $games[] = stream_get_line(STDIN, 64 + 1, "\n") . " ";
}

function getExtraPoints(&$game, $index, $count = 1) {
    $points = 0;

    while($count) {
        switch($game[$index]) {
            case " ":
                ++$index;
                continue 2;
            case "X":
                $points += 10;
                break;
            case "/": 
                $points = 10;
                break;
            case "-":
                break;
            default:
                $points += intval($game[$index]);
        }
        --$count;
        ++$index;
    }

    return $points;
}

foreach($games as $game) {
    $frame = 0;
    $points = 0;

    for($i=0; $i < strlen($game); ++$i) {
        $result = $game[$i];

        //New frame
        if($result == " ") {
            $scores[$frame++] = $points;
            $points = 0;
        } //We did a spare
        elseif($result == "/") {
            $points = 10 + getExtraPoints($game, $i+1);
            if($frame == 9) $i++;
        } //We did a strike
        elseif($result == "X") {
            $points = 10 + getExtraPoints($game, $i+1, 2);
            if($frame == 9) $i+=2;
        } //Scoring some points
        else {
            $points += intval($result);  
        }
    }

    for($i=1; $i<10; ++$i) $scores[$i] += $scores[$i-1];
    echo implode(' ', $scores) . "\n";
}
?>
