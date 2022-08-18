<?php

for ($i = 0; $i < 4; $i++) {
    fscanf(STDIN, "%d", $numbers[]);
}

//Generate all the permutations with the list of numbers
function generatePermutations(array $numbers, array $permutation, array &$permutations): void {
    if(count($numbers) == 0) {
        $permutations[implode("-", $permutation)] = $permutation; //We don't need duplicate permutations
        return;
    }

    foreach($numbers as $i => $number) {
        $permutation[] = $number;
        unset($numbers[$i]);
        generatePermutations($numbers, $permutation, $permutations);

        $numbers[$i] = $number;
        array_pop($permutation);
    }
}

$permutations = [];
generatePermutations($numbers, [], $permutations);

function solve($numbers) {

    if(count($numbers) == 1) return [array_pop($numbers)];

    $results = [];

    for($i = 1; $i < count($numbers); ++$i) {
        $left = solve(array_slice($numbers, 0, $i)); //All the possible values we can generate with the numbers from start-$i
        $right = solve(array_slice($numbers, $i)); //All the possible values we can generate with the numbers from $i-end

        //Apply the 4 operations
        foreach($left as $nl) {
            foreach($right as $nr) {
                $results[] = $nl + $nr;
                $results[] = $nl - $nr;
                $results[] = $nl * $nr;
                if($nr != 0) $results[] = $nl / $nr;
            }
        }
    }

    return $results;
}

//Check each permutations
foreach($permutations as $permutation) {
    foreach(solve($permutation) as $value) {
        //We are able to generate 24
        if(round($value, 8) == 24) die("true");
    }
}

echo "false" . PHP_EOL;
?>
