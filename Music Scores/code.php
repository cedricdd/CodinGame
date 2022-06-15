<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

//Flip an array diagonnaly, rows becomes columns
/*
 * 1 2 3 4
 * 5 6 7 8
 * 
 * 1 5
 * 2 6
 * 3 7
 * 4 8
 */
function flipDiagonally($arr) {
    $out = array();
    foreach ($arr as $key => $subarr) {
        foreach (str_split($subarr) as $subkey => $subvalue) {
            $out[$subkey] = ($out[$subkey] ?? "") . $subvalue;
        }
    }
    return $out;
}

fscanf(STDIN, "%d %d", $W, $H);
preg_match_all("/[B|W] [0-9]+/", fgets(STDIN), $matches);

//error_log(var_export($matches, true));

$staff = [];
$line = "";
$spaceLeft = $W;

//Create the "musical staff" based on inputs
foreach($matches[0] as $match) {
    list($color, $number) = explode(' ', $match);
    
    //There might be more pixels than the size of a line
    while($number) {
        $occurrences = min($number, $spaceLeft); //How man pixels we can still add on this line
        $line .= str_repeat(($color == "B" ? 1 : 0), $occurrences);
        
        $spaceLeft -= $occurrences;
        $number -= $occurrences;
        
        //We have a full line
        if($spaceLeft == 0) {
            //We only use the line if it's different from the previous one (ignore duplicate info)
            if($line !== end($staff)) $staff[] = $line;
            
            $spaceLeft = $W;
            $line = "";
        }
    }
}

$staff = flipDiagonally($staff);

//If 2 lines following each other are similiar we remove one
foreach($staff as $i => $line) {
    if($i > 0 && $staff[$i - 1] === $line) unset($staff[$i - 1]);
}

//Reset indexes after lines have been deleted
$staff = array_values($staff);

//Get the position of the 5 lines
preg_match_all("/1/", $staff[1], $matches, PREG_OFFSET_CAPTURE);
$lines = array_column($matches[0], 1);

//The pattern of an empty line (no part of a note on these lines)
$emptyPattern = "/" . substr($staff[1], 0, $lines[4] + 1) . "(?:0+|0+(?:11){0,2}0+)$/" . "\n";

//Find all the empty lines
for($i = 1; $i < count($staff); ++$i) {
    if(preg_match($emptyPattern, $staff[$i])) $separators[] =  $i;
}

//Notes are located between 2 "empty" lines
for($i = 1; $i < count($separators); ++$i) {
    //Not enough space for a note, we get that when there's a lower C with a 6th line
    if($separators[$i] - $separators[$i - 1] <= 3) continue;

    //Get the first line with at least two 1 consecutive below the top empty line
    $index = $separators[$i-1];
    do {
        ++$index;
        preg_match_all("/1{2,}/", $staff[$index], $matches, PREG_OFFSET_CAPTURE);
        $topInfo = $matches[0];
    } while(count($topInfo ) == 0);
    
    $index = $separators[$i];
    do {
        --$index;
        preg_match_all("/1{2,}/", $staff[$index], $matches, PREG_OFFSET_CAPTURE);
        $bottomInfo = $matches[0];
    } while(count($bottomInfo) == 0);
    
    //On one side we get the tail, we don't care about that, we use the other info
    if(strlen($topInfo[0][0]) < strlen($bottomInfo[0][0])) $info = $topInfo[0];
    else $info = $bottomInfo[0];
    
    $start = $info[1]; //Start position
    $end = $info[1] + strlen($info[0]) - 1; //End position
    
    if($end < $lines[0]) $note =  "G";
    elseif($start < $lines[0]) $note =  "F";
    elseif($end < $lines[1]) $note =  "E";
    elseif($start < $lines[1]) $note =  "D";
    elseif($end < $lines[2]) $note =  "C";
    elseif($start < $lines[2]) $note =  "B";
    elseif($end < $lines[3]) $note =  "A";
    elseif($start < $lines[3]) $note =  "G";
    elseif($end < $lines[4]) $note =  "F";
    elseif($start < $lines[4]) $note =  "E";
    elseif(($start - $lines[4]) > (strlen($staff[$i]) - $start)) $note = "C"; 
    else $note = "D";
    
    //Check the value of the position at the center of the note to determine if the note is half or quarter
    if($staff[intdiv($separators[$i-1] + $separators[$i], 2)][$info[1] + intdiv(strlen($info[0]), 2)] == "1") $note .= "Q";
    else $note .= "H";

    $output[] = $note;
}

error_log(var_export($output, true));

echo implode(" ", $output);
?>
