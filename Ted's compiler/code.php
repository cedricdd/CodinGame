<?php
fscanf(STDIN, "%d", $V);
fscanf(STDIN, "%d", $N);

error_log(var_export($V . " " . $N, true));

for ($i = 0; $i < $N; $i++) {
    preg_match("/(.*) ([0-9]+)/", stream_get_line(STDIN, 500 + 1, "\n"), $matches);

    $products[] = $matches[2];
}

//Sort by most expensive to cheapest
rsort($products);

error_log(var_export($products, true));

$count = 0;

function searchSolution($index, $total) {

    global $products, $count, $V, $N;

    //We reached the voucher value
    if($total == $V) {
        ++$count;
        return;
    }

    //Sum is too much or no product left to add
    if($total > $V || $index == $N) return;

    //We add the product 0-3 times
    for($i = 0; $i < 4; ++$i) {
        searchSolution($index + 1, $total + ($products[$index] * $i));
    }

}

searchSolution(0, 0);

echo $count . "\n";
?>
