<?php

function operation(array $match): array {
    $left = parse($match[1]);
    $right = parse($match[3]);
    $result = [];

    foreach($left as $vl => $pl) {
        foreach($right as $vr => $pr) {
            switch($match[2]) {
                case "+": $result[$vl + $vr] = ($result[$vl + $vr] ?? 0.0) + ($pl * $pr); break;
                case "-": $result[$vl - $vr] = ($result[$vl - $vr] ?? 0.0) + ($pl * $pr); break;
                case "*": $result[$vl * $vr] = ($result[$vl * $vr] ?? 0.0) + ($pl * $pr); break;
                case ">": $result[$vl > $vr] = ($result[$vl > $vr] ?? 0.0) + ($pl * $pr); break;
            } 
        }
    }

    return $result;
}

function parse(string $S): array {
    global $saved, $index;

    //Parentheses, highest priority
    if(preg_match("/\(([^\(\)]*)\)/", $S, $match)) {
        $saved[$index] = parse($match[1]);

        return parse(str_replace($match[0], "#" . $index++, $S));
    }
    //Multiplication, second highest priority
    if(preg_match("/((?:d|\#)?\d+)(\*)((?:d|\#)?\d+)/", $S, $match)) {
        $saved[$index] = operation($match);

        return parse(str_replace($match[0], "#" . $index++, $S));
    }
    //Addition/Subtraction, third highest priority
    if(preg_match("/((?:d|\#)?\d+)([+-])((?:d|\#)?\d+)/", $S, $match)) {
        $saved[$index] = operation($match);

        return parse(str_replace($match[0], "#" . $index++, $S));
    }
    //Comparison, lowest priority
    if(preg_match("/((?:d|\#)?\d+)(\>)((?:d|\#)?\d+)/", $S, $match)) {
        $saved[$index] = operation($match);

        return parse(str_replace($match[0], "#" . $index++, $S));
    }
    //Dice
    if(preg_match("/^d(\d+)$/", $S, $match)) {
        $value = intval($match[1]);

        return array_combine(range(1, $value), array_fill(0, $value, 1 / $value));
    }
    //Saved results, previously computed
    if(preg_match("/^\#(\d+)$/", $S, $match)) return $saved[intval($match[1])];
    //Simple integer
    if(is_numeric($S)) return [intval($S) => 1];
}

$saved = [];
$index = 0;
$results = parse(trim(fgets(STDIN)));

//Outcomes are sorted in ascending order.
ksort($results);

foreach($results as $value => $probability) {
    echo $value . " " . number_format($probability * 100, 2) . PHP_EOL;
}
?>
