<?php

const DIRECTIONS = ['N' => 0, 'NE' => 1, 'E' => 2, 'SE' => 3, 'S' => 4, 'SW' => 5, 'W' => 6, 'NW' => 7];

fscanf(STDIN, "%s", $startDirection);

$direction = DIRECTIONS[$startDirection];

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%s", $turn);

    if($turn == "RIGHT") $direction = ($direction + 1) % 8;
    if($turn == "LEFT")  $direction = ($direction - 1 + 8) % 8;
    if($turn == "BACK")  $direction = ($direction + 4) % 8;
}

echo array_search($direction, DIRECTIONS) . PHP_EOL;
