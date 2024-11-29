<?php

function find(array $parents, int $index): int {
    if($parents[$index] != $index) return find($parents, $parents[$index]);
    else return $parents[$index];
}

function kruskal(int $count, array $links): array {
    $trees = [];
    $parents = range(0, $count - 1);
    $ranks = array_fill(0, $count, 0);

    foreach($links as [$i, $j, $distance]) {
        $fi = find($parents, $i);
        $fj = find($parents, $j);

        //We add the link, no cycle
        if($fi != $fj) {
            $trees[] = $distance;

            if($ranks[$fi] > $ranks[$fj]) $parents[$fj] = $fi;
            elseif($ranks[$fj] > $ranks[$fi]) $parents[$fi] = $fj;
            else {
                $parents[$fj] = $fi;
                $ranks[$fi]++;
            }
        }
    }

    sort($trees);

    return $trees;
}

$islands = [[1, 1, 1]];

fscanf(STDIN, "%d", $n);

for ($i = 1; $i <= $n; $i++) {
    fscanf(STDIN, "%f %f %f", $x, $y, $z);

    foreach($islands as $j => [$x2, $y2, $z2]) {
        $distance = sqrt(($x - $x2) ** 2 + ($y - $y2) ** 2 + ($z - $z2) ** 2);

        //Distance is too big to add a bridge
        if($distance <= 1000) {
            $d = sqrt(($x - $x2) ** 2 + ($y - $y2) ** 2);

            if($d == 0) $angle = 90;
            else $angle = atan(($z2 - $z) / $d) * 180 / pi();

            //Angle isn't too steep to add a bridge
            if(abs(round($angle, 2)) <= 45) {
                $links[] = [$i, $j, $distance];
            }
        }
    }

    $islands[$i] = [$x, $y, $z];
}

usort($links, function($a, $b) {
    return $a[2] <=> $b[2];
});

$trees = kruskal(count($islands), $links);

echo number_format(array_sum($trees), 2, '.', '') . PHP_EOL;

$groupIndex = 0;
$groups = [0];

//Greedily add the bridges in groups without exceeding 1000
foreach($trees as $tree) {
    if($tree + $groups[$groupIndex] <= 1000) $groups[$groupIndex] += $tree;
    else {
        $groupIndex++;
        $groups[$groupIndex] = $tree;
    }
}

echo number_format(count($groups) * 1000 - array_sum($groups), 2, '.', '') . PHP_EOL;
echo ($groupIndex + 1) . PHP_EOL;
