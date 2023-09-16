<?php

const FREQ = ["A2" => 110.0000, "A4" => 440.0000, "B3" => 246.9417, "C4" => 261.6256, "D3" => 146.8324, "E2" => 82.4069, "E4" => 329.6276, "G3" => 195.9977, "G4" => 391.9954];
const STRINGS = [
    "guitar"  => ["E4", "B3", "G3", "D3", "A2", "E2"],
    "ukulele" => ["A4", "E4", "C4", "G4"],
];
const STEP = 1.05946309436; //2^(1/12);

$mode = stream_get_line(STDIN, 7 + 1, "\n");

for ($i = trim(fgets(STDIN)); $i > 0; --$i) {
    fscanf(STDIN, "%d %d", $string, $fret);

    //The frequence of the note we want to play
    $frequency = number_format(FREQ[STRINGS[$mode][$string]] * pow(STEP, $fret), 3, ".", "");

    //We want to play on a ukulele
    if($mode == "guitar") {
        $frets = 15;
        $strings = STRINGS["ukulele"];
    } //We want to play on a guitar
    else {
        $frets = 21;
        $strings = STRINGS["guitar"];
    }

    $answer = [];

    foreach($strings as $index => $string) {
        $base = FREQ[$string];
        $max = number_format($base * pow(STEP, $frets), 3, ".", "");;

        //We can't play the note on this string
        if($frequency < $base || $frequency > $max) continue;
        else $answer[] = $index . "/" . round(log($frequency / $base) / log(STEP));
    }

    if(count($answer) > 0) echo implode(" ", $answer) . PHP_EOL;
    else echo "no match" . PHP_EOL;
}
