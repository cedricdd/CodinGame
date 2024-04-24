<?php

function addWord(string $word) {
    global $nodes;

    $nodeIndex = 0; //We start at the root
    $len = strlen($word);

    for($i = 0; $i < $len; ++$i) {
        $index = $word[$i];

        //This node currently doesn't have a link for this letter
        if(!isset($nodes[$nodeIndex]["childs"][$index])) {
            $nodes[] = ["childs" => [], "end" => $i == $len - 1];
            $newNodeIndex = array_key_last($nodes);

            $nodes[$nodeIndex]["childs"][$index] = $newNodeIndex;
        } 
        
        $nodeIndex = $nodes[$nodeIndex]["childs"][$index]; //Update the node index
    }
}

function checkIfSimilar(int $n1, int $n2): bool {
    static $history;
    global $nodes, $redirections;

    //Check if we have previously merge any of the nodes
    if(isset($redirections[$n1])) $n1 = $redirections[$n1];
    if(isset($redirections[$n2])) $n2 = $redirections[$n2];

    if(isset($history[$n1][$n2])) return $history[$n1][$n2];

    //One is an end, the other isn't, they are not similar
    if($nodes[$n1]["end"] != $nodes[$n2]["end"]) {
        return $history[$n1][$n2] = $history[$n2][$n1] = false;
    }

    //They don't have the same number of children, they are not similar
    if(count($nodes[$n1]["childs"]) != count($nodes[$n2]["childs"])) {
        return $history[$n1][$n2] = $history[$n2][$n1] = false; 
    }

    foreach($nodes[$n1]["childs"] as $letter => $childID) {
        //Node 2 doesn't have a child with that letter, they are not similar
        if(!isset($nodes[$n2]["childs"][$letter])) {
            return $history[$n1][$n2] = $history[$n2][$n1] = false; 
        } //Check recursivly if the children are similar 
        elseif(checkIfSimilar($childID, $nodes[$n2]["childs"][$letter]) == false) {
            return $history[$n1][$n2] = $history[$n2][$n1] = false; 
        }
    }

    return $history[$n1][$n2] = $history[$n2][$n1] = true;
}

function minimize() {
    global $nodes, $redirections;

    $count = count($nodes);

    for($i = 0; $i < $count; ++$i) {
        if(!isset($nodes[$i])) continue;

        for($j = $i + 1; $j < $count; ++$j) {
            if(!isset($nodes[$j])) continue;

            //If two nodes are similar we can merge them
            if(checkIfSimilar($i, $j)) {
                unset($nodes[$j]);

                $redirections[$j] = $i;
            }
        }
    }
}

$start = microtime(1);

$nodes = [];
$nodes[] = ["childs" => [], "end" => false]; //Add the root

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    addWord(trim(fgets(STDIN)));
}

minimize();

echo (count($nodes) + 1) . PHP_EOL;

error_log(microtime(1) - $start);
