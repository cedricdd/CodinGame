<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

// $nbFloors: number of floors
// $width: width of the area
// $nbRounds: maximum number of rounds
// $exitFloor: floor on which the exit is found
// $exitPos: position of the exit on its floor
// $nbTotalClones: number of generated clones
// $nbAdditionalElevators: ignore (always zero)
// $nbElevators: number of elevators
fscanf(STDIN, "%d %d %d %d %d %d %d %d", $nbFloors, $width, $nbRounds, $exitFloor, $exitPos, $nbTotalClones, $nbAdditionalElevators, $nbElevators);
for ($i = 0; $i < $nbElevators; $i++)
{
    // $elevatorFloor: floor on which this elevator is found
    // $elevatorPos: position of the elevator on its floor
    fscanf(STDIN, "%d %d", $elevatorFloor, $elevatorPos);
    $elevators[$elevatorFloor] = $elevatorPos;
}

//error_log(var_export($nbFloors . " " . $width . " " . $nbRounds . " " . $exitFloor . " " . $exitPos . " " . $nbTotalClones . " " . $nbAdditionalElevators . " " . $nbElevators, true));

// game loop
while (TRUE)
{
    // $cloneFloor: floor of the leading clone
    // $clonePos: position of the leading clone on its floor
    // $direction: direction of the leading clone: LEFT or RIGHT
    fscanf(STDIN, "%d %d %s", $cloneFloor, $clonePos, $direction);

    //error_log(var_export($cloneFloor ." ". $clonePos . " " . $direction, true));

    if($direction != "NONE") {
        if($cloneFloor == $exitFloor) $position = $exitPos;
        else $position = $elevators[$cloneFloor];

        if(($position < $clonePos && $direction == "RIGHT") || ($position > $clonePos && $direction == "LEFT")) {
            echo("BLOCK\n");
            continue;
        }
    } 
    
    echo("WAIT\n");

    // Write an action using echo(). DON'T FORGET THE TRAILING \n
    // To debug: error_log(var_export($var, true)); (equivalent to var_dump)
}
?>
