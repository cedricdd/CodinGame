<?php

//We add a layer around the board:
//-Takes care of move position starting at index 1
//-Takes care of extra checks that would be needed to see if we are out of the board when moving in each directions
$grid = array_fill(0, 10, str_repeat("-", 10));
$counts = ['B' => 0, 'W' => 0, '-' => 0];

for ($y = 1; $y <= 8; ++$y) {
    foreach(str_split(stream_get_line(STDIN, 8 + 1, "\n")) as $x => $c) {
        ++$counts[$c];
        $grid[$y][$x + 1] = $c;
    }
}
fscanf(STDIN, "%s %s", $colour, $move);

$flipped = 0;
$opposite = ($colour == "W") ? "B" : "W";
$x = ord($move[0]) - 96;
$y = $move[1];

if($grid[$y][$x] != "-") exit("NOPE"); //Cell is already filled not allowed

//We check the 8 directions
foreach([[0, -1], [-1, -1], [-1, 0], [-1, 1], [0, 1], [1, 1], [1, 0], [1, -1]] as $move) {

    $xm = $x;
    $ym = $y;
    $count = 0;

    //Until we reach a cell that's not the other player color
    while(true) {
        $xm += $move[0];
        $ym += $move[1];

        if($grid[$ym][$xm] != $opposite) {
            if($grid[$ym][$xm] == $colour) $flipped += $count; //Sandwich 
            break;
        }

        ++$count;
    } 
}

//Nothing was flipped
if(!$flipped) echo "NULL\n";
//Update the counts and show them
else {
    $counts[$colour] += $flipped + 1; //Don't forget the one we place
    $counts[$opposite] -= $flipped;
        
    echo $counts['W'] . " " . $counts['B'] . "\n";
}
?>
