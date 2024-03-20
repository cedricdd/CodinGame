<?php

function getWordHorizontal(int $x, int $y): array {
    global $board, $previousBoard, $emptyBoard, $points;

    $score = 0;
    $word = "";
    $factor = 1;
    $newTiles = 0;
    
    //To the right
    $i = 0;
    while(($board[$y][$x + $i] ?? '.') != '.') {
        $word .= $board[$y][$x + $i];
        $score += $points[$board[$y][$x + $i]];
        $history[$y][$x + $i] = 1;

        if($previousBoard[$y][$x + $i] == '.') {
            ++$newTiles;

            switch($emptyBoard[$y][$x + $i]) {
                case 'l': $score += $points[$board[$y][$x + $i]]; break;
                case 'L': $score += $points[$board[$y][$x + $i]] * 2; break;
                case 'w': $factor *= 2; break;
                case 'W': $factor *= 3; break;
            }
        }

        ++$i;
    };

    return [$word, $score * $factor, $newTiles];
}

function getWordVertical(int $x, int $y): array {
    global $board, $previousBoard, $emptyBoard, $points;

    $score = 0;
    $word = "";
    $factor = 1;
    $newTiles = 0;
    
    //To the bottom
    $i = 0;
    while(($board[$y + $i][$x] ?? '.') != '.') {
        $word .= $board[$y + $i][$x];
        $score += $points[$board[$y + $i][$x]];
        $history[$y + $i][$x] = 1;

        if($previousBoard[$y + $i][$x] == '.') {
            ++$newTiles;

            switch($emptyBoard[$y + $i][$x]) {
                case 'l': $score += $points[$board[$y + $i][$x]]; break;
                case 'L': $score += $points[$board[$y + $i][$x]] * 2; break;
                case 'w': $factor *= 2; break;
                case 'W': $factor *= 3; break;
            }
        }

        ++$i;
    };

    return [$word, $score * $factor, $newTiles];
}

// $nbTiles: Number of tiles in the tile set
fscanf(STDIN, "%d", $nbTiles);
for ($i = 0; $i < $nbTiles; $i++) {
    fscanf(STDIN, "%s %d", $character, $score);
    $points[$character] = $score;
}

fscanf(STDIN, "%d %d", $width, $height);
$tilesAdded = 0;

for ($i = 0; $i < $height; $i++) {
    $emptyBoard[] = trim(fgets(STDIN));// Empty board with special cells
}
for ($i = 0; $i < $height; $i++) {
    $previousBoard[] = trim(fgets(STDIN));// Words already played
}
for ($y = 0; $y < $height; $y++) {
    $board[] = trim(fgets(STDIN));

    for($x = 0; $x < $width; ++$x) 
        if($previousBoard[$y][$x] != $board[$y][$x]) 
            ++$tilesAdded;
}

$words = [];

for($y = 0; $y < $height; ++$y) {
    for($x = 0; $x < $width; ++$x) {
        if($board[$y][$x] != '.') {
            //It's the start of an horizontal word
            if(($board[$y][$x - 1] ?? '.') == '.' && ($board[$y][$x + 1] ?? '.') != '.') {
                [$word, $score, $newTiles] = getWordHorizontal($x, $y);

                if($newTiles) $words[$word] = $score;
            }
            
            //It's the start of a vertival word
            if(($board[$y - 1][$x] ?? '.') == '.' && ($board[$y + 1][$x] ?? '.') != '.') {
                [$word, $score, $newTiles] = getWordVertical($x, $y);

                if($newTiles) $words[$word] = $score;
            }
        }
    }
}

ksort($words, SORT_STRING); //Sort in alphabetical order

$bonus = 0;

foreach($words as $word => $score) echo $word . " " . $score . PHP_EOL;
if($tilesAdded >= 7) echo "Bonus 50" . PHP_EOL; //We are getting the bonus
echo "Total " . (array_sum($words) + ($tilesAdded >= 7 ? 50 : 0)) . PHP_EOL;
