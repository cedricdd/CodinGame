<?php

$edgesToFind = ["LF" => 1, "FR" => 1, "RB" => 1, "BL" => 1, "UF" => 1, "FD" => 1, "DB" => 1, "BU" => 1, "UL" => 1, "LD" => 1, "DR" => 1, "RU" => 1];
$cornersToFind = ["UFL", "UFR", "DFR", "DFL", "UBR", "UBL", "DBL", "DBR"];

for ($i = 0; $i < 11; $i++) {
    $line = rtrim(fgets(STDIN));

    if(!empty($line)) $pattern[] = $line;
}

//Check the 6 centers
$centers = [$pattern[1][5], $pattern[4][1], $pattern[4][5], $pattern[4][9], $pattern[4][13], $pattern[7][5]];

//If we don't have 6 unique centers we can't re-assemble
if(count(array_unique($centers)) != 6) exit("UNSOLVABLE");

//Get all the edges
$edges[] = [$pattern[4][0], $pattern[4][14]];
$edges[] = [$pattern[4][2], $pattern[4][4]];
$edges[] = [$pattern[4][6], $pattern[4][8]];
$edges[] = [$pattern[4][10], $pattern[4][12]];
$edges[] = [$pattern[0][5], $pattern[3][13]];
$edges[] = [$pattern[2][5], $pattern[3][5]];
$edges[] = [$pattern[5][5], $pattern[6][5]];
$edges[] = [$pattern[8][5], $pattern[5][13]];
$edges[] = [$pattern[1][4], $pattern[3][1]];
$edges[] = [$pattern[5][1], $pattern[7][4]];
$edges[] = [$pattern[7][6], $pattern[5][9]];
$edges[] = [$pattern[3][9], $pattern[1][6]];

//Check each edges if we still need one with these stickers
foreach($edges as [$a, $b]) {
    if(isset($edgesToFind[$a . $b])) {
        unset($edgesToFind[$a . $b]);
        continue;
    }
    if(isset($edgesToFind[$b . $a])) {
        unset($edgesToFind[$b . $a]);
        continue;
    }

    //We don't need this edge, impossible to re-assemble
    exit("UNSOLVABLE");
}

//Get all the corners, the order is important
$corners[] = [$pattern[2][4], $pattern[3][4], $pattern[3][2]]; //UFL 
$corners[] = [$pattern[2][6], $pattern[3][6], $pattern[3][8]]; //UFR
$corners[] = [$pattern[6][6], $pattern[5][6], $pattern[5][8]]; //DFR
$corners[] = [$pattern[6][4], $pattern[5][4], $pattern[5][2]]; //DFL
$corners[] = [$pattern[0][6], $pattern[3][12], $pattern[3][10]]; //UBR
$corners[] = [$pattern[0][4], $pattern[3][14], $pattern[3][0]]; //UBL
$corners[] = [$pattern[8][4], $pattern[5][14], $pattern[5][0]]; //DBL
$corners[] = [$pattern[8][6], $pattern[5][12], $pattern[5][10]]; //DBR

//Check if we have the 8 corners we need
foreach($cornersToFind as $i => $string) {

    //Check all the corners we haven't used yet
    foreach($corners as $j => [$a, $b, $c]) {
        if(($i & 1) == ($j & 1)) {
            if($a . $b . $c == $string || $c . $a . $b == $string || $b . $c . $a == $string) {
                unset($corners[$j]);
                continue 2;
            }
        } else {
            if($a . $c . $b == $string || $c . $b . $a == $string || $b . $a . $c == $string) {
                unset($corners[$j]);
                continue 2;
            }
        }
    }

    //We can't find the corner we need, impossible to re-assemble
    exit("UNSOLVABLE");
}

echo "SOLVABLE" . PHP_EOL;
