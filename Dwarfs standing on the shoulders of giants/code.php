<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

 $max = 1;

// $n: the number of relationships of influence
fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++)
{
    fscanf(STDIN, "%d %d", $s, $d);

    error_log(var_export($s . " => " . $d, true));
    
    //Set the relation
    if(!isset($r[$s][$d])) {
        $r[$s][$d] = 1;
    }

    //If the source has existing relations
    if(isset($r[$d])) {
        //The source can reach all the destinations too
        foreach($r[$d] as $dest => $count) {
            //We only want the longest path if several exist
            $r[$s][$dest] = max($r[$s][$dest] ?? 0, $count + 1);
    
            $max = max($max, $r[$s][$dest]);
        }
    }

    //Check all the known nodes
    foreach($r as $key => $relations) {
        //The node can reach the source
        if(isset($relations[$s])) {
            //Meaning the node can also reach everything the source can
            foreach($r[$s] as $dest => $count) {
                //We only want the longest path if several exist
                $r[$key][$dest] = max($r[$key][$dest] ?? 0, $r[$key][$s] + $count);

                $max = max($max, $r[$key][$dest]);
            }
        }
    }

    error_log(var_export($r, true));
}

// The number of people involved in the longest succession of influences
echo($max + 1 . "\n");
?>
