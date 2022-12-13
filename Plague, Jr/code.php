<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $A, $B);

    $links[$A][] = $B;
    $links[$B][] = $A;
}

function dfs(int $node): array {
    global $links;

    $length = 0;
    $visited = [];
    $toCheck = [$node];

    while(true) {
        $newCheck = [];

        foreach($toCheck as $node) {
            $visited[$node] = 1;

            foreach($links[$node] as $destination) {
                if(!isset($visited[$destination])) {
                    $newCheck[] = $destination;
                }
            }
        }

        if(count($newCheck) == 0) break;

        ++$length;
        $toCheck = $newCheck;
    }

    return [$node, $length];
}

//We start a DFS from node 0, any points we reach during the last turn is an end point of the diameter of the tree
[$endNode, $length] = dfs(0); 
//We start a DFS from the end node of the previous DFS to find the length of the diameter of the tree
[$endNode, $length] = dfs($endNode); 

echo ceil($length / 2) . PHP_EOL;
