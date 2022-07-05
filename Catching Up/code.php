<?php
/**
 * catch up and win
 **/

// $K: representing after how many turns the sus man will make another move
fscanf(STDIN, "%d", $K);
for ($y = 0; $y < 10; $y++) {
    $line = stream_get_line(STDIN, 10 + 1, "\n");

    //We need the starting position of our character
    if(($p = strpos($line, "P")) !== false) {
        $px = $p;
        $py = $y;
    }

    $map[] = $line;
}

error_log(var_export($map, true));

// game loop
while (TRUE) {
    fscanf(STDIN, "%d %d", $ey, $ex);

    //We start the search from the ennemy position
    $positions = [[$ex, $ey, ""]];

    while(true) {
        $possibleMoves = [];
        $newPositions = [];
        $visited = [];

        //Check all the positions we reached last step
        foreach ($positions as $position) {
            list($ex, $ey, $d) = $position;

            //Already where there
            if(isset($visited[$ey][$ex])) continue;

            //Reach our person, we continue until the end of this step to have all the possible moves with the same score
            if($ex == $px && $ey == $py) {
                $possibleMoves[] = $d;
                continue;
            }

            $visited[$ey][$ex] = 1;

            //Check the cardinal directions
            foreach([[0, -1, "D"], [-1, 0, "R"], [0, 1, "U"], [1, 0, "L"]] as $move) {
                $ux = $ex + $move[0];
                $uy = $ey + $move[1];
    
                if($ux < 0 || $ux >= 10 || $uy < 0 || $uy >= 10 || $map[$uy][$ux] == "*") continue;
                else $newPositions[] = [$ux, $uy, $move[2]];
            }
        }

        //We reached our person
        if(count($possibleMoves)) {
            //In case several direction have the same score, pick one randomly
            shuffle($possibleMoves);

            $d = array_pop($possibleMoves);

            //Update person position for next turn
            switch($d) {
                case "U": --$py; break;
                case "D": ++$py; break;
                case "L": --$px; break;
                case "R": ++$px; break;
            }

            echo $d . "\n";
            continue 2;
        } //We haven't reached our person, continue the search
        else $positions = $newPositions;
    }
}
?>
