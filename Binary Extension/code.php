<?php

class Node {
    public $index;
    public $left;
    public $right;
    public $leftCount;
    public $rightCount;

    public function __construct(int $index) {
        $this->index = $index;
        $this->left = null;
        $this->leftCount = 0;
        $this->right = null;
        $this->rightCount = 0;
    }
}

function placeNumbers(Node $node, int $min, int $max): array {

    $numberUsed = $min + $node->leftCount; //The number we use at this node 
    $result = [$numberUsed => 1];

    if($node->leftCount)  $result += placeNumbers($node->left, $min, $numberUsed - 1);
    if($node->rightCount) $result += placeNumbers($node->right, $numberUsed + 1, $max);

    return $result;
}

function getSolution(array $path): array {
    global $n, $height, $width;

    $root = $width >> 1;

    $nodes[$root] = new Node($root);

    getChildrenCount($nodes, $path, $root); //For each nodes we need to know how many nodes we want to reach by moving left & right

    return placeNumbers($nodes[$root], 1, $n);
}

function getChildrenCount(array &$nodes, array &$path, int $index): int {
    global $width, $height;

    $x = $index % $width;

    //The path could be moving left
    if($x > 0) {
        $indexL = $index + $width - 1;

        //The node on the left is part of the path and isn't already 'claimed' by the other parent
        if(isset($path[$indexL]) && !isset($nodes[$indexL])) {
            $nodes[$indexL] = new Node($indexL);

            $nodes[$index]->left = &$nodes[$indexL];
            $nodes[$index]->leftCount = getChildrenCount($nodes, $path, $indexL);
        }
    }
    //The path could be moving right
    if($x < $width - 1) {
        $indexR = $index + $width + 1;

        //The node on the right is part of the path and isn't already 'claimed' by the other parent
        if(isset($path[$indexR]) && !isset($nodes[$indexR])) {
            $nodes[$indexR] = new Node($indexR);

            $nodes[$index]->right = &$nodes[$indexR];
            $nodes[$index]->rightCount = getChildrenCount($nodes, $path, $indexR);
        }
    }

    return 1 + $nodes[$index]->leftCount + $nodes[$index]->rightCount;
}

//Find all the paths starting from root that reach all the goals without passing by any bombs
function findPath(): array {
    global $width, $height, $bombs, $goals, $n;

    $solutions = [[]];
    $root = $width >> 1;

    //The root is a node we need to use
    $forcedNodes[$root] = 1;

    //Every goals is a node we need to use
    foreach($goals as $index => $filler) {
        $forcedNodes[$index] = 1;
    }

    //Find all the path from the goal to the root
    foreach($goals as $indexGoal => $filler) {
        $paths = [[[$indexGoal => 1], count($forcedNodes)]];
        $goalSolutions = [];

        while($paths) {
            $newPaths = [];

            foreach($paths as [$path, $nodeUsed]) {
                $index = array_key_last($path);
                $x = $index % $width;
                $y = intdiv($index, $width);

                //We are on the first row
                if($y == 0) {
                    if($x == $root) $goalSolutions[] = $path; //We found a path to the root
                    continue;
                }

                if($nodeUsed > $n) continue; //We don't have enough numbers for this path

                //We are moving left
                $indexL = $index - $width - 1;
                if($x > 0 && !isset($bombs[$indexL])) $newPaths[] = [$path + [$indexL => 1], $nodeUsed + (isset($forcedNodes[$indexL]) ? 0 : 1)];
                //We are moving right
                $indexR = $index - $width + 1;
                if($x < $width - 1 && !isset($bombs[$indexR]))  $newPaths[] = [$path + [$indexR => 1], $nodeUsed + (isset($forcedNodes[$indexR]) ? 0 : 1)];
            }

            $paths = $newPaths;
        }

        $counts = [];

        //Any nodes in all the solutions is a forced node;
        foreach($goalSolutions as $path) {
            foreach($path as $index => $filler) {
                @$counts[$index]++;
            }
        }

        $countSolution = count($goalSolutions);

        foreach($counts as $index => $count) {
            if($count == $countSolution) $forcedNodes[$index] = 1;
        }

        //We merge the solutions of this goal with our existing solutions
        $newSolutions = [];

        foreach($solutions as $s1) {
            foreach($goalSolutions as $s2) {
                $mergedSolution = $s1 + $s2;

                //Make sure the merged solution doesn't use too much numbers
                if(count($mergedSolution) <= $n) $newSolutions[] = $mergedSolution;
            }
        }

        $solutions = $newSolutions;
    }

    return $solutions;
}

fscanf(STDIN, "%d %d %d %d %d", $width, $height, $n, $bombsCount, $goalsCount);

$start = microtime(1);

$bombs = [];
$goals = [];

error_log("Total $n - $width $height");

for ($i = 0; $i < $bombsCount; $i++) {
    fscanf(STDIN, "%d %d", $x, $y);

    $bombs[$y * $width + $x] = 1;
}
for ($i = 0; $i < $goalsCount; $i++) {
    fscanf(STDIN, "%d %d", $x, $y);

    $goals[$y * $width + $x] = 1;
}

$paths = findPath();

//There might be several valid paths, we can use any of them
$solution = getSolution($paths[random_int(0, count($paths) - 1)]);

echo implode(PHP_EOL, array_keys($solution)) . PHP_EOL;

error_log(microtime(1) - $start);
