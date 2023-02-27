<?php

function createTeams(array $players, int $size, array $team = []) {
    global $teams;

    //We have enough players, the team is full
    if(count($team) == $size) {
        $teams[] = $team;
        return;
    }
    //Not enough players left to make more teams
    elseif(count($players) + count($team) < $size) return;

    createTeams(array_slice($players, 1, null, true), $size, $team); //We don't use the player
    createTeams(array_slice($players, 1, null, true), $size, $team + array_slice($players, 0, 1, true)); //We use the player
}

function createGroupTeams(array $teams, int $size, array $group = []) {

    global $answer;

    //We have enough teams in the group
    if(count($group) == $size) {
        //Create the team names
        $group = array_map(function($team) { return implode("", $team); }, $group);

        //Team names are in alphabetical order
        sort($group);
        
        $answer[] = implode(",", $group);
        return;
    } 
    //Not enough teams left to make more groups
    elseif(count($group) + count($teams) < $size) return;

    //The next team to work on
    $team = array_pop($teams);

    createGroupTeams($teams, $size, $group); //We skip this team

    //To be able to add the team to the group we need make sure no player is in several teams
    foreach($group as $existingTeam) {
        if(count(array_intersect_key($existingTeam, $team))) {
            return;
        }
    }
    
    //We can add the team to the group (no common players)
    array_push($group, $team);
    createGroupTeams($teams, $size, $group);
}

fscanf(STDIN, "%d", $n);
fscanf(STDIN, "%d", $k);
fscanf(STDIN, "%d", $m);
for ($i = 0; $i < $m; $i++) {
    $names[] = trim(fgets(STDIN))[0]; //We only care about the first letter
}

sort($names); //We start by sorting the letters so when we create the teams the players are already sorted in them

createTeams($names, $k);
createGroupTeams($teams, $n);

sort($answer); //We want the groups of teams in alphabetical order

echo implode("\n", $answer) . PHP_EOL;
