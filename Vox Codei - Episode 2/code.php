<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/
// $width: width of the firewall grid
// $height: height of the firewall grid
fscanf(STDIN, "%d %d", $width, $height);

$grids = [];
$nodes = [];
$possibleBombs = [];
$nodesToCheck = [];
$actions = null;
$step = 0;
$totalRounds = 0;

function getInitInfo(&$cGrid) {
    global $grids, $nodesToCheck, $width, $height, $totalRounds;

    for($y = 0; $y < $height; ++$y) {
        for($x = 0; $x < $width; ++$x) {
            //We found a node
            if($cGrid[$y][$x] == "@") {
                //The possible directions of this node, 
                //if a node would directly switch direction it's not considered a valid initial diretion
                $possibleDirections = ['STATIC'];
                if($y > 0 && $cGrid[$y - 1][$x] != "#") $possibleDirections[] = "UP";
                if($y < ($height - 1) && $cGrid[$y + 1][$x] != "#") $possibleDirections[] = "DOWN";
                if($x > 0 && $cGrid[$y][$x - 1] != "#") $possibleDirections[] = "LEFT";
                if($x < ($width - 1) && $cGrid[$y][$x + 1] != "#") $possibleDirections[] = "RIGHT";

                $nodesToCheck[$x . "-" . $y] = $possibleDirections;
                $cGrid[$y][$x] = '.';
            }
        }

        //More than one node can be in a single cell, we can save it as a string
        $cGrid[$y] = str_split($cGrid[$y]);
    }

    $grids = array_fill(0, $totalRounds, $cGrid); //Will be used to represent the grids for each turn
}

//Simulate the movement of a node on the grid given a direction
function moveNode($x, $y, $direction, $step = 1) {

    global $grids, $width, $height;
    $grid = $grids[0];

    //Move the node for $step steps
    foreach(range(1, $step) as $filler) {
        switch($direction) {
            case "UP":
                //node switches to down
                if($y == 0 || $grid[$y-1][$x] == "#") {
                    $direction = "DOWN";
                    ++$y;
                } else --$y;
                break;
            case "DOWN":
                //node switches to up
                if($y == ($height - 1) || $grid[$y+1][$x] == "#") {
                    $direction = "UP";
                    --$y;
                } else ++$y;
                break;
            case "LEFT":
                //node switches to right
                if($x == 0 || $grid[$y][$x-1] == "#") {
                    $direction = "RIGHT";
                    ++$x;
                } else --$x;
                break;
            case "RIGHT":
                //node switches to left
                if($x == ($width - 1) || $grid[$y][$x+1] == "#") {
                    $direction = "LEFT";
                    --$x;
                } else ++$x;
                break;
        }   
    }

    return [$x, $y, $direction];
}

//Find the direction of a given node
function findDirection(&$cGrid, $step) {
    global $nodesToCheck, $width, $height;

    foreach($nodesToCheck as $index => $node) {

        list($nx, $ny) = explode('-', $index);

        foreach($node as $di => $possibleDirection) {
            //Get the position this node would be given an initial direction
            list($x, $y, $direction) = moveNode($nx, $ny, $possibleDirection, $step);

            //There's no node at this position, this direction is impossible
            if($cGrid[$y][$x] != "@") unset($nodesToCheck[$index][$di]);
        }
        
        //There's only 1 direction left
        if(count($nodesToCheck[$index]) == 1) {
            getFuturPositions($nx, $ny, array_pop($nodesToCheck[$index]));
            unset($nodesToCheck[$index]); //We are done with this node
        }
    }

}

//Get the nodes affected by a bomb placed at a given position
function getNodesAffected($step) {

    global $width, $height, $totalRounds, $grids, $possibleBombs;

    //Nodes are moving so for each turns the results will be different, so we need to do it for each turns
    while($step < ($totalRounds - 3)) {

        $grid = $grids[$step]; //The representation of the grid at the current turn
        $gridFuture = $grids[$step + 3]; //The representation of the grid when the bomb will explode
        $skip = [];
        
        for($y = 0; $y < $height; ++$y) {
            for($x = 0; $x < $width; ++$x) {
                //We could put a bomb at this position
                if($grid[$y][$x] == ".") {

                    $affected = [];

                    //A node will be over the bomb
                    if(is_array($gridFuture[$y][$x])) $affected = array_merge($affected, $gridFuture[$y][$x]);
              
                    //Top
                    for ($y2 = $y - 1; $y2 >= max(0, $y - 3); --$y2) {
                        if($gridFuture[$y2][$x] == "#") break;
                        if(is_array($gridFuture[$y2][$x])) $affected = array_merge($affected, $gridFuture[$y2][$x]);
                    }
                    //Bottom
                    for ($y2 = $y + 1; $y2 < min($height, $y + 4); ++$y2) {
                        if($gridFuture[$y2][$x] == "#") break;
                        if(is_array($gridFuture[$y2][$x])) $affected = array_merge($affected, $gridFuture[$y2][$x]);
                    }
                    //Left
                    for ($x2 = $x - 1; $x2 >= max(0, $x - 3); --$x2) {
                        if($gridFuture[$y][$x2] == "#") break;
                        if(is_array($gridFuture[$y][$x2])) $affected = array_merge($affected, $gridFuture[$y][$x2]);
                    }
                    //Right
                    for ($x2 = $x + 1; $x2 < min($width, $x + 4); ++$x2) {
                        if($gridFuture[$y][$x2] == "#") break;
                        if(is_array($gridFuture[$y][$x2])) $affected = array_merge($affected, $gridFuture[$y][$x2]);
                    }

                    //Some nodes would be destroyed by the bomb
                    if(count($affected)) {

                        if(count($affected) > 1) {
                            sort($affected);
                        }

                        $check = implode('-', $affected);
            
                        //We don't need multiple solutions to destroy the same set of bombs
                        if(!isset($skip[$check])) {
                            $possibleBombs[$step][count($affected)][] = [$x . " " . $y, $affected];
                            $skip[$check] = 1;
                        }
                    }
                }
            }
        }

        //The more nodes are affected, the better
        krsort($possibleBombs[$step]);

        ++$step;
    }
}

//This is called when we have found the direction of a node
function getFuturPositions($x, $y, $direction) {
    global $grids, $nodes, $width, $height, $totalRounds;

    $index = $x . " " . $y;
    $nodes[$index] = 1; //The list of nodes we will have to destroy

    //We save the position of this node for all turns
    foreach(range(0, $totalRounds - 1) as $step) {

        //Already another node at the same position
        if(is_array($grids[$step][$y][$x])) $grids[$step][$y][$x][] = $index;
        //First node at this positon
        else $grids[$step][$y][$x] = [$index];
   
        //Get the next postion of the node
        list($x, $y, $direction) = moveNode($x, $y, $direction);   
    }
}

//Search for a list of actions that would destroy all nodes
function findActions($lNodes, $lActions, $bLeft, $cStep) {
    global $possibleBombs, $totalRounds, $test;

    //We found a winning solution, we don't need the best one, any will do, we stop here 
    if(count($lNodes) == 0) return $lActions;

    //This can't be a winning solution
    if($bLeft <= 0 || ($totalRounds - $cStep) < 3) return null;

    //The place where we can place bombs for the current turn
    $pBombs = $possibleBombs[$cStep];

    //We loop through possible bombs (starting with bombs affecting the most nodes)
    foreach($pBombs as $nDestroyed => $bArray) {
        //This solution can't work, not enough bombs left
        if($nDestroyed * $bLeft < count($lNodes)) break;

        //This solution can't work, not enough turns left
        if((3 + ceil(count($lNodes) / $nDestroyed)) > (($totalRounds - $cStep))) break;

        foreach($bArray as $possibleBomb) {
            list($bPosition, $affected) = $possibleBomb;

            //We check that each of the nodes affected by this bomb still needs to be destroyed
            foreach($affected as $key => $node) {
                //That node has already been destroyed
                if(!isset($lNodes[$node])) unset($affected[$key]);
            }

            $nAffected = count($affected);

            //Some of the nodes affected don't need to be destroyed anymore
            if($nAffected != $nDestroyed) {
                //Putting a bomb here would still destroyed other bombs, keeping it as a possible placement.
                if($nAffected) $pBombs[$nAffected][] = [$bPosition, $affected];
                continue;
            }

            //Try to find a solution if we place this bomb
            $actions = findActions(
                $filtered = array_filter(
                    $lNodes,
                    function ($key) use ($affected) {
                        return !in_array($key, $affected);
                    },
                    ARRAY_FILTER_USE_KEY
                ),
                $lActions + [$cStep => $bPosition], 
                $bLeft - 1, 
                $cStep + 1);

            if($actions != null) return $actions;
        }
    }

    //Couldn't find a valid solution
    return null;
}

// game loop
while (TRUE)
{
    // $rounds: number of rounds left before the end of the game
    // $bombs: number of bombs left
    fscanf(STDIN, "%d %d", $rounds, $bombs);

    for ($i = 0; $i < $height; $i++) {
        $cGrid[] = stream_get_line(STDIN, $width + 1, "\n");// one line of the firewall grid
    }

    error_log(var_export($cGrid, true));

    if($step == 0) {
        $totalRounds = $rounds;

        getInitInfo($cGrid);
    } elseif(count($nodesToCheck)) {
        findDirection($cGrid, $step);
    } elseif(count($possibleBombs) == 0) {
        getNodesAffected($step);
    } elseif($actions == null) {
        $actions = findActions($nodes, [], $bombs, $step);
    } 

    if(isset($actions[$step])) echo $actions[$step] . "\n";
    else echo("WAIT\n");
 
    ++$step;
    $cGrid = [];
}
?>
