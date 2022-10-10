<?php

fscanf(STDIN, "%d", $delta);
$gene = trim(fgets(STDIN));

fscanf(STDIN, "%d", $n);
for ($s = 0; $s < $n; $s++) {
    $sequence = trim(fgets(STDIN));

    //Gene can only overflow at the end
    for($i = 0; $i <= strlen($sequence) - strlen($gene) + $delta; ++$i) {
        $differences = 0;

        for($j = 0; $j < strlen($gene); ++$j) {
            //Mismatch gene/sequence or overflow
            if(($differences += (($i + $j >= strlen($sequence) || $sequence[$i + $j] != $gene[$j]) ? 1 : 0)) > $delta) break;
        }

        //Gene has been found
        if($differences <= $delta) die("$s $i $differences");
    }
}

echo "NONE" . PHP_EOL;
?>
