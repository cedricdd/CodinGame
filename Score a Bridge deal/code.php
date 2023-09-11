<?php

fscanf(STDIN, "%d", $nbTests);
for ($i = 0; $i < $nbTests; $i++) {
    $infos = explode(" ", trim(fgets(STDIN)));

    $points = 0;

    if($infos[1] != "Pass") {
        preg_match("/([1-7])(C|D|H|S|NT)(XX|X|)/", $infos[1], $matches);
        [, $contract, $trump, $doubled] = $matches;

        $difference = $infos[2] - 6 - $contract;

        //Contract was won
        if($difference >= 0) {
            if($trump == "C" || $trump == "D") $points += 20 * $contract;
            elseif($trump == "H" || $trump == "S") $points += 30 * $contract;
            else $points += 40 + (30 * ($contract - 1));

            if($doubled == "X") $points *= 2;
            elseif($doubled == "XX") $points *= 4;

            if($points >= 100) $points += ($infos[0] == "V") ? 500 : 300;
            else $points += 50;

            if($contract == 6) $points += ($infos[0] == "V") ? 750 : 500;
            elseif($contract == 7) $points += ($infos[0] == "V") ? 1500 : 1000;

            if($difference > 0) {
                if($doubled == "X") $points += $difference * (($infos[0] == "V") ? 200 : 100);
                elseif($doubled == "XX") $points += $difference * (($infos[0] == "V") ? 400 : 200);
                else $points += $difference * (($trump == "C" || $trump == "D") ? 20 : 30);
            }

            if($doubled == "X") $points += 50;
            elseif($doubled == "XX") $points += 100;
        } //Contract was lost
        else {
            if($doubled == "X" || $doubled == "XX") {
                if($infos[0] == "V") {
                    $points = -200;

                    $points += ($difference + 1) * 300;
                } else {
                    $points = -100;

                    if($difference < -1) $points += max($difference + 1, -2) * 200;
                    if($difference < -3) $points += ($difference + 3) * 300;
                }

                if($doubled == "XX") $points *= 2;
            }
            else $points = $difference * (($infos[0] == "V") ? 100 : 50);
        }
    }

    echo $points . PHP_EOL;
}
