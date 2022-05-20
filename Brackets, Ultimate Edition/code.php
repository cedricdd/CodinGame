<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/
fscanf(STDIN, "%d", $N);

$otc = ['(' => ')', '{' => '}', '[' => ']', '<' => '>'];
$cto = [')' => '(', '}' => '{', ']' => '[', '>' => '<'];

  
for ($l = 0; $l < $N; $l++) {
    $expression = preg_replace('/[a-zA-Z0-9]/', '', stream_get_line(STDIN, 10000 + 1, "\n"));

    error_log(var_export($expression, true));

    //Remove everything that doesn't require a flip
    while($expression != ($cmp ?? "")) {
        $cmp = $expression;
        $expression = strtr($expression, ['()' => '', '[]' => '', '{}' => '', '<>' => '']);
    }

    $toCheck[] = [0, 0, []];
    $bestSolution = 30; //number of bracketing elements ≤ 25

    while(count($toCheck)) {
        list($index, $flip, $pile) = array_pop($toCheck);

        //We already have a better solution
        if($flip > $bestSolution) continue;

        //Can't be a valid solution, not enough elements left to close all
        if(count($pile) > (strlen($expression) - $index)) continue;

        for($i = $index; $i < strlen($expression); ++$i) {
            $char = $expression[$i];

            //Pile is empty
            if(count($pile) == 0) {
                //First one has to be an opening bracket
                if(isset($cto[$char])) {
                    $char = $cto[$char];
                    ++$flip;
                }
                $pile[] = $char;

                continue;
            } else {
                $last = array_pop($pile);

                //Same bracketing element as last one, we can remove by flipping
                if($char === $last) {
                    
                    //Case where we flip
                    $toCheck[] = [$i + 1, $flip + 1, $pile];

                    //Not flipping, just adding in pile
                    $pile = array_merge($pile, [$last, $char]);
                    continue;

                } //Bracketing element is closing the last opening, move to next one
                elseif($last === ($cto[$char] ?? "")) {
                    continue;
                } //Not possible to close the last opening
                else {
                    //We only add opening in pile
                    if(isset($cto[$char])) {
                        $char = $cto[$char];
                        ++$flip;
                    }
                    $pile = array_merge($pile, [$last, $char]);
                }
            }

        }

        //We found a solution, checking if it's the current best
        if(count($pile) == 0 && $bestSolution > $flip) $bestSolution = $flip;
    }


    if($bestSolution == 30) echo "-1\n";
    else echo $bestSolution . "\n";
}
?>
