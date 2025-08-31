<?php

fscanf(STDIN, "%d", $C);

for ($i = 0; $i < $C; $i++) {
    $names[$i + 1] = stream_get_line(STDIN, 50 + 1, "\n");
}

fscanf(STDIN, "%d", $V);

for ($i = 0; $i < $V; $i++) {
    $votes[] = explode(" ", stream_get_line(STDIN, 256 + 1, "\n"));
}

for($i = 0; $i < $C - 1; ++$i) {
    $counts = [];

    //Everybody starts with no votes
    foreach($names as $j => $name) $counts[$j] = 0;

    foreach($votes as $vote) {
        //This candidates has been eliminated
        while(!isset($names[$vote[0]])) array_shift($vote);
        $counts[$vote[0]]++;
    }

    //The next candidate eliminated
    $id = array_search(min($counts), $counts);

    echo $names[$id] . PHP_EOL;

    unset($names[$id]);
}

echo "winner:" . array_pop($names) . PHP_EOL;
