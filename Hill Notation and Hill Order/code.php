<?php

function getElements(array &$elements, bool &$hasCarbon, string $compound, int $multiplier = 1) {
    preg_match_all("/([A-Z][a-z]*)([0-9]*)/", $compound, $matches);

    foreach($matches[1] as $j => $element) {
        $count = intval($matches[2][$j]) ?: 1;

        if(isset($elements[$element])) $elements[$element][1] += ($count * $multiplier);
        else $elements[$element] = [$element, ($count * $multiplier)];

        if($element == 'C') $hasCarbon = true;
    }
}

$notations = [];

fscanf(STDIN, "%d", $numCompounds);
for ($i = 0; $i < $numCompounds; $i++) {
    $compound = stream_get_line(STDIN, 128 + 1, "\n");

    $elements = [];
    $hasCarbon = false;

    //Take care of parenthesis group
    while(true) {
        preg_match("/\(([^\(\)]+)\)([0-9]+)/", $compound, $match);

        if(!$match) break; //No parenthesis group left

        getElements($elements, $hasCarbon, $match[1], intval($match[2]));

        $compound = str_replace($match[0], "", $compound);
    }

    getElements($elements, $hasCarbon, $compound, 1);

    usort($elements, function($a, $b) use ($hasCarbon) {
        //Carbon first, then hydrogen, then other sorted alphabetically 
        if($hasCarbon) {
            if($a[0] == 'C') return -1;
            elseif($b[0] == 'C') return 1;
            elseif($a[0] == 'H') return -1;
            elseif($b[0] == 'H') return 1;
            else return $a[0] <=> $b[0];
        } //All elements alphabetically
        else return $a[0] <=> $b[0];
    });

    $notations[] = $elements;
}

//Hill order
usort($notations, function($a, $b) {
    $countA = count($a);
    $countB = count($b);

    $min = $countA < $countB ? $countA : $countB;

    for($i = 0; $i < $min; ++$i) {
        //Same element
        if($a[$i][0] == $b[$i][0]) {
            //Same amount
            if($a[$i][1] == $b[$i][1]) continue;
            else return $a[$i][1] <=> $b[$i][1];
        } else return $a[$i][0] <=> $b[$i][0];
    }
});

$output = [];

foreach($notations as $notation) {
    $output[] = implode('', array_map(function($element) {
        return $element[0] . (($element[1] > 1) ? $element[1] : '');
    }, $notation));
}

echo implode(PHP_EOL, array_unique($output)) . PHP_EOL;
