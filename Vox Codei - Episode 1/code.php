<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

// $width: width of the firewall grid
// $height: height of the firewall grid
fscanf(STDIN, "%d %d", $width, $height);

for ($i = 0; $i < $height; $i++) {
    $grid[] = stream_get_line(STDIN, $width + 1, "\n");// one line of the firewall grid
}

$nodes = [];

//Get the nodes affected by a bomb placed at a given position
function getNodesAffected(&$grid, $x, $y) {

    global $width, $height;
    $affected = [];

    //Top
    for ($y2 = $y - 1; $y2 >= max(0, $y - 3); --$y2) {
        if($grid[$y2][$x] == "#") break;
        if($grid[$y2][$x] == "@") $affected[$x . " " . $y2] = 1;
    }
    //Bottom
    for ($y2 = $y + 1; $y2 < min($height, $y + 4); ++$y2) {
        if($grid[$y2][$x] == "#") break;
        if($grid[$y2][$x] == "@") $affected[$x . " " . $y2] = 1;
    }
    //Left
    for ($x2 = $x - 1; $x2 >= max(0, $x - 3); --$x2) {
        if($grid[$y][$x2] == "#") break;
        if($grid[$y][$x2] == "@") $affected[$x2 . " " . $y] = 1;
    }
    //Right
    for ($x2 = $x + 1; $x2 < min($width, $x + 4); ++$x2) {
        if($grid[$y][$x2] == "#") break;
        if($grid[$y][$x2] == "@") $affected[$x2 . " " . $y] = 1;
    }

    return $affected;
}

//We start by getting the postion of all the nodes to destroyed
//We test a bomb in each possible location to get how many nodes would be affected
for($y = 0; $y < $height; ++$y) {
    for($x = 0; $x < $width; ++$x) {
        //This is a node to destroyed
        if($grid[$y][$x] == "@") $nodes[$x . " " . $y] = 1;
        //This is a potential bomb placement 
        elseif($grid[$y][$x] != "#") {
            $nAffected = getNodesAffected($grid, $x, $y);

            if(count($nAffected)) $possibleBombs[count($nAffected)][] = [$x . " " . $y, $nAffected];
        }
    }
}

//This more nodes are affected, the better
krsort($possibleBombs);

$step = 0;
$actions = [];

// game loop
while (TRUE)
{
    // $rounds: number of rounds left before the end of the game
    // $bombs: number of bombs left
    fscanf(STDIN, "%d %d", $roundsLeft, $bombsLeft);

    //We need to get the list of actions to win
    if(count($actions) == 0) {

        //Initial state
        $toCheck[] = [$grid, $possibleBombs, $nodes, [], $bombsLeft, $roundsLeft];

        while(count($toCheck)) {

            list($grid, $pBombs, $lNodes, $lActions, $bLeft, $rLeft) = array_pop($toCheck);

            //We found a winning solution, we don't need the best one, any will do, we stop here 
            if(count($lNodes) == 0) {
                $actions = $lActions;
                break;
            }

            //This can't be a winning solution
            if($bLeft <= 0 || $rLeft <= 3) continue;

            //We loop through possible bombs (starting with bombs affecting the most nodes)
            foreach($pBombs as $nDestroyed => $bArray) {
                //This solution can't work, not enough bombs left
                if($nDestroyed * $bLeft < count($lNodes)) continue 2;

                //This solution can't work, not enough turns left
                if((3 + ceil(count($lNodes) / $nDestroyed)) > $rLeft) continue 2;

                while(true) {
                    if(count($pBombs[$nDestroyed]) == 0) break;

                    list($bPosition, $affected) = array_pop($pBombs[$nDestroyed]);

                    //We check that each of the nodes affected by this bomb still needs to be destroyed
                    foreach($affected as $node => $filler) {
                        //That node has already been taken care off
                        if(!isset($lNodes[$node])) {
                            unset($affected[$node]);
                            
                            //This bomb can destroyed other nodes but we first try the other bombs affecting more nodes
                            if($nDestroyed > 1) $pBombs[$nDestroyed - 1][] = [$bPosition, $affected];
 
                            continue 2;
                        }
                    }
    
                    //The case where we don't add this bomb
                    $toCheck[] = [$grid, $pBombs, $lNodes, $lActions, $bLeft, $rLeft];

                    $lNodes = array_diff_assoc($lNodes, $affected);
                    $lActions = array_merge($lActions, [$bPosition]);

                    //The case where we add the bomb and don't wait
                    $toCheck[] = [$grid, $pBombs, $lNodes, $lActions, $bLeft - 1, $rLeft - 1];

                    //Update the grid after the bomb has exploded
                    foreach($affected as $node => $filler) {
                        list($x, $y) = explode(" ", $node);

                        $grid[$y][$x] = " ";
                    }

                    //The newly possible bombs (nodes destroyed by this bomb)
                    foreach($affected as $node => $filler) {
                        list($x, $y) = explode(" ", $node);

                        $nAffected = getNodesAffected($grid, $x, $y);

                        if(count($nAffected)) $pBombs[count($nAffected)][] = [$x . " " . $y, $nAffected];
                    }

                    //The case where we add the bomb and then wait until it explodes
                    $toCheck[] = [$grid, $pBombs, $lNodes, array_merge($lActions, ['WAIT', 'WAIT', 'WAIT']), $bLeft - 1, $rLeft - 4];

                    break 2;
                }
            }
        }
    }

    if(isset($actions[$step])) echo $actions[$step] . "\n";
    else echo "WAIT\n"; //Nothing left to do, just wait

    ++$step;
}
?>
