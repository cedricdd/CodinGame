<?php
fscanf(STDIN, "%d", $x);
fscanf(STDIN, "%d", $n);

$codes = range(0, $x - 1);

//Generate all the possible codes
for($i = 0; $i < $n - 1; ++$i) {
    foreach($codes as $index => $code) {
        for($j = 0; $j < $x; ++$j) {
            $codes[] = $code . $j;
        }
        unset($codes[$index]);
    }
}

//Generate the de Bruijn graph 
//https://en.wikipedia.org/wiki/De_Bruijn_graph
foreach($codes as $code) {
    $links[substr($code, 0, -1)][] = substr($code, 1);
}

function solve($position, $stack, $links) {

    //We can still reach some nodes from this position, move to the smallest one
    if(count($links[$position])) {
        return solve(array_shift($links[$position]), array_merge($stack, [$position]), $links);
    } //We can't move anywhere from this position, add the last digit of the position is part of the sequence and backtrack
    else {
        $d = $position[-1];

        //No more backtracking
        if(empty($stack)) return $d;

        return solve(array_pop($stack), $stack, $links) . $d;
    }
}

//The shortest sequence is the Eulerian path in the de Bruijn graph
//https://en.wikipedia.org/wiki/Eulerian_path
//We use the smallest index as starting point
echo str_repeat('0', max(1, $n - 2)) . solve(array_key_first($links), [], $links);
?>
