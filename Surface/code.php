<?php
/**
 * Auto-generated code below aims at helping you parse
 * the standard input according to the problem statement.
 **/

fscanf(STDIN, "%d", $L);
fscanf(STDIN, "%d", $H);

for ($y = 0; $y < $H; $y++) $map[] = stream_get_line(STDIN, $L + 1, "\n");

$lakeId = 0;
$lakes = [];
$calculated = [];

fscanf(STDIN, "%d", $N);
for ($i = 0; $i < $N; $i++) {
    fscanf(STDIN, "%d %d", $px, $py);

    //We are on land, no lake
    if($map[$py][$px] == "#") {
        echo "0\n";
        continue;
    }
    //We haven't found how big the lake is yet
    if(!isset($calculated[$px . " " . $py])) {
        $toCheck = [[$px, $py]];

        $count = 0;
        $lakes[$lakeId] = 0;

        //Simple flood fill
        while(count($toCheck)) {
            list($x, $y) = array_pop($toCheck);

            //Out of the map
            if($x < 0 || $x >= $L || $y < 0 || $y >= $H) continue;

            //Found another part of the lake
            if($map[$y][$x] == "O") {
                ++$lakes[$lakeId];
                $calculated[$x . " " . $y] = $lakeId;

                $map[$y][$x] = "X";

                $toCheck[] = [$x, $y - 1];
                $toCheck[] = [$x - 1, $y];
                $toCheck[] = [$x, $y + 1];
                $toCheck[] = [$x + 1, $y];
            }
        }

        ++$lakeId;
    }

    echo $lakes[$calculated[$px . " " . $py]] . "\n";
}
?>
