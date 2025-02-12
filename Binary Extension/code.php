<?php

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

    foreach($goals as $indexGoal => $filler) {
        $paths = [[[$indexGoal => 1], count($forcedNodes)]];
        $goalSolutions = [];

        error_log("starting with " . count($forcedNodes));

        while($paths) {
            $newPaths = [];

            foreach($paths as [$path, $nodeUsed]) {
                $index = array_key_last($path);
                $x = $index % $width;
                $y = intdiv($index, $width);

                // error_log("we are at $x $y");

                if($y == 0) {
                    if($x == $root) $goalSolutions[] = $path;
                    continue;
                }

                if($nodeUsed > $n) continue; //We don't have enough number for this path

                //Left
                $indexL = $index - $width - 1;
                if($x > 0 && !isset($bombs[$indexL])) $newPaths[] = [$path + [$indexL => 1], $nodeUsed + (isset($forcedNodes[$indexL]) ? 0 : 1)];
                //Right
                $indexR = $index - $width + 1;
                if($x < $width - 1 && !isset($bombs[$indexR]))  $newPaths[] = [$path + [$indexR => 1], $nodeUsed + (isset($forcedNodes[$indexR]) ? 0 : 1)];
            }

            $paths = $newPaths;
        }

        // error_log("for $indexGoal");
        // error_log(var_export($goalSolutions, 1));

        $counts = [];

        //Any nodes in all the solutions is a forced node;
        foreach($goalSolutions as $path) {
            foreach($path as $index => $filler) {
                @$counts[$index]++;
            }
        }

        $countSolution = count($goalSolutions);

        foreach($counts as $index => $count) {
            if($count == $countSolution) {
                error_log("$index is a forced node");
                $forcedNodes[$index] = 1;
            }
        }

        //We merge the solution of this goal with our existing solutions
        $newSolutions = [];

        foreach($solutions as $s1) {
            foreach($goalSolutions as $s2) {
                $mergedSolution = $s1 + $s2;

                if(count($mergedSolution) <= $n) $newSolutions[] = $mergedSolution;
            }
        }

        $solutions = $newSolutions;

        // error_log(var_export($solutions, 1));
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

// error_log(var_export($bombs, 1));
// error_log(var_export($goals, 1));

$paths = findPath();

error_log(var_export($paths, 1));

error_log(microtime(1) - $start);
