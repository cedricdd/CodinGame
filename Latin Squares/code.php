<?php

function setValue(array &$emptyCellsByRow, array &$emptyCellsByCol, array &$missingByRow, array &$missingByCol, array &$results, int $x, int $y, string $c) {
    $results[] = [$x, $y, $c];

    unset($emptyCellsByRow[$y][$x]);
    unset($emptyCellsByCol[$x][$y]);

    unset($missingByRow[$y][$c]);
    unset($missingByCol[$x][$c]);
}

$emptyCellsByRow = [];
$emptyCellsByCol = [];
$results = [];
$missingByRow = [];
$missingByCol = [];
$missing = 0;

for ($y = 0; $y < 4; $y++) {
    foreach(str_split(trim(fgets(STDIN))) as $x => $c) {
        $characters[$c] = true;
        $grid[$y][$x] = $c;

        //Empty cell
        if($c == '.') {
            $emptyCellsByCol[$x][$y] = true;
            $emptyCellsByRow[$y][$x] = true;
            $missing++;
        } //Filled cell
        else {
            $missingByCol[$x][$c] = true;
            $missingByRow[$y][$c] = true;
        }
    }
}

unset($characters['.']);

if(count($characters) != 4) die("Invalid"); //Too many or not enough characters, invalid grid

//All the characters missing for each rows
$missingByRow = array_map(function($row) use($characters) {
    return array_diff_key($characters, $row);
}, $missingByRow);

//All the characters missing for each cols
$missingByCol = array_map(function($col) use($characters) {
    return array_diff_key($characters, $col);
}, $missingByCol);

while($missing) {
    //Check if one of the character missing in the row can only be placed in single position
    foreach($missingByRow as $y => $list) {
        foreach($list as $character => $_) {
            $found = null;

            foreach($emptyCellsByRow[$y] as $x => $_) {
                if(!isset($missingByCol[$x][$character])) continue; //Conflict, this character is already in the col

                if($found !== null) continue 2; //Multiple positions possible

                $found = $x;
            }

            if($found === null) die("Invalid"); //No position possible

            setValue($emptyCellsByRow, $emptyCellsByCol, $missingByRow, $missingByCol, $results, $found, $y, $character);

            $missing--;
        }
    }

    //Check if one of the character missing in the col can only be placed in single position
    foreach($missingByCol as $x => $list) {
        foreach($list as $character => $_) {
            $found = null;

            foreach($emptyCellsByCol[$x] as $y => $_) {
                if(!isset($missingByRow[$y][$character])) continue; //Conflict, this character is already in the row

                if($found !== null) continue 2; //Multiple positions possible

                $found = $y;
            }

            if($found === null) die("Invalid"); //No position possible

            setValue($emptyCellsByRow, $emptyCellsByCol, $missingByRow, $missingByCol, $results, $x, $found, $character);

            $missing--;
        }
    }
}

//Order top to bottom, left to right
usort($results, function($a, $b) {
    if($a[1] == $b[1]) return $a[0] <=> $b[0];
    else return $a[1] <=> $b[1];
});

echo implode(" ", array_column($results, 2)) . PHP_EOL;
