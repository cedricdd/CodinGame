<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d %d %d", $L, $C, $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d", $Pi);
    $groups[] = [$i, $Pi];
}

error_log(var_export("Places: " . $L, true));
error_log(var_export("Rotations: " . $C, true));
error_log(var_export("Groups: " . count($groups), true));

$dirhams = 0;
$rotation = 1;
$memory = [];

while($rotation <= $C) {
    //The ID of the first group that we will try to add for this ride
    $firstGroup = $groups[0][0];

    //We reached a point where we already know the output of this rotation
    if(isset($memory[$firstGroup])) {
        //Foreach remaining rotation add the # of people
        for($i = $rotation; $i <= $C; ++$i) {
            list($size, $firstGroup) = $memory[$firstGroup];
            $dirhams += $size;
        }
        //We are done, we did all the rotations
        break;
    }

    $rotation++;
    $size = 0;
    $spaceLeft = $L;

    //Each group can't be added more than one per rotation
    for($i = 0; $i < $N; ++$i) {
        $group = array_shift($groups);

        //Try to add the next group
        if($group[1] <= $spaceLeft) { 
            $size += $group[1];
            $spaceLeft -= $group[1];
            $groups[] = $group;
        } //Not enough place left, we are done for this rotation 
        else {
            array_unshift($groups, $group);
            break;
        }
    }

    $memory[$firstGroup] = [$size, $groups[0][0]];
    $dirhams += $size;
}

echo $dirhams;
?>
