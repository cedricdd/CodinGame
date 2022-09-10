<?php

for ($i = 0; $i < 7; $i++) {
    $depots[] = array_map("ord", explode(" ", trim(fgets(STDIN))));
}

function solve(array $solutions, array $depots) {

    $step = count($solutions);

    //We have successfully placed all the depots
    if(count($depots) == 0) {
        ksort($solutions);
 
        echo implode(" ", array_map(function($info) {
            return $info["index"] . chr($info["depot"][0]);
        }, $solutions));
    }

    foreach($depots as $index => $depot) {
        for($i = 0; $i < 6; ++$i) {
            //Adding depot at the center
            if($step == 0) {
                if($depot[$i] == min($depot)) {
                    $solutions[3] = ["index" => $index, "depot" => array_merge(array_slice($depot, $i), array_slice($depot, 0, $i))];
                } else continue;
            }
            //Adding depot at top left of center
            elseif($step == 1) {
                if($depot[$i] == $solutions[3]["depot"][4]) {
                    $solutions[0] = ["index" => $index, "depot" => array_merge(array_slice($depot, ($i - 1 + 6) % 6), array_slice($depot, 0, ($i - 1 + 6) % 6))];
                } else continue;
            } //Adding depot at top right of center
            elseif($step == 2) {
                if($depot[$i] == $solutions[3]["depot"][5] && $depot[($i + 1) % 6] == $solutions[0]["depot"][0]) {
                    $solutions[1] = ["index" => $index, "depot" => array_merge(array_slice($depot, ($i - 2 + 6) % 6), array_slice($depot, 0, ($i - 2 + 6) % 6))];
                } else continue;
            } //Adding depot at left of center
            elseif($step == 3) {
                if($depot[$i] == $solutions[0]["depot"][2] && $depot[($i + 1) % 6] == $solutions[3]["depot"][3]) {
                    $solutions[2] = ["index" => $index, "depot" => array_merge(array_slice($depot, ($i - 5 + 6) % 6), array_slice($depot, 0, ($i - 5 + 6) % 6))];
                } else continue;
            } //Adding depot at right of center
            elseif($step == 4) {
                if($depot[$i] == $solutions[3]["depot"][0] && $depot[($i + 1) % 6] == $solutions[1]["depot"][1]) {
                    $solutions[4] = ["index" => $index, "depot" => array_merge(array_slice($depot, ($i - 3 + 6) % 6), array_slice($depot, 0, ($i - 3 + 6) % 6))];
                } else continue;
            } //Adding depot at bottom left of center
            elseif($step == 5) {
                if($depot[$i] == $solutions[2]["depot"][1] && $depot[($i + 1) % 6] == $solutions[3]["depot"][2]) {
                    $solutions[5] = ["index" => $index, "depot" => array_merge(array_slice($depot, ($i - 4 + 6) % 6), array_slice($depot, 0, ($i - 4 + 6) % 6))];
                } else continue;
            } //Adding depot at bottom right of center
            elseif($step == 6) {
                if($depot[$i] == $solutions[5]["depot"][0] && $depot[($i + 1) % 6] == $solutions[3]["depot"][1] && $depot[($i + 2) % 6] == $solutions[4]["depot"][2]) {
                    $solutions[6] = ["index" => $index, "depot" => array_merge(array_slice($depot, ($i - 3 + 6) % 6), array_slice($depot, 0, ($i - 3 + 6) % 6))];
                } else continue;
            }

            $updatedDepots = $depots;
            unset($updatedDepots[$index]);
            solve($solutions, $updatedDepots);
        }
    }

}

solve([], $depots);
?>
