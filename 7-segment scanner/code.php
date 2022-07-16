<?php

$numbers = [
    " _ | ||_|" => 0, "     |  |" => 1, " _  _||_ " => 2, " _  _| _|" => 3, "   |_|  |" => 4,
    " _ |_  _|" => 5, " _ |_ |_|" => 6, " _   |  |" => 7, " _ |_||_|" => 8, " _ |_| _|" => 9,
];

$line1 = stream_get_line(STDIN, 900 + 1, "\n");
$line2 = stream_get_line(STDIN, 900 + 1, "\n");
$line3 = stream_get_line(STDIN, 900 + 1, "\n");

for($i = 0; $i < strlen($line1); $i += 3) {
    echo $numbers[substr($line1, $i, 3) . substr($line2, $i, 3) . substr($line3, $i, 3)];
}
?>
