<?php

function solve(int $id, int $startX, int $y) {
    global $output, $nodes, $widthBlock;

    [$name, $left, $right, $leftCount, $rightCount] = $nodes[$id];

    $width = ($leftCount + $rightCount + 1) * $widthBlock;
    $endName = $startX + ($leftCount + 1) * $widthBlock - 1;
    $widthName = strlen($name);

    //Add node's name
    $output[$y] = substr_replace($output[$y], $name, $endName - $widthName + 1, $widthName);

    //There's another level
    if($left != -1 || $right != -1) {
        $output[$y + 1][$endName] = '|';
        $output[$y + 2][$endName] = '+';
    }

    //We have something on the left
    if($left != -1) {
        $leftPosition = $startX + ($nodes[$left][3] + 1) * $widthBlock - 1;

        for($i = $leftPosition + 1; $i < $endName; ++$i) $output[$y + 2][$i] = '-';
     
        $output[$y + 2][$leftPosition] = '+';    
        $output[$y + 3][$leftPosition] = '|'; 

        solve($left, $startX, $y + 4);
    }
    
    //We have something on the right
    if($right != -1) {
        $rightPosition = $startX + (1 + $nodes[$right][3] + 1) * $widthBlock - 1;
        if($left != -1) $rightPosition += ($nodes[$left][3] + 1 + $nodes[$left][4]) * $widthBlock;

        for($i = $rightPosition - 1; $i > $endName; --$i) $output[$y + 2][$i] = '-';
    
        $output[$y + 2][$rightPosition] = '+';    
        $output[$y + 3][$rightPosition] = '|'; 

        solve($right, $endName + 1, $y + 4);
    }
}

//Count how many children are on each side of the node
function countChildren(int $id) {
    global $nodes;

    [, $left, $right] = $nodes[$id];

    //Node has a left child
    if($left != -1) {
        countChildren($left);

        $count = 1 + $nodes[$left][3] + $nodes[$left][4];
    } else $count = 0;

    $nodes[$id][3] = $count;

    //Node has a right child
    if($right != -1) {
        countChildren($right);

        $count = 1 + $nodes[$right][3] + $nodes[$right][4];
    } else $count = 0;

    $nodes[$id][4] = $count;
}

$widthBlock = 0;

fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %d %d", $name, $left, $right);

    $nodes[$i] = [$name, $left, $right];

    if(strlen($name) > $widthBlock) $widthBlock = strlen($name);
}

$widthBlock++; //The width of 'cells'

$output = array_fill(0, max(1, ($N - 1) + 3 * ($N - 2)), str_repeat(" ", $widthBlock * $N)); //We assume worst case scenario, only using right or left

countChildren(0);
solve(0, 0, 0);

foreach($output as $i => $line) {
    if(empty(trim($line))) {
        error_log("$i is empty");
        $output = array_slice($output, 0, $i);
        break;
    }
}

echo implode("\n", array_map("rtrim", $output));
