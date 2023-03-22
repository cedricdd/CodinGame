<?php

fscanf(STDIN, "%d %d", $numGood, $numBad);

$goodNoun = array_flip(explode(" ", trim(fgets(STDIN))));
$badNoun = array_flip(explode(" ", trim(fgets(STDIN))));
$noums = implode("|", array_filter(array_keys($goodNoun + $badNoun)));

fscanf(STDIN, "%d", $numLines);


function getValue(string $speaker, string $statement): int {
    global $goodNoun, $noums, $context, $stack;

    //{constant} and {constant} too => (a + b)
    if(preg_match("/(.*)\sand\s(.*)\stoo\b(?!.*\b(?:too|though|by|squared)\b)/i", $statement, $matches)) 
        $value = getValue($speaker, $matches[1]) + getValue($speaker, $matches[2]);
    //{constant} but not {constant} though => (a - b)
    elseif(preg_match("/(.*)\sbut not\s(.*?)\bthough\b(?!.*\b(?:too|though|by|squared)\b)/i", $statement, $matches))
        $value = getValue($speaker, $matches[1]) - getValue($speaker, $matches[2]);
    //{constant} by {constant} multiplied => (a * b)
    elseif(preg_match("/(.*)\sby\s(?!.*\b(?:too|though|by|squared)\b)(.*)/i", $statement, $matches))
        $value = getValue($speaker, $matches[1]) * getValue($speaker, $matches[2]);
    //{constant} squared
    elseif(preg_match("/(.*)\ssquared\b(?!.*\b(?:too|though|by|squared)\b)/i", $statement, $matches))
        $value = getValue($speaker, $matches[1]) * getValue($speaker, $matches[1]);
    //"me" => the speaker's stack
    elseif(preg_match("/\bme\b/i", $statement)) $value = end($stack[$speaker]);
    //"you", "u" => the context's stack
    elseif(preg_match("/\b(you|u)\b/i", $statement)) $value = end($stack[$context[$speaker]]);
    //*{nick}* => nick's stack 
    elseif(preg_match("/\*(.+)\*/", $statement, $matches)) $value = end($stack[$matches[1]]);
    //Constants 
    else {
        preg_match("/\b(?:a|an)\s(.*\b(?:". $noums . "))\b/i", $statement, $matches);

        $exploded = preg_split("/\s/", $matches[1], -1, PREG_SPLIT_NO_EMPTY);
        $value = (isset($goodNoun[array_pop($exploded)]) ? 1 : -1) * (2 ** count($exploded));
    }

    return $value;
}

function parse(string $speaker, string $statement): string {
    global $goodNoun, $noums, $context, $stack;

    if(empty($statement)) return "";

    //Context change occurs as the first word
    if(preg_match("/^\*([^\*]+)\*/", $statement, $matches, PREG_OFFSET_CAPTURE)) {
        [$name, $position] = $matches[1];

        $context[$speaker] = $name;

        return parse($speaker, substr($statement, $position + strlen($name) + 1));
    } //ASSIGNMENT COMMAND
    elseif(isset($context[$speaker]) && preg_match("/(?:youre|your|ur)\s(.*)/i", $statement, $matches))
        $stack[$context[$speaker]][] = getValue($speaker, $matches[1]);
    //OUTPUT COMMAND
    elseif(preg_match("/\b(tell|telling)\b/i", $statement)) return array_pop($stack[$context[$speaker]]);
    //Duplicate the top value of the context's stack
    elseif(preg_match("/\blisten\b/i", $statement)) 
        array_push($stack[$context[$speaker]], end($stack[$context[$speaker]]));
    //Exchange the top two values of the context's stack
    elseif(preg_match("/\bflip\b/i", $statement)) 
        array_push($stack[$context[$speaker]], array_pop($stack[$context[$speaker]]), array_pop($stack[$context[$speaker]]));
    //Pop the top value off the context's stack
    elseif(preg_match("/\bforget\b/i", $statement))
        array_pop($stack[$context[$speaker]]);
    //SET CONTEXT COMMAND
    elseif(preg_match("/\*([^\*]+)\*/", $statement, $matches, PREG_OFFSET_CAPTURE)) {
        [$name, $position] = $matches[1];

        $context[$speaker] = $name;

        return parse($speaker, substr($statement, $position + strlen($name) + 1));
    }

    return "";
}

$answer = "";

for ($i = 0; $i < $numLines; $i++) {
    $line = trim(fgets(STDIN));

    preg_match("/<([^>]*)>\s+(.*)/", $line, $matches);

    [, $speaker, $statement] = $matches;

    if(substr_count($speaker, "_") > 1) continue; //No need to parse the hints

    $answer .= parse($speaker, preg_replace("/[^0-9a-zA-Z\s\*\_]/", "", $statement));
}

echo $answer . PHP_EOL;
