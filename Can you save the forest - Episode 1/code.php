<?php

// $maxBurnedForest: the maximum number of forest tiles that you are allowed to let burn
fscanf(STDIN, "%d", $maxBurnedForest);

error_log("Max is $maxBurnedForest");

function solve(array $fires, array $burnt, array $actions, string $hash) {
    global $neighbors, $maxBurnedForest, $solution;
    static $history = [];

    $countBurnt = count($burnt);

    // error_log("we currently have $countBurnt");
    // error_log($hash);

    if($countBurnt > $maxBurnedForest) return;
    if($countBurnt >= $solution[0]) return;
    if($solution[0] != INF) return;

    if(count($fires) == 0) {
        error_log("We have a solution with $countBurnt");
        error_log(implode("-", $actions));
        $solution = [$countBurnt, $actions];
        return;
    }

    if(isset($history[$hash])) {
        // error_log("using history -- $hash");
        return;
    }
    else $history[$hash] = 1;


    $countAction = count($actions);

    foreach($fires as $index => $c) {
        // error_log("using water on $index");

        $actions[$countAction] = $index;

        $hash2 = $hash;
        $burnt2 = $burnt;
        $fires2 = $fires;
        
        unset($fires2[$index]);
        $hash2[$index] = '^';

        foreach($fires2 as $index2 => $c2) {
            if($c2 < 3) {
                $fires2[$index2]++; 
                $hash2[$index2] = ($c2 + 1);
            }
            else {
                unset($fires2[$index2]);
                $burnt2[$index2] = 1;
                $hash2[$index2] = '*';

                foreach($neighbors[$index2] as $nIndex) {
                    if(isset($burnt2[$nIndex])) continue;
                    if(isset($fires2[$nIndex])) continue;

                    $fires2[$nIndex] = 1;
                    $hash2[$nIndex] = '1';
                }
            }
        }

        solve($fires2, $burnt2, $actions, $hash2);
    }
}

$solution = [INF, []];

while (TRUE) {
    $start = microtime(1);

    $fires = [];
    $map = [];

    for ($y = 0; $y < 10; ++$y) {
        $map[] = trim(fgets(STDIN));
    }

    error_log(var_export($map, true));

    for($y = 0; $y < 10; ++$y) {
        for($x = 0; $x < 10; ++$x) {
            if($map[$y][$x] == ".") continue;

            $index = $y * 10 + $x;

            if(ctype_digit($map[$y][$x])) $fires[$index] = $map[$y][$x];

            if($x > 0 && $map[$y][$x - 1] != ".") $neighbors[$index][] = $index - 1;
            if($x < 9 && $map[$y][$x + 1] != ".") $neighbors[$index][] = $index + 1;
            if($y > 0 && $map[$y - 1][$x] != ".") $neighbors[$index][] = $index - 10;
            if($y < 9 && $map[$y + 1][$x] != ".") $neighbors[$index][] = $index + 10;
        }
    }

    // error_log(var_export($neighbors, true));
    // error_log(var_export($fires, true));

    // exit();

    if(count($solution[1]) == 0) solve($fires, [], [], implode("", $map));

    $index = array_shift($solution[1]);
    echo ($index % 10) . " " . (intdiv($index, 10)) . PHP_EOL;

    error_log(microtime(1) - $start);
}
