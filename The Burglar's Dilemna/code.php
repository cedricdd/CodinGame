<?php
fscanf(STDIN, "%d", $N);
fscanf(STDIN, "%d", $C);
for ($i = 0; $i < $N; $i++) {
    $numbers[] = explode(" ", stream_get_line(STDIN, 1024 + 1, "\n"));
}
for ($i = 0; $i < $N; $i++) {
    $clicks[] = explode(" ", stream_get_line(STDIN, 1024 + 1, "\n"));
}

if($N == 1) exit("FLEE"); //Impossible to find a solution with only one line

$p = [
    'CLICK' => ['CLACK' => 'CLUCK', 'CLUCK' => 'CLACK'],
    'CLACK' => ['CLICK' => 'CLUCK', 'CLUCK' => 'CLICK'],
    'CLUCK' => ['CLACK' => 'CLICK', 'CLICK' => 'CLACK'],
];
$solutions = [];

foreach($p as $correct => $p2) {

    $code = array_fill(0, $C, range(0, 9)); //The code to find

    //Get all the values that are correct with the sound we are testing
    foreach($clicks as $y => $attempts) {
        foreach($attempts as $x => $sound) {
            if($sound == $correct) {
                //Two values are should be identical are not matching, the sound can't be the correct one
                if(count($code[$x]) == 1 && reset($code[$x]) != $numbers[$y][$x]) continue 3;
                //This is the value of the x position
                else $code[$x] = [$numbers[$y][$x]];
            }
        }
    }

    $codeBackup = $code; //Save the code with all the correct values

    foreach($p2 as $adjacent => $incorrect) {

        $code = $codeBackup;

        //We check all the adjacent & incorrect sounds
        foreach($clicks as $y => $attempts) {
            foreach($attempts as $x => $sound) {

                //This number should be incorrect
                if($sound == $incorrect) {

                    //The previous and next also needs to be checked, if they were the correct number the sound should have been adjacent
                    for($i = -1; $i <= 1; ++$i) {
                        $number = ($numbers[$y][$x] + $i + 10) % 10;

                        //We only have 1 number for this position, make sure there's no conflict
                        if(count($code[$x]) == 1) {
                            if(reset($code[$x]) == $number) continue 4;
                        } //Remove the number we know are not good
                        else unset($code[$x][$number]);
                    }

                }

                //This number should be adjacent
                if($sound == $adjacent) {
                    $left = ($numbers[$y][$x] - 1 + 10) % 10;
                    $right = ($numbers[$y][$x] + 1 + 10) % 10;
                 
                    //We only have 1 number for this position, make sure there's no conflict
                    if(count($code[$x]) == 1) {
                        if(reset($code[$x]) != $left && reset($code[$x]) != $right) continue 3;
                    }//Still multiple numbers are possible for this position 
                    else {
                        //None of the adjacents are still possible => conflict
                        if(!isset($code[$x][$left]) && !isset($code[$x][$right])) continue 3;

                        //Remove all the numbers that are not adjacents
                        foreach($code[$x] as $key => $value) {
                            if($value != $left && $value != $right) unset($code[$x][$key]);
                        }
                    }
                }
            }
        }

        //We checked all the sounds, no conflict has been detected, check if we have an unique solution
        $indexSolution = [];

        for($i = 0; $i < $C; ++$i) {
            //There are no conflict but we still have more than 1 number for a position
            if(count($code[$i]) > 1) exit("FLEE");

            $indexSolution[] = array_pop($code[$i]);
        }

        $solutions[implode(" ", $indexSolution)] = 1; //We can find the same solutions with different sound meaning, don't count them as different solutions
    }
}

if(count($solutions) != 1) echo "FLEE";
else echo array_key_first($solutions);
?>
