<?php

$s = microtime(true);

function getDominos($n) {
    for($i = 0; $i <= $n; ++$i) {
        for($j = $i; $j <= $n; ++$j) {
            $results[$i . "-" . $j] = 1;
        }
    }

    return $results;
}

fscanf(STDIN, "%d", $n);

$dominos = getDominos($n);

fscanf(STDIN, "%d %d", $h, $w);
for ($i = 0; $i < $h; $i++) {
    $grid[] = stream_get_line(STDIN, $w + 1, "\n");
}

function findDominoes(array &$grid, array &$dominos) {

    global $w, $h;

    do {
        $dominoSet = false;
    
        $possibilities = [];

        for($y = 0; $y < $h; ++$y) {
            for($x = 0; $x < $w; ++$x) {
                //This position was already replaced
                if(!is_numeric($grid[$y][$x])) continue; 

                //The dominos in horizontal position
                if($x < ($w - 1) && is_numeric($grid[$y][$x + 1])) {
                    $a = min($grid[$y][$x], $grid[$y][$x + 1]);
                    $b = max($grid[$y][$x], $grid[$y][$x + 1]);
                
                    $possibilities[$a . "-" . $b][] = ["=", $x, $y, $x + 1, $y];
                } //The dominos in vertical position
                if($y < ($h - 1) && is_numeric($grid[$y + 1][$x])) {
                    $a = min($grid[$y][$x], $grid[$y + 1][$x]);
                    $b = max($grid[$y][$x], $grid[$y + 1][$x]);

                    $possibilities[$a . "-" . $b][] = ["|", $x, $y, $x, $y + 1];
                }

                //Check how many potential dominos we have using this position
                
                $positions = [];

                //LEFT
                if($x > 0 && is_numeric($grid[$y][$x - 1])) {
                    $positions[] = ["=", $x - 1, $y, $x, $y];
                }//RIGHT
                if($x < $w - 1 && is_numeric($grid[$y][$x + 1])) {
                    if(count($positions)) continue;
                    else $positions[] = ["=", $x, $y, $x + 1, $y];
                }//UP 
                if($y > 0 && is_numeric($grid[$y - 1][$x])) {
                    if(count($positions)) continue;
                    else $positions[] = ["|", $x, $y - 1, $x, $y];
                }//BOTTOM 
                if($y < $h - 1 && is_numeric($grid[$y + 1][$x])) {
                    if(count($positions)) continue;
                    else $positions[] = ["|", $x, $y, $x, $y + 1];
                } 

                //Only one, so we have to use it
                list($c, $x1, $y1, $x2, $y2) = array_pop($positions);

                $a = min($grid[$y1][$x1], $grid[$y2][$x2]);
                $b = max($grid[$y1][$x1], $grid[$y2][$x2]);

                $grid[$y1][$x1] = $grid[$y2][$x2] = $c;

                unset($dominos[$a . "-" . $b]);

                $dominoSet = true;
            }
        }

        foreach($dominos as $key => $domino) {
            //No possibility for a domino => invalid grid
            if(!isset($possibilities[$key])) return -1;
            //Only 1 possibility for this domino, we use it
            if(count($possibilities[$key]) == 1) {
                list($c, $x1, $y1, $x2, $y2) = array_pop($possibilities[$key]);

                //2 dominos with only 1 possibility are overlapping => invalid grid
                if(!is_numeric($grid[$y1][$x1]) || !is_numeric($grid[$y2][$x2])) return -1;

                $grid[$y1][$x1] = $grid[$y2][$x2] = $c;

                unset($dominos[$key]);

                $dominoSet = true;
            }
        }

    } while($dominoSet && count($dominos));

    return (count($dominos)) ? 0 : 1;
}

//Make a guess on a domino position
function getGuess($grid, $dominos, $forbidden) {

    global $w, $h;

    for($y = 0; $y < $h; ++$y) {
        for($x = 0; $x < $w; ++$x) {
            if(!is_numeric($grid[$y][$x])) continue; 

            //LEFT
            if($x > 0 && is_numeric($grid[$y][$x - 1])) {
                $a = min($grid[$y][$x], $grid[$y][$x - 1]);
                $b = max($grid[$y][$x], $grid[$y][$x - 1]);

                if(!isset($forbidden[$a . "-" . $b][($x - 1) . "=" . $y])) return [$a . "-" . $b, "=", $x - 1, $y, $x, $y];
            }//RIGHT
            if($x < $w - 1 && is_numeric($grid[$y][$x + 1])) {
                $a = min($grid[$y][$x], $grid[$y][$x + 1]);
                $b = max($grid[$y][$x], $grid[$y][$x + 1]);

                if(!isset($forbidden[$a . "-" . $b][$x . "=" . $y])) return [$a . "-" . $b, "=", $x, $y, $x + 1, $y];
            }//UP 
            if($y > 0 && is_numeric($grid[$y - 1][$x])) {
                $a = min($grid[$y][$x], $grid[$y - 1][$x]);
                $b = max($grid[$y][$x], $grid[$y - 1][$x]);

                if(!isset($forbidden[$a . "-" . $b][$x . "|" . ($y - 1)])) return [$a . "-" . $b, "|", $x, $y - 1, $x, $y];
            }//BOTTOM 
            if($y < $h - 1 && is_numeric($grid[$y + 1][$x])) {
                $a = min($grid[$y][$x], $grid[$y + 1][$x]);
                $b = max($grid[$y][$x], $grid[$y + 1][$x]);

                if(!isset($forbidden[$a . "-" . $b][$x . "|" . $y])) return [$a . "-" . $b, "|", $x, $y, $x, $y + 1];
            } 
            
            return null;
        }
    }
}

$backup = [];
$forbidden = [];

while(true) {
    //Look for all the dominos that can only have 1 position
    $result = findDominoes($grid, $dominos);

    //We found all the dominos
    if($result == 1) break;

    while(true) {

        //Current grid is invalid => reload backup
        if($result == -1) {
            list($grid, $dominos, $forbidden) = array_pop($backup);
        }

        //The dominos that are left can't be found for sure, make a guess
        $guess = getGuess($grid, $dominos, $forbidden);

        if($guess != null) {
            list($key, $c, $x1, $y1, $x2, $y2) = $guess;

            $forbidden[$key][$x1 . $c . $y1] = 1;
            $backup[] = [$grid, $dominos, $forbidden];
    
            unset($dominos[$key]);
            
            $grid[$y1][$x1] = $grid[$y2][$x2] = $c;
    
            break;
        } else $result = -1;
    }
}

echo implode("\n", $grid);
error_log(var_export("\n" . (microtime(true) - $s), true));
?>
