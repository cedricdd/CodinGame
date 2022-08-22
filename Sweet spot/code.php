<?php

function explodeBomb(array &$grid, int $x, int $y, string $type) {
    global $N, $detonated;

    if(isset($detonated[$y][$x])) return; //This bomb has alraedy detonated
    $detonated[$y][$x] = 1;

    //Apply the damage based on the bomb type
    for($y2 = max(0, $y - 3); $y2 < min($N, $y + 4); ++$y2) {
        for($x2 = max(0, $x - 3); $x2 < min($N, $x + 4); ++$x2) {
            $damage = 4 - max(abs($x - $x2), abs($y - $y2));

            if($type == "H") $damage = 5;
            elseif($type == "B" && !($y == $y2 || $x == $x2)) $damage = 0;

            setDamage($grid, $x2, $y2, $damage);
        }
    }
}

function setDamage(array &$grid, int $x, int $y, int $value) {
    if(!is_numeric($grid[$y][$x])) {
        //A type B bomb has been triggered
        if($grid[$y][$x] == "B" && $value != 0) explodeBomb($grid, $x, $y, "B");
        return;
    }

    $grid[$y][$x] = max($value, $grid[$y][$x]); //Use the impact with the highest value
}

$detonated = [];
$bombs = [];

fscanf(STDIN, "%d", $N);
for ($y = 0; $y < $N; ++$y) {
    $line = stream_get_line(STDIN, 30 + 1, "\n");

    foreach(str_split($line) as $x => $c) {
        if(!is_numeric($c) && $c != "B") $bombs[] = [$c, $x, $y];
        $grid[$y][$x] = $c;
    }
}

//Explode all the A & H bombs
foreach($bombs as [$type, $x, $y]) explodeBomb($grid, $x, $y, $type);

echo implode("\n", array_map("implode", $grid)) . PHP_EOL;
?>
