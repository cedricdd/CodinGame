<?php

function solve(array $list) {
    global $authors, $publications, $scientist, $closest, $closestList;
    static $history = [];

    $count = count($list);
    $pID = array_key_last($list);

    //We have found a link to our scientist
    if(array_search($scientist, $publications[$pID]) !== false) {
        if($count < $closest) {
            $closest = $count;
            $closestList = $list;
        }

        return;
    }

    //Check all the publications we can reach from the current one
    foreach($publications[$pID] as $author) {
        foreach($authors[$author] as $pID2) {
            if(isset($list[$pID2])) continue;

            $list[$pID2] = 1;

            solve($list);

            unset($list[$pID2]);
        }
    }
}

$scientist = trim(fgets(STDIN));

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++){
    $titles[] = trim(fgets(STDIN));
}

for ($i = 0; $i < $N; $i++) {
    $publications[$i] = explode(" ", trim(fgets(STDIN)));

    foreach($publications[$i] as $author) {
        $authors[$author][] = $i;
    }
}

if($scientist == "Erdős") exit("0");

$closest = INF;
$closestList = [];

//We try to start with all the publications Erdos did
foreach($authors["Erdős"] as $publicationID) {
    solve([$publicationID => 1]);
}

if($closest == INF) echo "infinite" . PHP_EOL;
else echo $closest . PHP_EOL . implode(PHP_EOL, array_map(function($id) use ($titles) {
    return $titles[$id];
}, array_reverse(array_keys($closestList)))) . PHP_EOL;
