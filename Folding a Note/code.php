<?php

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    $paper[0][] = stream_get_line(STDIN, $N + 1, "\n");
}

$turn = 0;

//Until we have one letter per fold
while(count($paper[0]) != 1) {

    $newPaper = [];
    $index = 0;

    //From right to left
    if($turn % 4 == 0) {
        $half = strlen($paper[0][0]) >> 1;

        //We start with the second half in reverse from bottom to top
        foreach(array_reverse($paper) as $fold) {
            foreach($fold as $string) $newPaper[$index][] = strrev(substr($string, $half));

            ++$index; //Finished with this fold
        }

        //The first half from top to bottom
        foreach($paper as $fold) {
            foreach($fold as $string) $newPaper[$index][] = substr($string, 0, $half);

            ++$index; //Finished with this fold
        }
    } //From bottom to top
    elseif($turn % 4 == 1) {
        $half = count($paper[0]) >> 1;

        //We start the second half in reverse from bottom to top
        foreach(array_reverse($paper) as $fold) {
            for($i = count($fold) - 1; $i >= $half; --$i) $newPaper[$index][] = $fold[$i];

            ++$index; //Finished with this fold
        }

        //The frist half from top to bottom
        foreach($paper as $fold) $newPaper[] = array_slice($fold, 0, $half);
    } //From left to right
    elseif($turn % 4 == 2) {
        $half = strlen($paper[0][0]) >> 1;

        //We start with the first half in reverse from bottom to top
        foreach(array_reverse($paper) as $fold) {
            foreach($fold as $string) $newPaper[$index][] = strrev(substr($string, 0, $half));

            ++$index; //Finished with this fold
        }

        //The second half from top to bottom
        foreach($paper as $fold) {
            foreach($fold as $string) $newPaper[$index][] = substr($string, $half);

            ++$index; //Finished with this fold
        }
    } //From top to bottom
    elseif($turn % 4 == 3) {
        $half = count($paper[0]) >> 1;

         //We start with the first half in reverse from bottom to top
        foreach(array_reverse($paper) as $fold) {
            for($i = $half - 1; $i >= 0; --$i) $newPaper[$index][] = $fold[$i];

            ++$index; //Finished with this fold
        }

        //The second half from top to bottom
        foreach($paper as $fold) $newPaper[] = array_slice($fold, $half);
    }

    $paper = $newPaper;
    ++$turn;
}

echo implode("", array_map("implode", $paper)) . PHP_EOL;
