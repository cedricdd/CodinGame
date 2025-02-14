<?php

const ALPHABET = ['a' => 2,'b' => 4,'c' => 8,'d' => 16,'e' => 32,'f' => 64,'g' => 128,'h' => 256,'i' => 512,'j' => 1024,'k' => 2048,'l' => 4096,'m' => 8192,'n' => 16384,'o' => 32768,'p' => 65536,'q' => 131072,'r' => 262144,'s' => 524288,'t' => 1048576,'u' => 2097152,'v' => 4194304,'w' => 8388608,'x' => 16777216,'y' => 33554432,'z' => 67108864];

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

error_log(var_export($groups, 1));

foreach($groups as $indexGroup => $group) {
    $count = count($group);
    $outside = 0;

    foreach($group as $letter => $filler) $outside |= ALPHABET[$letter];

    if($count == 5) {
        $inside = (2 ** 27) - 1;

        foreach($group as $letter => $filler) $inside &= ~ALPHABET[$letter];
    }
    else {
        $inside = 0;

        foreach($groups as $indexGroup2 => $group2) {
            if($indexGroup == $indexGroup2) continue;
    
            if($count + count($group2) > 5) {
                foreach($group2 as $letter => $filler) $inside |= ALPHABET[$letter];
            }
        }
    }

    foreach($group as $letter => $filler) $rows[$letter] = [$inside, $outside];
}

error_log(count($rows));
error_log(var_export($rows, 1));

for($i = ($size & 1 ? 0 : 1); $i < $size; $i += 2) {
    $c1 = $plainText1[$i];
    $c2 = $cipherText1[($size >> 1) + intval($i / 2)];

    if($c1 == $c2) continue;

    // error_log("$c1 $c2");

    $cols2[$c1][$c2] = 1;
    $cols2[$c2][$c1] = 1;
}

//We merge the info, if we know that a & b are on the same col and b & c are ont he same col then a & c also are on the same col
while($cols2) {
    $group = [array_key_first($cols2)];

    foreach($group as &$current) {
        foreach($cols2[$current] as $letter => $filler) {
            //We don't already have this letter in the group
            if(array_search($letter, $group) === false) $group[] = $letter;
        }

        unset($cols2[$current]);
    }

    $group = array_flip($group);

    //We save the info, we don't need the info that a letter is on the col as itself
    foreach($group as $letter => $filler) {
        unset($group[$letter]);

        $cols[$letter] = $group;

        $group[$letter] = 1;
    }
}

// error_log(var_export($cols, 1));

error_log(microtime(1) - $start);
