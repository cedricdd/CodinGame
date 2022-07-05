<?php
$INITIAL = strtr(stream_get_line(STDIN, 10 + 1, "\n"), "LR", "01");
$TARGET = strtr(stream_get_line(STDIN, 10 + 1, "\n"), "LR", "01");

error_log(var_export($INITIAL, true));
error_log(var_export($TARGET, true));

$statesToCheck = [[$INITIAL, []]];

while(true) {
    $newStates = [];
    $solutions = [];

    foreach($statesToCheck as $toCheck) {
        list($state, $history) = $toCheck;

        $history[] = $state;

        //Reached the target, finish the current step to have all the solutions with the same score
        if($state == $TARGET) {
            $solutions[] = $history;
            continue;
        }

        //Wolf kills the goat
        if($state[2] == $state[4] && $state[0] != $state[2]) continue;
        //Goat east the cabbage
        if($state[4] == $state[6] && $state[0] != $state[4]) continue;

        //All the possible moves
        for($i = 0; $i < 7; $i +=2) {
            if($state[$i] == $state[0]) {
                $updated = $state;
                $updated[0] = ($state[0] + 1) % 2;
                $updated[$i] = ($state[$i] + 1) % 2;
                $newStates[] = [$updated, $history];
            }
        }
    }

    if(count($solutions)) break;
    else $statesToCheck = $newStates;
}

//If there are multiple solutions with the same length, return the one that is alphabetically first.
usort($solutions, function($a, $b) {
    for($i = 0; $i < count($a); ++$i) {
        if($a[$i] != $b[$i]) return str_replace(" ", "", $b[$i]) <=> str_replace(" ", "", $a[$i]);
    }
    return 1;
});

//Format the output
foreach(array_pop($solutions) as $line) {
    echo strtr($line, "01", "LR") . "\n";
}
?>
