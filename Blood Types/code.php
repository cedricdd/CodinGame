<?php

const RESULT1 = [
    'A+' => ['A+', 'A-', 'O+', 'O-'],
    'A-' => ['A-', 'O-'],
    'B+' => ['B+', 'B-', 'O+', 'O-'],
    'B-' => ['B-', 'O-'],
    'O+' => ['O+', 'O-'],
    'O-' => ['O-'],
    'AB+' => ['A+', 'A-', 'B+', 'B-'],
    'AB-' => ['A-', 'B-'],
];

const RESULT2 = [
    'A+' => ['A+' => 'A+', 'A-' => 'A+', 'B+' => 'AB+', 'B-' => 'AB+', 'O+' => 'A+', 'O-' => 'A+'],
    'A-' => ['A+' => 'A+', 'A-' => 'A-', 'B+' => 'AB+', 'B-' => 'AB-', 'O+' => 'A+', 'O-' => 'A-'],
    'B+' => ['A+' => 'AB+', 'A-' => 'AB+', 'B+' => 'B+', 'B-' => 'B+', 'O+' => 'B+', 'O-' => 'B+'],
    'B-' => ['A+' => 'AB+', 'A-' => 'AB-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'B+', 'O-' => 'B-'],
    'O+' => ['A+' => 'A+', 'A-' => 'A+', 'B+' => 'B+', 'B-' => 'B+', 'O+' => 'O+', 'O-' => 'O+'],
    'O-' => ['A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-', 'O+' => 'O+', 'O-' => 'O-'],
];

//We have both parents, generate all the possible children
function generateChild(string $p1, string $p2): array {
    $possibilities = [];

    foreach(RESULT1[$p1] as $rp1) {
        foreach(RESULT1[$p2] as $rp2) {
            $possibilities[RESULT2[$rp1][$rp2]] = 1;
        }
    }

    return $possibilities;
}

//We have a parent and the child, generate all the possible second parent
function generateParent(string $parent, string $child): array {
    $possibilities = [];

    foreach(RESULT1[$parent] as $p1) {
        foreach(RESULT1 as $p2 => $list) {
            foreach($list as $type) {
                if(RESULT2[$p1][$type] == $child) {
                    $possibilities[$p2] = 1;

                    continue 2;
                }
            }
        }
    }

    return $possibilities;
}

fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s %s %s", $parent1, $parent2, $child);

    if($child == '?') {
        $list = generateChild($parent1, $parent2);

        ksort($list);

        echo implode(" ", array_keys($list)) . PHP_EOL;
    } else {
        $list = generateParent(($parent1 == '?' ? $parent2 : $parent1), $child);

        if(!$list) echo "impossible" . PHP_EOL;
        else {
            ksort($list);

            echo implode(" ", array_keys($list)) . PHP_EOL;
        }
    }
}
