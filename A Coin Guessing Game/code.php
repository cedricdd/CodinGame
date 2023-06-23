<?php

fscanf(STDIN, "%d %d", $N, $T);

$odd = array_flip(range(1, $N * 2, 2));
$even = array_flip(range(2, $N * 2, 2));

//We start we all the odds being possible for all the evens
for($i = 0; $i < $N; ++$i) {
    $possibilities[$i * 2 + 1] = $even;
    $possibilities[($i + 1) * 2] = $odd;
}

for ($i = 0; $i < $T; $i++) {
    $inputs = explode(" ", trim(fgets(STDIN)));
    $numbers = [];

    //We split numbers between odd & even
    array_walk($inputs, function($number) use (&$numbers) {
        $numbers[$number & 1][] = $number;
    });

    foreach($numbers[1] ?? [] as $numberOdd) {
        foreach($numbers[0] ?? [] as $numberEven) {
            //Update what we know is not possible
            unset($possibilities[$numberOdd][$numberEven]);
            unset($possibilities[$numberEven][$numberOdd]);
        }
    }
}

while(count($possibilities)) {
    foreach($possibilities as $index => $list) {
        //We have found an association, only 1 possibility 
        if(count($list) == 1) {
            if($index & 1) [$odd, $even] = [$index, array_key_first($list)];
            else [$even, $odd] = [$index, array_key_first($list)];

            $answer[$odd] = $even;

            unset($possibilities[$odd]);
            unset($possibilities[$even]);

            //Both the odd & even number can't be associated with another number
            foreach($possibilities as &$listToUpdated) {
                unset($listToUpdated[$odd]);
                unset($listToUpdated[$even]);
            }
        }
    }
}

ksort($answer); //We need to output by ascending odd numbers

echo implode(" ", $answer) . PHP_EOL;
