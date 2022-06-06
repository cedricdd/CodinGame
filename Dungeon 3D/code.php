<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d %d", $L, $R, $C);
fscanf(STDIN, "%d", $ln);

$floor = 0;
$paths = null;

for ($i = 0; $i < $ln; $i++)
{
    $line = stream_get_line(STDIN, $C + 1, "\n");

    if(!empty($line)) $map[$floor][] = $line;
    else ++$floor; 
    
    //We save the initial position
    if($paths == null && ($position = strpos($line, 'A')) !== false) {
        $paths[0] = [$floor . "," . ($i - ($R + 1) * ($floor - 1) - 1) . "," . $position];
    }   
}

$alreadyExplored = [];
$index = 0;

do {
    //Check all the position we can reach in $index move
    foreach($paths[$index] as $position) {
        list($floor, $row, $column) = explode(',', $position);
        
        $directions = [
            $floor . "," . ($row - 1) . "," . $column, //up
            $floor. "," . ($row + 1) . "," . $column, //down
            $floor . "," . $row . "," . ($column - 1), //left
            $floor . "," . $row . "," . ($column + 1), //right
            ($floor + 1) . "," . $row . "," . $column, //top
            ($floor - 1) . "," . $row . "," . $column, //down
        ];

        //Check all the possible directions from the current position
        foreach ($directions as $postionToCheck) {
            list($floor, $row, $column) = explode(',', $postionToCheck);

            //We are out of the map, we skip
            if($floor < 1 || $floor > $L || $row < 0 || $row >= $R || $column < 0 || $column >= $C) continue;

            //Skip if we have already explored this position
            if(!in_array($postionToCheck, $alreadyExplored)) {
                $character = $map[$floor][$row][$column];

                //We reached the source
                if($character == 'S') {
                    echo $index + 1 . "\n";
                    exit();
                }
                //We can move to this position
                elseif($character == '.') $paths[$index + 1][] = $postionToCheck;

                //Don't test this position again
                $alreadyExplored[] = $postionToCheck;
            }
        }
    }
} while(isset($paths[++$index]));

echo "NO PATH\n";
?>
