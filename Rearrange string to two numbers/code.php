<?php

//Check if we can form a valid number
function isValid(array $digits): bool {
    $count = array_sum($digits);

    if($count == 0) return false;
    if($count < 19 && ($count == 1 || $digits[0] != $count)) return true;
    if($digits[0] == 18 && $digits[1] == 1) return true;

    return false;
}

//Form the number based on the digits
function getNumber(array $digits): string {
    $number = "";

    for($i = 0; $i < 10; ++$i) {
        for($j = 0; $j < $digits[$i]; ++$j) {
            if($i != 0 && intval($number) == 0) $number = $i . $number;
            else $number .= $i;
        }
    }

    return $number;
}

$a = array_fill(0, 10, 0);
$b = array_fill(0, 10, 0);
foreach(str_split(trim(fgets(STDIN))) as $digit) $a[$digit]++;

if(array_sum($a) <= 1 || array_sum($a) > 38) exit("-1 -1");

//We can form 1^18, in order to minimize A, B will be 1^18
if($a[0] >= 18 && $a[1] >= 1) {
    $a[1] -= 1;
    $a[0] -= 18;

    if(isValid($a)) {
        [$a, $b] = [getNumber($a), 1000000000000000000];
        echo min($a, $b) . " " . max($a, $b) . PHP_EOL;
    } else echo "-1 -1" . PHP_EOL;
    exit();
}

//Move as much as we can to B, using the biggest digits
$count = 18;

for($i = 9; $i >= 0; $i--) {
    $moved = min($count, $a[$i]);

    $b[$i] += $moved;
    $a[$i] -= $moved;
    $count -= $moved;
}

//We moved as much as possible into B and both number are valid
if(isValid($a) && isValid($b)) echo getNumber($a) . " " . getNumber($b) . PHP_EOL;
else {
    $moveToA = null;
    $moveToB = null;

    //Find the first in A to move to B
    for($i = 0; $i < 10; ++$i) {
        if($a[$i] > 0) {
            $moveToB = $i;
            break;
        }
    }
    //Find the first in B to move to A (if we can move a non 0 we want that)
    for($i = 0; $i < 10; ++$i) {
        if($b[$i] > 0) {
            $moveToA = $i;
            if($i > 0) break;
        }
    }

    if($moveToA !== null) {
        $a[$moveToA]++;
        $b[$moveToA]--;
    }

    if($moveToB !== null) {
        $a[$moveToB]--;
        $b[$moveToB]++;
    }

    if(isValid($a) && isValid($b)) {
        [$a, $b] = [getNumber($a), getNumber($b)];
        echo min($a, $b) . " " . max($a, $b) . PHP_EOL;
    }
    else echo "-1 -1" . PHP_EOL;
    
}
