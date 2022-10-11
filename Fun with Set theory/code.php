<?php

function parse(string $input): array {

    //Parentheses
    if(preg_match("/\(([^\(\)]*)\)/", $input, $match)) {
        //We evaluate the expression inside the parantheses and replace it with the braces equivalent
        return parse(str_replace($match[0], "{" . implode(";", parse($match[1])) . "}", $input));
    }

    //Union, intersection or difference
    if(preg_match("/([\[\]{][-\d;]*[\[\]}])([UI\-])([\[\]{][-\d;]*[\[\]}])/", $input, $match)) {
        $left = parse($match[1]);
        $right = parse($match[3]);

        switch($match[2]) {
            case "U": $result = array_unique(array_merge($left, $right)); break;
            case "I": $result = array_intersect($left, $right); break;
            case "-": $result = array_diff($left, $right); break;
        }

        //We replace the operation with the braces equivalent
        return parse(str_replace($match[0], "{" . implode(";", $result) . "}", $input));
    }

    //Simple set of braces
    if(preg_match("/^{(.*)}$/", $input, $match)) {
        return explode(";", $match[1]);
    }

    //Simple set of brackets
    if(preg_match("/^([\[\]])(.+)([\[\]])$/", $input, $match)) {
        [$start, $end] = explode(";", $match[2]);

        if($match[1] == "]") ++$start; //Excluding start
        if($match[3] == "[") --$end; //Excluding end

        return range($start, $end);
    }

    return [];
}

$numbers = parse(trim(fgets(STDIN)));

//Empty set
if($numbers[0] === '') echo "EMPTY" . PHP_EOL;
//Print the numbers ordered
else {
    sort($numbers);
    echo implode(" ", $numbers) . PHP_EOL;
}
?>
