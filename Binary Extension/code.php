<?php


function findPath() {
    global $width, $height, $bombs, $goals, $n;

    $root = $width >> 1;

    //The root is a node we need to use
    $forcedNodes[$root] = 1;

    //Every goals is a node we need to use
    foreach($goals as $index => $filler) {
        $forcedNodes[$index] = 1;
    }

    foreach($goals as $index => $filler) {
        $paths = [[$index => 1]];
        $solutions = [];
        $nodeUSed = count($forcedNodes);

        while($paths) {
            $newPaths = [];

            foreach($paths as $path) {
                $index = array_key_last($path);
                $x = $index % $width;
                $y = intdiv($index, $width);

                // error_log("we are at $x $y");

                if($y == 0) {
                    if($x == $root) $solutions[] = $path;
                    continue;
                }

                //Left
                $indexL = $index - $width - 1;
                if($x > 0 && !isset($bombs[$indexL])) $newPaths[] = $path + [$indexL => 1];
                //Right
                $indexR = $index - $width + 1;
                if($x < $width - 1 && !isset($bombs[$indexR]))  $newPaths[] = $path + [$indexR => 1];
                
            }

            $paths = $newPaths;
        }

        error_log("for $x $y");
        error_log(var_export($solutions, 1));

        //Any nodes in all the solutions is a forced node;
        foreach($solutions as $path) {
            foreach($path as $index => $filler) {
                @$counts[$index]++;
            }
        }

        $countSolution = count($solutions);

        foreach($counts as $index => $count) {
            if($count == $countSolution) {
                error_log("$index is a forced node");
                $forcedNodes[$index] = 1;
            }
        }
    }
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

error_log(var_export($bombs, 1));
error_log(var_export($goals, 1));

findPath();
