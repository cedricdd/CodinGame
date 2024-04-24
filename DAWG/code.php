<?php

function addWord(string $word) {
    global $nodes;

    $node = &$nodes[0]; //We start at the root
    $len = strlen($word);

    for($i = 0; $i < $len; ++$i) {
        $letter = $word[$i];

        //This node currently doesn't have a link for this letter
        if(!isset($node[$letter])) $node[$letter] = [];
        
        $node = &$node[$letter]; //Update the node index
    }

    $node["end"] = [];
}

function findUnique(array $data) {
    global $unique;

    foreach($data as $letter => $links) {
        $s = serialize($links); //Representation of the node this letter points to

        //It's the first time we found this "type" of node
        if(!isset($unique[$s])) {
            $unique[$s] = 1;

            findUnique($links);
        }
    }
}

$start = microtime(1);

$nodes = [];
$nodes[] = []; //Add the root

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $words[] = trim(fgets(STDIN));
}

sort($words); //To be able to easily compare nodes we need to make sure letters are always added in the same order (ie alphabetically)

foreach($words as $word) addWord($word);

$unique = [];

findUnique($nodes[0]);

echo (count($unique) + 1) . PHP_EOL;

error_log(microtime(1) - $start);
