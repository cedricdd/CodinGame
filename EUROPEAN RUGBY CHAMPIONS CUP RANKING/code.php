<?php

function getScores(array &$teams, array $matches, string $extra = "") {

    foreach($matches as $match) {
        [$teamA, $pointsA, $triesA, $teamB, $pointsB, $triesB] = $match;

        //Team A won
        if($pointsA > $pointsB) {
            $teams[$teamA]["rankingPoints" . $extra] += 4;
    
            $difference = $pointsA - $pointsB;
    
            $teams[$teamA]["gamePointDifference" . $extra] += $difference;
            $teams[$teamB]["gamePointDifference" . $extra] -= $difference;
    
            //Bonus point
            if($difference <= 7) $teams[$teamB]["rankingPoints" . $extra]++;
        }
        //Team B won
        elseif($pointsB > $pointsA) {
            $teams[$teamB]["rankingPoints" . $extra] += 4;
    
            $difference = $pointsB - $pointsA;
    
            $teams[$teamA]["gamePointDifference" . $extra] -= $difference;
            $teams[$teamB]["gamePointDifference" . $extra] += $difference;
    
            //Bonus point
            if($difference <= 7) $teams[$teamA]["rankingPoints" . $extra]++;
        }
        //It's a draw
        else {
            $teams[$teamA]["rankingPoints" . $extra] += 2;
            $teams[$teamB]["rankingPoints" . $extra] += 2;
        }
    
        //Bonus point for tries
        if($triesA >= 4) $teams[$teamA]["rankingPoints" . $extra]++;
        if($triesB >= 4) $teams[$teamB]["rankingPoints" . $extra]++;
    }
}

for ($i = 0; $i < 5; $i++) {
    foreach(explode(",", trim(fgets(STDIN))) as $name) {
        $pools[$i][] = $name;
        $teams[$name] = [
            "name" => $name, 
            "pool" => $i, 
            "poolRanking" => 0, 
            "rankingPoints" => 0, 
            "gamePointDifference" => 0, 
            "rankingPointsTie" => 0, 
            "gamePointDifferenceTie" => 0
        ];
    }
}

for ($i = 0; $i < 60; $i++) $matches[] = explode(",", trim(fgets(STDIN)));
getScores($teams, $matches);

//In each pools we group teams by their ranking points
foreach($pools as $list) {
    $rankings = [];

    foreach($list as $team) $rankings[$teams[$team]["rankingPoints"]][] = $team;

    //If there are several teams with the same score we need the tie scores
    foreach($rankings as $score => $tiedTeams) {
        if(count($tiedTeams) == 1) continue;

        //Get only the matches with the tied teams
        $matchesFiltered = array_filter($matches, function($match) use ($tiedTeams) {
            return in_array($match[0], $tiedTeams) && in_array($match[3], $tiedTeams);
        });

        getScores($teams, $matchesFiltered, "Tie");
    }
}

//INTRA-POOL RANKING 
foreach($pools as $list) {
    usort($list, function($a, $b) use ($teams) {
        if($teams[$a]["rankingPoints"] == $teams[$b]["rankingPoints"]) {
            if($teams[$a]["rankingPointsTie"] == $teams[$a]["rankingPointsTie"]) {
                return $teams[$b]["gamePointDifferenceTie"] <=> $teams[$a]["gamePointDifferenceTie"];
            } else return $teams[$b]["rankingPointsTie"] <=> $teams[$a]["rankingPointsTie"];
        }
        else return $teams[$b]["rankingPoints"] <=> $teams[$a]["rankingPoints"];
    });

    //Set the pool ranking for each team
    foreach($list as $rank => $name) $teams[$name]["poolRanking"] = $rank + 1;
}

//INTER-POOL RANKING
usort($teams, function($a, $b) {
    if($a["poolRanking"] == $b["poolRanking"]) {
        if($a["rankingPoints"] == $b["rankingPoints"]) {
            return $b["gamePointDifference"] <=> $a["gamePointDifference"];
        } else return $b["rankingPoints"] <=> $a["rankingPoints"];
    } else return $a["poolRanking"] <=> $b["poolRanking"];
});

echo $teams[0]["name"] . " - " . $teams[7]["name"] . PHP_EOL;
echo $teams[1]["name"] . " - " . $teams[6]["name"] . PHP_EOL;
echo $teams[2]["name"] . " - " . $teams[5]["name"] . PHP_EOL;
echo $teams[3]["name"] . " - " . $teams[4]["name"] . PHP_EOL;
