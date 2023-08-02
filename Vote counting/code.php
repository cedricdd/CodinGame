<?php

fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $M);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %d", $personName, $nbVote);

    $voters[$personName] = $nbVote;
}

for ($i = 0; $i < $M; $i++) {
    fscanf(STDIN, "%s %s", $voterName, $voteValue);

    $votes[$voterName][] = $voteValue;
}

$counts = ["Yes" => 0, "No" => 0, "Invalid" => 0];

foreach($votes as $voter => $list) {
    if(!isset($voters[$voter]) || count($list) > $voters[$voter]) continue;

    array_walk($list, function($vote) use (&$counts) {
        //Antying that's not Yes or No is invalid
        $counts[preg_replace("/^(?!(Yes|No)$).*$/", "Invalid", $vote)]++;
    });
}

echo $counts["Yes"] . " " . $counts["No"] . PHP_EOL;
