<?php

$json = "";

fscanf(STDIN, "%d", $N);

for ($i = 0; $i < $N; $i++) {
    $json .= trim(fgets(STDIN));
}

$info = json_decode($json, true);

foreach($info['monster']['rolls'] as ['roll' => $n, 'part' => $part]) {
    $rolls[$n] = $part;
}

foreach($info['monster']['requirements'] as $req) {
    $requirements[$req['part']] = [$req['qty'], $req['requires'] ?? []];
}

foreach($info['play']['players'] as $name) {
    $players[] = ['name' => $name, 'requirements' => $requirements];
}

$playerCount = count($players);
$winners = [];

foreach($info['play']['game'] as $round => $results) {
    for($i = 0; $i < $playerCount; ++$i) {
        $part = $rolls[$results[$i]];

        //If we need more of this part
        if($players[$i]['requirements'][$part][0]) {
            //Check all requirements to draw this part
            foreach($players[$i]['requirements'][$part][1] as $partRequiered) {
                //We can't draw this part yet
                if($players[$i]['requirements'][$partRequiered][0]) continue 2;
            }

            $players[$i]['requirements'][$part][0]--; //We have drawn the part

            //If we have drawn everything we have won
            if(array_sum(array_column($players[$i]['requirements'], 0)) == 0) {
                $winners[] = $players[$i]['name'];
            }
        }
    }

    //If we have any winner, the age is over
    if(count($winners)) {
        foreach($winners as $winner) echo "$winner wins in round " . ($round + 1) . "." . PHP_EOL;
        break;
    }
}
