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
            if(abs($angle) < 45) {
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
$sum = array_sum($trees);

echo number_format(intval($sum * 100) / 100, 2, '.', '') . PHP_EOL;

$groups = [];

//Build the bridges
while($trees) {
    $tree = array_pop($trees);

    foreach($groups as &$length) {
        if($length >= $tree) {
            $length -= $tree;
            continue 2;
        }
    }

    $groups[] = 1000 - $tree;
}

echo count($groups) . PHP_EOL;
