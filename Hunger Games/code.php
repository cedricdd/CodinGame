<?php

fscanf(STDIN, "%d", $tributes);
for ($i = 0; $i < $tributes; $i++) {
    $players[trim(fgets(STDIN))] = [[], ""];
}

fscanf(STDIN, "%d", $turns);
for ($i = 0; $i < $turns; $i++) {
    preg_match("/([a-zA-Z]+) killed (.*)/", trim(fgets(STDIN)), $matches);

    [, $killer, $killed] = $matches;

    foreach(explode(", ", $killed) as $victim) {
        $players[$victim][1] = $killer; //Set the killer of the player
        array_push($players[$killer][0], $victim); //Add the player to the list of victims
    }
}

ksort($players); //Players needs to be displayed alphabetically

foreach($players as $name => [$killed, $killer]) {
    sort($killed); //Victims needs to be displayed alphabetically

    $answer[] = "Name: $name" . PHP_EOL . "Killed: " . (implode(", ", $killed) ?: "None") . PHP_EOL . "Killer: " . ($killer ?: "Winner") . PHP_EOL;
}

echo implode(PHP_EOL, $answer);
