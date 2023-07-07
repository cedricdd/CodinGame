<?php

function generateMinimumSpanningTree(array $artefacts, array $distances): array {
    //We start with the first artefact
    $tree[array_key_last($artefacts)] = [];

    array_pop($artefacts);
    $totalDistance = 0.0;

    while(count($artefacts)) {
        $linkBest = [];
        $distanceBest = INF;

        //We want to add the link from any of the artefacts already in the tree with the smallest distance that leads to an artifact not already in the tree
        foreach($tree as $name => $filler) {
            foreach($distances[$name] as $name2 => $distance) {
                if(isset($tree[$name2]) == false && $distance < $distanceBest) {
                    $linkBest = [$name, $name2];
                    $distanceBest = $distance;
                }
            }
        }

        $tree[$linkBest[0]][] = $linkBest[1];
        $tree[$linkBest[1]][] = $linkBest[0];
        $totalDistance += $distanceBest;

        unset($artefacts[$linkBest[1]]);
    }

    echo ceil($totalDistance) . PHP_EOL;

    return $tree;
}

//Find the path between the current position and the next artefact in the list
function findPath(string $start, string $goal, array $tree): array {
    $path = [];

    $toExplore = [[$start, []]];

    while(count($toExplore)) {
        [$position, $moves] = array_pop($toExplore);

        $moves[$position] = 1;

        if(strcmp($position, $goal) === 0) return array_keys($moves);

        foreach($tree[$position] as $symbol) {
            //Let's not start a loop
            if(isset($moves[$symbol]) == false) $toExplore[] = [$symbol, $moves];
        }
    }
}

//Collect the artefacts
function collectArtefacts(array $tree, array $list, array $artefacts): void {
    $position = "#";
    $visited = [];

    foreach($list as $symbol => $name) {
        $moves = findPath($position, $symbol, $tree);

        for($i = 1; $i < count($moves); ++$i) {
            //Moving to the hill has a special output
            if($moves[$i] !== "#") {
                $line = "Go to " . $moves[$i];
                
                //If we haven't been there already we need to output the steps and the directions
                if(!isset($visited[$moves[$i]])) {
                    $x = $artefacts[$moves[$i]][0] - $artefacts[$position][0];
                    $y = $artefacts[$moves[$i]][1] - $artefacts[$position][1];

                    $line .= " :" . ($y != 0 ? " " . abs($y) . " " . ($y > 0 ? "S" : "N") : "") . ($x != 0 ? " " . abs($x) . " " . ($x > 0 ? "E" : "W") : "");
                }
                
                echo $line . PHP_EOL;
            }
            else echo "Go to Hill" . PHP_EOL;

            $position = $moves[$i];
            $visited[$moves[$i]] = 1;
        }

        if($symbol !== "#") echo "Collect $name" . PHP_EOL;
    }
}

fscanf(STDIN, "%d %d %d", $n, $w, $h);
for ($i = 0; $i < $n; $i++) {
    preg_match("/(.) (.*)/", trim(fgets(STDIN)), $matches);

    $list[$matches[1]] = $matches[2];
}

$list["#"] = "Go to Hill"; //We want to return to the hill at the end

$artefacts = [];
$distances = [];

for ($y = 0; $y < $h; $y++) {
    $line = trim(fgets(STDIN));

    for ($x = 0; $x < $w; ++$x) {
        //We only care about the arefacts we need to collect, ignore all the rest
        if(isset($list[$line[$x]])) {
            $artefact = $line[$x];

            foreach($artefacts as $name => [$xa, $ya]) {
                $distance = sqrt(($xa - $x) ** 2 + ($ya - $y) ** 2);

                $distances[$artefact][$name] = $distance;
                $distances[$name][$artefact] = $distance;
            }

            $artefacts[$artefact] = [$x, $y];
        }
    }
}

$tree = generateMinimumSpanningTree($artefacts, $distances);

collectArtefacts($tree, $list, $artefacts);
