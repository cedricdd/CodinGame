<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d", $H, $W);
for ($i = 0; $i < $H; $i++) {
    $line = stream_get_line(STDIN, 1024 + 1, "\n");

    //We need the start position
    if(($j = strpos($line, "X")) !== false) {
        $startX = $j;
        $startY = $i;
    }

    $map[] = $line;
}

$maxGold = 0;
$toCheck = [
    [$startY - 1, $startX, 0, [$startY . "-" . $startX]],
    [$startY + 1, $startX, 0, [$startY . "-" . $startX]],
    [$startY, $startX - 1, 0, [$startY . "-" . $startX]],
    [$startY, $startX + 1, 0, [$startY . "-" . $startX]],
];

while(count($toCheck)) {
    list($Y, $X, $amount, $path) = array_pop($toCheck);

    //Already visited this cell
    if(in_array($Y . "-" . $X, $path))  continue;

    //Outside of map
    if($Y < 0 || $X < 0 || $Y >= $H || $X >= $W)  continue;

    //We hit a wall
    if($map[$Y][$X] == "#")  continue;

    //We found some gold
    if($map[$Y][$X] != " ") {
        $amount += $map[$Y][$X];
        if($amount > $maxGold) $maxGold = $amount;
    }

    //We can't visit this cell anymore
    $newPath = array_merge($path, [$Y . "-" . $X]);
    //Check the cells possibly accesible from current position
    array_push($toCheck, [$Y - 1, $X, $amount, $newPath], [$Y + 1, $X, $amount, $newPath], [$Y, $X - 1, $amount, $newPath], [$Y, $X + 1, $amount, $newPath]);
}

echo($maxGold . "\n");
?>
