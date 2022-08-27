<?php

 const BENFORD = [0, 30.1, 17.6, 12.5,  9.7, 7.9, 6.7, 5.8, 5.1, 4.6];
 $results = array_fill(0, 10, 0);

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    preg_match("/[1-9]/", stream_get_line(STDIN, 32 + 1, "\n"), $match);
    ++$results[$match[0]];
}

for($i = 1; $i < 10; ++$i) {
    $percentage = $results[$i] / $N * 100;
    if($percentage < max(0, BENFORD[$i] - 10) || $percentage > BENFORD[$i] + 10) {
        echo "true\n";
        exit();
    }
}

echo("false\n");
?>
