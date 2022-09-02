<?php

$links = [];
$checked = [];
$emergencies = [];

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $cellInfo = explode(" ", trim(fgets(STDIN)));
    $links[$cellInfo[0]] = array_slice($cellInfo, 2);
}

//One cell and no corridors
if($N == 1) die("1");

function solve($n, $parent) {
    global $links, $checked, $emergencies;

    $checked[$n] = 1;
    foreach($links[$n] ?? [] as $cell) {
        //Call all the children we haven't checked yet, current cell becomes their parent
        if(!isset($checked[$cell])) solve($cell, $n);
    }

    //If current cell & parent cell has no emergency exit we have to add one in the parent cell
    if($parent == 0 || isset($emergencies[$n]) || isset($emergencies[$parent])) return;

    $emergencies[$parent] = 1;
}

//It's an undirected tree, we can use any node as root, we just use 1
solve(1, 0);

echo count($emergencies) . PHP_EOL;
?>
