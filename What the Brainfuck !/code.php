<?php

fscanf(STDIN, "%d %d %d", $L, $S, $N);

$array = array_fill(0, $S, 0);

$program = "";
$result = "";

$jumps = [];
$values = [];

$index = 0;
$indexValue = -1;

for ($i = 0; $i < $L; $i++) {
    //Save the program as a single line & remove un-used characters
    $program .= preg_replace("/[^\<\>\+\-\.\,\[\]]/", "", stream_get_line(STDIN, 1024 + 1, "\n"));
}
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d", $values[]);
}

//Find the positions of the jumping characters
$jumpsSeach = $program;
while(preg_match("/\[[^\[\]]*\]/", $jumpsSeach, $match, PREG_OFFSET_CAPTURE)) {
    error_log(var_export($match, true));

    $start = $match[0][1];
    $end = $start + strlen($match[0][0]) - 1;

    $jumps[$start] = $end;
    $jumps[$end] = $start;
    
    $jumpsSeach[$start] = $jumpsSeach[$end] = "*";
}

//There's a [ or a ] that doesn't a matching character
if(strpos($jumpsSeach, "[") !== false || strpos($jumpsSeach, "]") !== false) die("SYNTAX ERROR");

for ($i = 0; $i < strlen($program); $i++) {
    switch($program[$i]) {
        case ',';
            $array[$index] = $values[++$indexValue];
            break;
        case '>':
            ++$index;
            if($index > ($S - 1)) die("POINTER OUT OF BOUNDS");
            break;
        case '<':
            --$index;
            if($index < 0) die("POINTER OUT OF BOUNDS");
            break;
        case '+':
            $array[$index]++;
            if($array[$index] > 255) die("INCORRECT VALUE");
            break;
        case '-':
            $array[$index]--;
            if($array[$index] < 0) die("INCORRECT VALUE");
            break;
        case '.':
            $result .= chr($array[$index]);
            break;
        case '[':
            if($array[$index] == 0) $i = $jumps[$i];
            break;
        case ']':
            if($array[$index] != 0) $i = $jumps[$i];
            break;
    }
}

echo $result . PHP_EOL;
?>
