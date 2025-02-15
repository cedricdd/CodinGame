<?php

const ALL_LETTERS = 134217727;
const ALPHABET = ['a' => 1,'b' => 1,'c' => 1,'d' => 1,'e' => 1,'f' => 1,'g' => 1,'h' => 1,'i' => 1,'k' => 1,'l' => 1,'m' => 1,'n' => 1,'o' => 1,'p' => 1,'q' => 1,'r' => 1,'s' => 1,'t' => 1,'u' => 1,'v' => 1,'w' => 1,'x' => 1,'y' => 1,'z' => 1];
const ALPHABET_VALUES = ['a' => 2,'b' => 4,'c' => 8,'d' => 16,'e' => 32,'f' => 64,'g' => 128,'h' => 256,'i' => 512,'j' => 1024,'k' => 2048,'l' => 4096,'m' => 8192,'n' => 16384,'o' => 32768,'p' => 65536,'q' => 131072,'r' => 262144,'s' => 524288,'t' => 1048576,'u' => 2097152,'v' => 4194304,'w' => 8388608,'x' => 16777216,'y' => 33554432,'z' => 67108864];
const ALPHABET_INV_VALUES = ['a' => 134217725,'b' => 134217723,'c' => 134217719,'d' => 134217711,'e' => 134217695,'f' => 134217663,'g' => 134217599,'h' => 134217471,'i' => 134217215,'j' => 134216703,'k' => 134215679,'l' => 134213631,'m' => 134209535,'n' => 134201343,'o' => 134184959,'p' => 134152191,'q' => 134086655,'r' => 133955583,'s' => 133693439,'t' => 133169151,'u' => 132120575,'v' => 130023423,'w' => 125829119,'x' => 117440511,'y' => 100663295,'z' => 67108863];
const ROWS_INFO = [
    0 => [[1,2,3,4], [5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]],
    1 => [[0,2,3,4], [5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]],
    2 => [[0,1,3,4], [5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]],
    3 => [[0,1,2,4], [5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]],
    4 => [[0,1,2,3], [5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]],
    5 => [[6,7,8,9], [0,1,2,3,4,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]],
    6 => [[5,7,8,9], [0,1,2,3,4,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]],
    7 => [[5,6,8,9], [0,1,2,3,4,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]],
    8 => [[5,6,7,9], [0,1,2,3,4,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]],
    9 => [[5,6,7,8], [0,1,2,3,4,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]],
    10 => [[11,12,13,14], [0,1,2,3,4,5,6,7,8,9,15,16,17,18,19,20,21,22,23,24]],
    11 => [[10,12,13,14], [0,1,2,3,4,5,6,7,8,9,15,16,17,18,19,20,21,22,23,24]],
    12 => [[10,11,13,14], [0,1,2,3,4,5,6,7,8,9,15,16,17,18,19,20,21,22,23,24]],
    13 => [[10,11,12,14], [0,1,2,3,4,5,6,7,8,9,15,16,17,18,19,20,21,22,23,24]],
    14 => [[10,11,12,13], [0,1,2,3,4,5,6,7,8,9,15,16,17,18,19,20,21,22,23,24]],
    15 => [[16,17,18,19], [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,20,21,22,23,24]],
    16 => [[15,17,18,19], [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,20,21,22,23,24]],
    17 => [[15,16,18,19], [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,20,21,22,23,24]],
    18 => [[15,16,17,19], [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,20,21,22,23,24]],
    19 => [[15,16,17,18], [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,20,21,22,23,24]],
    20 => [[21,22,23,24], [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19]],
    21 => [[20,22,23,24], [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19]],
    22 => [[20,21,23,24], [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19]],
    23 => [[20,21,22,24], [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19]],
    24 => [[20,21,22,23], [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19]],
];
const ROWS_INFO2 = [
    0 => [[0,1,2,3,4], [5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]],
    1 => [[5,7,8,9,6], [0,1,2,3,4,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24]],
    2 => [[10,11,12,13,14], [0,1,2,3,4,5,6,7,8,9,15,16,17,18,19,20,21,22,23,24]],
    3 => [[15,16,17,18,19], [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,20,21,22,23,24]],
    4 => [[20,21,22,23,24], [0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19]],
];
const COLS_INFO = [
    0 => [[5,10,15,20], [1,2,3,4,6,7,8,9,11,12,13,14,16,17,18,19,21,22,23,24]],
    1 => [[6,11,16,21], [0,2,3,4,5,7,8,9,10,12,13,14,15,17,18,19,20,22,23,24]],
    2 => [[7,12,17,22], [0,1,3,4,5,6,8,9,10,11,13,14,15,16,18,19,20,21,23,24]],
    3 => [[8,13,18,23], [0,1,2,4,5,6,7,9,10,11,12,14,15,16,17,19,20,21,22,24]],
    4 => [[9,14,19,24], [0,1,2,3,5,6,7,8,10,11,12,13,15,16,17,18,20,21,22,23]],
    5 => [[0,10,15,20], [1,2,3,4,6,7,8,9,11,12,13,14,16,17,18,19,21,22,23,24]],
    6 => [[1,11,16,21], [0,2,3,4,5,7,8,9,10,12,13,14,15,17,18,19,20,22,23,24]],
    7 => [[2,12,17,22], [0,1,3,4,5,6,8,9,10,11,13,14,15,16,18,19,20,21,23,24]],
    8 => [[3,13,18,23], [0,1,2,4,5,6,7,9,10,11,12,14,15,16,17,19,20,21,22,24]],
    9 => [[4,14,19,24], [0,1,2,3,5,6,7,8,10,11,12,13,15,16,17,18,20,21,22,23]],
    10 => [[0,5,15,20], [1,2,3,4,6,7,8,9,11,12,13,14,16,17,18,19,21,22,23,24]],
    11 => [[1,6,16,21], [0,2,3,4,5,7,8,9,10,12,13,14,15,17,18,19,20,22,23,24]],
    12 => [[2,7,17,22], [0,1,3,4,5,6,8,9,10,11,13,14,15,16,18,19,20,21,23,24]],
    13 => [[3,8,18,23], [0,1,2,4,5,6,7,9,10,11,12,14,15,16,17,19,20,21,22,24]],
    14 => [[4,9,19,24], [0,1,2,3,5,6,7,8,10,11,12,13,15,16,17,18,20,21,22,23]],
    15 => [[0,5,10,20], [1,2,3,4,6,7,8,9,11,12,13,14,16,17,18,19,21,22,23,24]],
    16 => [[1,6,11,21], [0,2,3,4,5,7,8,9,10,12,13,14,15,17,18,19,20,22,23,24]],
    17 => [[2,7,12,22], [0,1,3,4,5,6,8,9,10,11,13,14,15,16,18,19,20,21,23,24]],
    18 => [[3,8,13,23], [0,1,2,4,5,6,7,9,10,11,12,14,15,16,17,19,20,21,22,24]],
    19 => [[4,9,14,24], [0,1,2,3,5,6,7,8,10,11,12,13,15,16,17,18,20,21,22,23]],
    20 => [[0,5,10,15], [1,2,3,4,6,7,8,9,11,12,13,14,16,17,18,19,21,22,23,24]],
    21 => [[1,6,11,16], [0,2,3,4,5,7,8,9,10,12,13,14,15,17,18,19,20,22,23,24]],
    22 => [[2,7,12,17], [0,1,3,4,5,6,8,9,10,11,13,14,15,16,18,19,20,21,23,24]],
    23 => [[3,8,13,18], [0,1,2,4,5,6,7,9,10,11,12,14,15,16,17,19,20,21,22,24]],
    24 => [[4,9,14,19], [0,1,2,3,5,6,7,8,10,11,12,13,15,16,17,18,20,21,22,23]],
];
const COLS_INFO2 = [
    0 => [[0,5,10,15,20], [1,2,3,4,6,7,8,9,11,12,13,14,16,17,18,19,21,22,23,24]],
    1 => [[1,6,11,16,21], [0,2,3,4,5,7,8,9,10,12,13,14,15,17,18,19,20,22,23,24]],
    2 => [[2,7,12,17,22], [0,1,3,4,5,6,8,9,10,11,13,14,15,16,18,19,20,21,23,24]],
    3 => [[3,8,13,18,23], [0,1,2,4,5,6,7,9,10,11,12,14,15,16,17,19,20,21,22,24]],
    4 => [[4,9,14,19,24], [0,1,2,3,5,6,7,8,10,11,12,13,15,16,17,18,20,21,22,23]],
];

function solve(array $secret, array $letters, $test = false) {
    global $relations, $rows, $cols;

    $minCount = PHP_INT_MAX;
    $minLetter = null;
    $minPositions = [];

    //For all the letters we still need to place, use the one with the less possibilities
    foreach($letters as $letter => $filler) {
        $positions = [];
        
        foreach($secret as $index => $mask) {
            if($mask & ALPHABET_VALUES[$letter]) $positions[] = $index;
        }

        if(($count = count($positions)) < $minCount) {
            $minCount = $count;
            $minLetter = $letter;
            $minPositions = $positions;
        }
    }

    if($test == false) $minLetter = 'b';

    error_log("min is $minCount - $minLetter");
    // error_log(var_export($minPositions, 1));

    unset($letters[$minLetter]);

    foreach($minPositions as $position) {
        error_log("setting $minLetter at $position");

        $secret2 = $secret;
        $secret2[$position] = ALPHABET_VALUES[$minLetter]; //We set the letter at this position

        if(isset($rows[$minLetter])) {
            error_log("rows");
            error_log(var_export($rows[$minLetter]));

            foreach(ROWS_INFO[$position][0] as $position2) $secret2[$position2] &= $rows[$minLetter][0];
            foreach(ROWS_INFO[$position][1] as $position2) $secret2[$position2] &= $rows[$minLetter][1];
        }

        if(isset($cols[$minLetter])) {
            error_log("cols");
            error_log(var_export($cols[$minLetter]));

            foreach(COLS_INFO[$position][0] as $position2) $secret2[$position2] &= $cols[$minLetter][0];
            foreach(COLS_INFO[$position][1] as $position2) $secret2[$position2] &= $cols[$minLetter][1];
        }

        if(isset($relations[$minLetter])) {
            error_log("relations");
            error_log(var_export($relations[$minLetter]));

            $x = $position % 5;
            $y = intdiv($position, 5);

            foreach($relations[$minLetter] as $letter2 => $relation) {
                if($relation == 'x') {

                }
            }
        }

        error_log(var_export($secret2, 1));

        solve($secret2, $letters, true);

        if($minLetter != 'b') exit();
    }
}

$start = microtime(1);

$plainText1 = strtolower(stream_get_line(STDIN, 200 + 1, "\n"));
$plainText1 = str_replace(" ", "", $plainText1);
$plainText1 = str_replace("j", "i", $plainText1);

$cipherText1 = strtolower(stream_get_line(STDIN, 200 + 1, "\n"));
$cipherText2 = strtolower(stream_get_line(STDIN, 200 + 1, "\n"));

$size = strlen($cipherText1);

$rows = [];
$cols = [];

for($i = 0; $i < $size; $i += 2) {
    $c1 = $plainText1[$i];
    $c2 = $cipherText1[$i / 2];

    if($c1 == $c2) continue;

    // error_log("$c1 $c2");

    $rows2[$c1][$c2] = 1;
    $rows2[$c2][$c1] = 1;
}

$index = 0;
$groups = [];

//We merge the info, if we know that a & b are on the same col and b & c are ont he same col then a & c also are on the same col
while($rows2) {
    $groups[$index] = [array_key_first($rows2)];

    foreach($groups[$index] as &$current) {
        foreach($rows2[$current] as $letter => $filler) {
            //We don't already have this letter in the group
            if(array_search($letter, $groups[$index]) === false) $groups[$index][] = $letter;
        }

        unset($rows2[$current]);
    }

    $groups[$index] = array_flip($groups[$index]);

    /*
    //We save the info, we don't need the info that a letter is on the col as itself
    foreach($groups[$index] as $letter => $filler) {
        unset($groups[$index][$letter]);

        $rows[$letter] = $groups[$index];

        $groups[$index][$letter] = 1;
    }
    */

    ++$index;
}

// error_log(var_export($groups, 1));

foreach($groups as $indexGroup => $group) {
    $count = count($group);

    $outside = ALL_LETTERS;

    foreach($group as $letter => $filler) $outside &= ALPHABET_INV_VALUES[$letter];

    if($count == 5) {
        $inside = 0;

        foreach($group as $letter => $filler) $inside |= ALPHABET_VALUES[$letter];
    }
    else {
        $inside = ALL_LETTERS;

        foreach($groups as $indexGroup2 => $group2) {
            if($indexGroup == $indexGroup2) continue;
    
            if($count + count($group2) > 5) {
                foreach($group2 as $letter => $filler) $inside &= ALPHABET_INV_VALUES[$letter];
            }
        }
    }

    foreach($group as $letter => $filler) $rows[$letter] = [$inside & ALPHABET_INV_VALUES[$letter], $outside];
}

// error_log(count($rows));
// error_log(var_export($rows, 1));

$middle = $size >> 1;

for($i = ($size & 1 ? 0 : 1); $i < $size; $i += 2) {
    $c1 = $plainText1[$i];
    $c2 = $cipherText1[$middle + intval($i / 2)];

    if($c1 == $c2) continue;

    // error_log("$c1 $c2");

    $cols2[$c1][$c2] = 1;
    $cols2[$c2][$c1] = 1;
}


$index = 0;
$groups = [];

//We merge the info, if we know that a & b are on the same col and b & c are ont he same col then a & c also are on the same col
while($cols2) {
    $groups[$index] = [array_key_first($cols2)];

    foreach($groups[$index] as &$current) {
        foreach($cols2[$current] as $letter => $filler) {
            //We don't already have this letter in the group
            if(array_search($letter, $groups[$index]) === false) $groups[$index][] = $letter;
        }

        unset($cols2[$current]);
    }

    $groups[$index] = array_flip($groups[$index]);

    //We save the info, we don't need the info that a letter is on the col as itself
    foreach($groups[$index] as $letter => $filler) {
        unset($groups[$index][$letter]);

        $cols[$letter] = $groups[$index];

        $groups[$index][$letter] = 1;
    }

    ++$index;
}

// error_log(var_export($groups, 1));

foreach($groups as $indexGroup => $group) {
    $count = count($group);

    $outside = ALL_LETTERS;

    foreach($group as $letter => $filler) $outside &= ALPHABET_INV_VALUES[$letter];

    if($count == 5) {
        $inside = 0;

        foreach($group as $letter => $filler) $inside |= ALPHABET_VALUES[$letter];
    }
    else {
        $inside = ALL_LETTERS;

        foreach($groups as $indexGroup2 => $group2) {
            if($indexGroup == $indexGroup2) continue;
    
            if($count + count($group2) > 5) {
                foreach($group2 as $letter => $filler) $inside &= ALPHABET_INV_VALUES[$letter];
            }
        }
    }

    foreach($group as $letter => $filler) $cols[$letter] = [$inside & ALPHABET_INV_VALUES[$letter], $outside];
}

// error_log(count($cols));
// error_log(var_export($cols, 1));


for($i = 1; $i < $size; $i += 2) {
    $c1 = $plainText1[$i];
    $c2 = $cipherText1[intdiv($i, 2)];

    if($c1 == $c2) continue;

    // error_log("$c1 $c2");

    $relations[$c1][$c2] = 'y';
    $relations[$c2][$c1] = 'x';
}

$middle = ceil($size / 2);

for($i = ($size & 1 ? 1 : 0); $i < $size; $i += 2) {
    $c1 = $plainText1[$i];
    $c2 = $cipherText1[intval($middle + intval($i / 2))];

    if($c1 == $c2) continue;

    // error_log("$c1 $c2");

    $relations[$c1][$c2] = 'x';
    $relations[$c2][$c1] = 'y';
}


// error_log(var_export($relations, 1));

solve(array_fill(0, 25, ALL_LETTERS), ALPHABET);

error_log(microtime(1) - $start);
