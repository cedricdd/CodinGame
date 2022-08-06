<?php

fscanf(STDIN, "%d %d", $width, $height);
for ($i = 0; $i < $width; $i++) {
    $cols[] = explode(" ", stream_get_line(STDIN, 256 + 1, "\n"));
}
for ($i = 0; $i < $height; $i++) {
    $rows[] = explode(" ", stream_get_line(STDIN, 256 + 1, "\n"));
}

$grid = array_fill(0, $height, array_fill(0, $width, " ")); 

//Generate all the ways to set the "B" in a string of a given size following an adjacent pattern
function getSolutions(string $s, int $size, int $whiteLeft, array &$adjacents, int $j, array &$solutions): void {
    //String is full
    if($size == strlen($s)) {
        //All the "B" have been successfully placed
        if($j == count($adjacents)) $solutions[] = $s;
        return;
    }

    //We just add a "W"
    if($whiteLeft) getSolutions($s . "W", $size, $whiteLeft - 1, $adjacents, $j, $solutions);
        
    //We add the block of "B" if it's allowed
    if(($s[-1] ?? "") != "B" && $j < count($adjacents) && ($adjacents[$j] + strlen($s) <= $size)) {
        getSolutions($s . str_repeat("B", $adjacents[$j]), $size, $whiteLeft, $adjacents, $j + 1, $solutions);
    }
}

//Generate all the solutions for each rows
$solutionsRow = array_fill(0, $height, []);
foreach($rows as $y => $row) {
    getSolutions("", $width, ($width - array_sum($row)), $row, 0, $solutionsRow[$y]);
}
//Generate all the solutions for each columns
$solutionsCol = array_fill(0, $width, []);
foreach($cols as $x => $column) {
    getSolutions("", $height, ($height - array_sum($column)), $column, 0, $solutionsCol[$x]);
}

//Loop until we have found everything
while(count($rows) + count($cols)) {

    //Check each rows we haven't found yet
    foreach($rows as $y => $filler) {

        //There are still more than 1 solution for this row
        if(count($solutionsRow[$y]) > 1) {
            //Check the solution against the solutions for the columns
            foreach($solutionsRow[$y] as $ids => $solutionRow) {
                for($x = 0; $x < $width; ++$x) {
                    foreach($solutionsCol[$x] as $solutionCol) {
                        //There's a valid solution for the column $x
                        if($solutionCol[$y] == $solutionRow[$x]) continue 2;
                    }

                    //None of the solution for the column $x can be used, the solution for the row $y is not valid
                    unset($solutionsRow[$y][$ids]);

                    continue 2;
                }
            }
        }

        //There is only 1 solution left for this row, we use it
        if(count($solutionsRow[$y]) == 1) {
            $solution = reset($solutionsRow[$y]);
            
            //Update the grid with the solution
            for($x = 0; $x < $width; ++$x) $grid[$y][$x] = $solution[$x];

            unset($rows[$y]);
        }
    }
    
    //Check each columns we haven't found yet
    foreach($cols as $x => $filler) {

        //There are still more than 1 solution for this column
        if(count($solutionsCol[$x]) > 1) {
            //Check the solution against the solutions for the rows
            foreach($solutionsCol[$x] as $ids => $solutionCol) {
                for($y = 0; $y < $height; ++$y) {
                    foreach($solutionsRow[$y] as $solutionRow) {
                        //There's a valid solution for the row $y
                        if($solutionCol[$y] == $solutionRow[$x]) continue 2;
                    }

                    //None of the solution for the row $y can be used, the solution for the column $x is not valid
                    unset($solutionsCol[$x][$ids]);

                    continue 2;
                }
            }
        }
  
        //There is only 1 solution left for this column, we use it
        if(count($solutionsCol[$x]) == 1) {
            $solution = reset($solutionsCol[$x]);

            //Update the grid with the solution
            for($y = 0; $y < $height; ++$y) $grid[$y][$x] = $solution[$y];

            unset($cols[$x]);
        } 
    }
}

//Length of adjacent white cells in the columns
for($x = 0; $x < $width; ++$x) {
    $adjacents = [];
    $inc = true;
    $id = 0;
    for($y = 0; $y < $height; ++$y) {
        if($grid[$y][$x] == "W") {
            if($inc) {
                $adjacents[++$id] = 0;
                $inc = false;
            }
            $adjacents[$id]++;
        } else $inc = true;
    }
    echo implode(" ", $adjacents ?: [0]) . PHP_EOL;
}

//Length of adjacent white cells in the rows 
for($y = 0; $y < $height; ++$y) {
    $adjacents = [];
    $inc = true;
    $id = 0;
    for($x = 0; $x < $width; ++$x) {
        if($grid[$y][$x] == "W") {
            if($inc) {
                $adjacents[++$id] = 0;
                $inc = false;
            }
            $adjacents[$id]++;
        } else $inc = true;
    }
    echo implode(" ", $adjacents ?: [0]) . PHP_EOL;
}
?>
