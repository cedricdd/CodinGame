<?php
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    [$from, $to] = explode(" -> ", trim(fgets(STDIN)));

    $swap[$from] = $to;
}
fscanf(STDIN, "%d", $length);

function removeCharacters(array $characters, int $count): array {
    return array_slice($characters, 0, $count * -1);
}

function shuffleCharacters(array $characters): array {

    if(count($characters) <= 1) return $characters;

    $shuffled = [];
    $characters = array_values($characters); //Make sure indexes are set properly

    array_walk($characters, function($v, $k) use (&$shuffled) { 
        $shuffled[($k % 2)][] = $v; 
    });

    return array_merge($shuffled[0], $shuffled[1]);
}

$decoded = "";

foreach(explode("+", rtrim(fgets(STDIN))) as $input) {

    if($input[0] == "#") {
        $characters = removeCharacters($characters, $input[1]);
        continue;
    }
    if($input[0] == "%") {
        $characters = shuffleCharacters($characters);
        continue;
    }

    if(isset($swap[$input])) $character = $swap[$input];
    else $character = $input;

    if($character == "*") $decoded .= array_pop($characters);
    else $characters[] = $character;
}

$decoded = explode(" ", $decoded);

$start = 0;
for($i = 1; $i < count($decoded); ++$i) {
    //We can't print more than 75 characters per lin
    if(strlen(implode(" ", array_slice($decoded, $start, $i - $start + 1))) > 75) {
        echo implode(" ", array_slice($decoded, $start, $i - $start)) . PHP_EOL;
        $start = $i;
        
    } 
    //We reached the end, print what's left
    if($i == count($decoded) - 1) {
        echo implode(" ", array_slice($decoded, $start)) . PHP_EOL;
    }
}
