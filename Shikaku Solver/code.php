<?php

$start = microtime(true);

fscanf(STDIN, "%d %d", $W, $H);
for ($y = 0; $y < $H; ++$y) {
    foreach(explode(" ", trim(fgets(STDIN))) as $x => $v) {
        if($v !== "0") $positions[] = [$x, $y, $v]; //Save the position of all the numbers
        $grid[$y][$x] = $v;
    } 
}

$columns = array_fill(0, $W * $H, []);
$counts = array_fill(0, $W * $H, 0);
$rows = [];

//We search for all the valid rectangles covering each number
foreach($positions as $key => $info) {
    list($x, $y, $v) = $info;

    for($hr = 1; $hr <= min($v, $W); ++$hr) {
        if($v % $hr != 0) continue; //We can't make a rectangle with that height value

        $wr = $v / $hr;

        //We check with all the starting position for the rectangle
        for($yr = max(0, $y - $hr + 1); $yr <= min($y, $H - $hr); ++$yr) {
            for($xr = max(0, $x - $wr + 1); $xr <= min($x, $W - $wr); ++$xr) {

                $solution = [];
                
                for($yi = $yr; $yi < $yr + $hr; ++$yi) {
                    for($xi = $xr; $xi < $xr + $wr; ++$xi) {
                        //The rectangle is covering another number => invalid
                        if($grid[$yi][$xi] !== "0" && !($x == $xi && $y == $yi)) continue 3;
   
                        $solution[$xi + $yi * $W] = $xi + $yi * $W; //We use the value as key too to be able to directly unset it
                    }
                }

                /*
                 * To solve the problem we are using Knuth's Algorithm X but instead of storing the info as the full matrix 
                 * we only store the position of the 1 in each rows & columns and the number of the 1 in each column to speed up the algo.
                 */
                $y2 = count($rows);
                foreach($solution as $x2) {
                    ++$counts[$x2];
                    $columns[$x2][$y2] = $y2; //We use the value as key too to be able to directly unset it
                }
                $rows[$y2] = $solution;
            }
        }
    }
}

$results = [];

//We have found a way to cover the grid, generate the string representing the grid
function genrateSolution($list) {
    global $rows, $W, $H, $results;
    
    $line = array_fill(0, $W * $H, 0);
    
    //For each position set the ID of the rectangle we use
    foreach ($list as $n) {
        foreach($rows[$n] as $position) {
            $line[$position] = $n;
        }
    }

    $alphabet = array_merge(range("A", "Z"), range("a", "z"));
    $cnt = 0;
    $match = [];
    $result = "";

    //Replace the rectangle IDs by letters
    for($i = 0; $i < $W * $H; ++$i) {
        //First time we find this ID, use the next letter
        if(!isset($match[$line[$i]])) $match[$line[$i]] = $alphabet[$cnt++];

        $result .= $match[$line[$i]];
    }

    //Save the result
    $results[] = $result;
}

//We are solving by using https://en.wikipedia.org/wiki/Knuth%27s_Algorithm_X
function solve($rows, $columns, $counts, $list) {
    
    //The matrix is empty we have found a solution
    if(count($rows) == 0) {
        genrateSolution($list);
        return;
    }

    //Get the lowest number of 1s in any column and the index of the first column with the lowest number
    $min = INF;
    $column = 0;
    foreach($counts as $x => $v) {
        if($v < $min) {
            $min = $v;
            $column = $x;
        }
    }

    //The lowest number of 1s is zero => invalid
    if($min == 0) return;

    //Foreach rows that have a 1 in the column we have just selected
    foreach ($columns[$column] as $y) {

        //Copy info for recursive
        $list2 = array_merge($list, [$y]);
        $columns2 = $columns;
        $counts2 = $counts;
        $rows2 = $rows;
        
        //Foreach columns that have a 1 in the row we are testing we need to remove them
        foreach($rows[$y] as $x) {
           
            if(!isset($columns2[$x])) continue; //Column was already removed

            //Foreach rows that have a 1 in the column we are removing we need to remove them
            foreach ($columns[$x] as $yi) {

                if(!isset($rows2[$yi])) continue; //Row was already removed

                //Foreach columns that have a 1 in the row we are removing we need to update the count and remove the row from it's 1 position
                foreach($rows[$yi] as $xi) {
                    --$counts2[$xi]; //Update the count of 1s in the column
                    unset($columns2[$xi][$yi]); //Remove the row from the position of the 1s in the column
                }

                unset($rows2[$yi]); //Remove the row
            }
        
            unset($columns2[$x]); //Remove the column
            unset($counts2[$x]); //Column has been removed, we also need to remove the count
        }
        
        solve($rows2, $columns2, $counts2, $list2);
    }
}

solve($rows, $columns, $counts, []);

echo count($results) . "\n";

//Sort lexicographically
natsort($results);

//Show the first solution only
echo implode("\n",str_split(array_shift($results), $W));

error_log(var_export("\n" . (microtime(true) - $start), true));
?>
