<?php

const OPERATIONS = ["+", "-", "/", "*"];

function sortExpression(string $expression): string {
    //error_log(var_export("expression is $expression", true));

    //Split by multiplicate/division
    $terms = ["*" => ["int" => [], "exp" => []], "/" => ["int" => [], "exp" => []]];
    $count = 0;
    $term = "";
    $prev = "*";

    foreach(str_split($expression . "*") as $c) {
        if($c === "(") ++$count;
        elseif($c === ")") --$count;
        elseif($count == 0 && ($c === "*" || $c === "/")) {
            if(ctype_digit($term)) $terms[$prev]["int"][] = $term;
            elseif($term[0] === "(") $terms[$prev]["exp"][] = "(" . sortSolution(substr($term, 1, -1)) . ")";
            else $terms[$prev]["exp"][] = $term;

            $term = "";
            $prev = $c;
            continue;
        }
        
        $term .= $c;
    }

    //error_log(var_export($terms, true));

    //Sort multiplication integers
    sort($terms["*"]["int"]);
    //Sort multiplication expressions
    usort($terms["*"]["exp"], function($a, $b) {
        $valueA = @eval("return $a;");
        $valueB = @eval("return $b;"); 

        if($valueA == $valueB) return $a <=> $b;
        else return $valueA <=> $valueB;
    });
    
    $expression = implode("*", array_merge($terms["*"]["int"], $terms["*"]["exp"]));

    if(count($terms["/"]["int"]) + count($terms["/"]["exp"]) > 0) {
        //Sort division integers
        sort($terms["/"]["int"]);
        //Sort division expressions
        usort($terms["/"]["exp"], function($a, $b) {
            return eval("return $a;") <=> eval("return $b;");
        });

        $expression .= "/" . implode("/", array_merge($terms["/"]["int"], $terms["/"]["exp"]));
    }

    //error_log(var_export("end expression is $expression", true));

    return $expression;
}

function sortSolution(string $solution): string {
    //error_log(var_export("solution is $solution", true));

    //Split by addition/substraction
    $terms = ["+" => ["int" => [], "exp" => []], "-" => ["int" => [], "exp" => []]];
    $count = 0;
    $term = "";
    $prev = "+";

    foreach(str_split($solution . "+") as $c) {
        if($c === "(") ++$count;
        elseif($c === ")") --$count;
        elseif($count == 0 && ($c === "+" || $c === "-")) {
            if(ctype_digit($term)) $terms[$prev]["int"][] = $term;
            else $terms[$prev]["exp"][] = sortExpression($term);

            $term = "";
            $prev = $c;
            continue;
        }
        
        $term .= $c;
    }

    //error_log(var_export($terms, true));

    //Sort addition integers
    sort($terms["+"]["int"]);
    //Sort addition expressions
    usort($terms["+"]["exp"], function($a, $b) {
        $valueA = @eval("return $a;");
        $valueB = @eval("return $b;"); 

        if($valueA == $valueB) return $a <=> $b;
        else return $valueA <=> $valueB;
    });
    
    $solution = implode("+", array_merge($terms["+"]["int"], $terms["+"]["exp"]));

    if(count($terms["-"]["int"]) + count($terms["-"]["exp"]) > 0) {
        //Sort Substraction integers
        sort($terms["-"]["int"]);
        //Sort Substraction expressions
        usort($terms["-"]["exp"], function($a, $b) {
            return eval("return $a;") <=> eval("return $b;");
        });

        $solution .= "-" . implode("-", array_merge($terms["-"]["int"], $terms["-"]["exp"]));
    }

    //error_log(var_export("end solution is $solution", true));

    return $solution;
}

$start = microtime(1);

$numbers = explode(" ", trim(fgets(STDIN)));

//Generate all the permutations with the list of numbers
function generatePermutations(array $numbers, array $permutation, array &$permutations): void {
    if(count($numbers) == 0) {
        $permutations[implode("-", $permutation)] = $permutation; //We don't need duplicate permutations
        return;
    }

    foreach($numbers as $i => $number) {
        $permutation[] = $number;
        unset($numbers[$i]);
        generatePermutations($numbers, $permutation, $permutations);

        $numbers[$i] = $number;
        array_pop($permutation);
    }
}

$solutions = [];
$permutations = [];
generatePermutations($numbers, [], $permutations);

foreach($permutations as [$n1, $n2, $n3, $n4]) {
    foreach(OPERATIONS as $op1) {
        foreach(OPERATIONS as $op2) {
            foreach(OPERATIONS as $op3) {
                //1-2-3
                if(round(@eval("return (($n1 $op1 $n2) $op2 $n3) $op3 $n4;"), 4) == 24) $solutions[] = "(($n1 $op1 $n2) $op2 $n3) $op3 $n4";
                //1-3-2
                if(round(@eval("return ($n1 $op1 $n2) $op2 ($n3 $op3 $n4);"), 4) == 24) $solutions[] = "($n1 $op1 $n2) $op2 ($n3 $op3 $n4)";
                //2-1-3
                if(round(@eval("return ($n1 $op1 ($n2 $op2 $n3)) $op3 $n4;"), 4) == 24) $solutions[] = "($n1 $op1 ($n2 $op2 $n3)) $op3 $n4";
                //2-3-1
                if(round(@eval("return $n1 $op1 (($n2 $op2 $n3) $op3 $n4);"), 4) == 24) $solutions[] = "$n1 $op1 (($n2 $op2 $n3) $op3 $n4)";
                //3-2-1
                if(round(@eval("return $n1 $op1 ($n2 $op2 ($n3 $op3 $n4));"), 4) == 24) $solutions[] = "$n1 $op1 ($n2 $op2 ($n3 $op3 $n4))";
            }
        }
    }
}

if(count($solutions) == 0) exit("not possible");

$solutionsTemp = [];

foreach($solutions as $solution) {

    $solution = preg_replace("/\s/", "", $solution); //Remove spaces

    //error_log("start: $solution");

    do {
        $changeMade = false;

        //Remove unnecessary parentheses:
        $opening = [];

        foreach(str_split($solution) as $i => $c) {
            if($c === "(") $opening[] = $i;
            elseif($c === ")") {
                $begin = array_pop($opening);
    
                //error_log("found parant $begin $i");
    
                $updated = substr($solution, 0, $begin) . substr($solution, $begin + 1, $i - $begin - 1) . substr($solution, $i + 1);
    
                //error_log("updated: $updated");
    
                if(@eval("return $updated;") == 24) {
                    //error_log("parant are useless $updated");
    
                    $solution = $updated;

                    $changeMade = true;
                    break;
                } //else error_log("keeping: $solution over $updated");
            }
        }

        //error_log("start: $solution");

        if($solution == "48/(2*(4-3))") error_log("!!!!!!!!!!!!!!start: $solution");

        //Rewrite expression with substraction
        if(preg_match("/(.*\-)\((.*)\)((?:\+|\-|\)|$).*)/", $solution, $matches)) {
            //error_log(var_export($matches, true));

            $terms = preg_split("/([\+\-])/", $matches[2], -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

            //error_log(var_export($elements, true));

            foreach($terms as &$term) $term = strtr($term, ["+" => "-", "-" => "+"]);

            $solution = $matches[1] . implode("", $terms) . $matches[3];

            $changeMade = true;
        }

        //Rewrite expression with division

      
        if(preg_match("/(.*)\/\(([0-9]+|\(.*\))\/([0-9]+|\(.*\))\)(.*)/", $solution, $matches)) {
            //error_log(var_export($solution, true));
            //error_log(var_export($matches, true));

            $solution = $matches[1] . "*" . $matches[3] . "/" . $matches[2] . $matches[4];

            $changeMade = true;

            //error_log(var_export($solution, true));

            if(eval("return $solution;") != 24) error_log("!!!!!!!!!!!!!!!!");
        }

        //A/(B/C/D) => A*C*D/B
        if(preg_match("/([0-9]+)\/\(([0-9]+)\/([0-9]+)\/([0-9]+)\)/", $solution, $matches)) {
            //error_log(var_export($solution, true));
            //error_log(var_export($matches, true));

            $solution = $matches[1] . "*" . $matches[4] . "*" . $matches[3] . "/" . $matches[2];

            $changeMade = true;
        }

        //A/(B*C) => A/B/C
        if(preg_match("/(.*[0-9]+)\/\(([0-9]+|\(.*\))\*([0-9]+|\(.*\))\)(.*)/", $solution, $matches)) {
            //error_log(var_export($solution, true));
            //error_log(var_export($matches, true));

            $solution = $matches[1] . "/" . $matches[2] . "/" . $matches[3] . $matches[4];

            $changeMade = true;
        }

        //error_log("$solution");

        $sorted = sortSolution($solution);

        if($sorted != $solution) {
            $solution = $sorted;
            $changeMade = true;
        }
    


    } while($changeMade);

    $solutionsTemp[$solution] = 1;
}

$solutions = $solutionsTemp;

uksort($solutions, function($a, $b) {
    $countA = substr_count($a, "(");
    $countB = substr_count($b, "(");

    if($countA == $countB) return $a <=> $b;
    else return $countA <=> $countB;
});

error_log(var_export($solutions, true));

echo count($solutions) . PHP_EOL;

foreach($solutions as $solution => $filler) echo $solution . PHP_EOL;

error_log(microtime(1) - $start);
