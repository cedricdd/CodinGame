<?php

function getTile(string $name): array {
    preg_match("/([0-9]{0,2})([BGRYJ])/", $name, $array);

    $tile["name"]  = $name;
    $tile["value"] = $array[1];
    $tile["color"] = $array[2];

    return $tile;
}

$start = microtime(1);

$goaltile = getTile(trim(fgets(STDIN)));
$history = [];
$table = [];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $row = explode(" ", trim(fgets(STDIN)));

    $rowID = array_shift($row);
    $tiles = [];
    $colors = [];
    
    foreach($row as $name) {
        $tile = getTile($name);
        
        $colors[$tile["color"]] = 1;
        $tiles[] = $tile;
    }

    //It's a run
    if(count($colors) == 1) $table[$rowID] = ["type" => "run", "color" => array_key_first($colors), "min" => array_shift($tiles)["value"], "max" => array_pop($tiles)["value"], "display" => implode(" ", $row)];
    //It's a set
    else $table[$rowID] = ["type" => "set", "value" => $tiles[0]["value"], "colors" => $colors, "display" => implode(" ", $row)];
}

$toCheck = [[$table, [$goaltile], [], array_key_last($table) + 1]];

while(count($toCheck)) {
    $newCheck = [];

    foreach($toCheck as [$table, $tiles, $actions, $nextRowID]) {

        $hash = implode("-", array_column($table, "display"));

        //No need to re-test a table we already checked
        if(isset($history[$hash])) continue;
        else $history[$hash] = 1;

        //We managed to place all the tiles
        if(count($tiles) == 0) {
            echo implode(PHP_EOL, $actions) . PHP_EOL;

            foreach($table as $rowID => $row) echo $rowID . " " . $row["display"] . PHP_EOL;

            break 2;
        }

        //Try to add the tile directly
        $tile = array_pop($tiles);

        foreach($table as $rowID => $row) {

            if($row["type"] == "run" && $row["color"] == $tile["color"]) {
                //We can insert the tile at the start
                if($row["min"] == $tile["value"] + 1) {
                    $tableUpdated = $table;
                    $tableUpdated[$rowID]["min"]--;
                    $tableUpdated[$rowID]["display"] = $tile["name"] . " " . $row["display"];

                    $newCheck[] = [$tableUpdated, $tiles, array_merge($actions, ["PUT " . $tile["name"] . " " . $rowID]), $nextRowID];
                }
                //We can insert the tile at the end
                if($row["max"] == $tile["value"] - 1) {
                    $tableUpdated = $table;
                    $tableUpdated[$rowID]["max"]++;
                    $tableUpdated[$rowID]["display"] = $row["display"] . " " . $tile["name"];

                    $newCheck[] = [$tableUpdated, $tiles, array_merge($actions, ["PUT " . $tile["name"] . " " . $rowID]), $nextRowID];
                }
                //We can insert in the middle of the run
                if($tile["value"] - $row["min"] >= 2 && $row["max"] - $tile["value"] >= 2) {
                    $tableUpdated = $table;

                    preg_match_all("/ /", $row["display"], $matches, PREG_OFFSET_CAPTURE);

                    $tableUpdated[$nextRowID++] = ["type" => "run", "color" => $tile["color"], "min" => $tile["value"], "max" => $row["max"], "display" => substr($row["display"], $matches[0][$tile["value"] - $row["min"] - 1][1] + 1)];

                    $tableUpdated[$rowID]["max"] = $tile["value"];
                    $tableUpdated[$rowID]["display"] = substr($row["display"], 0, $matches[0][$tile["value"] - $row["min"]][1]);

                    $newCheck[] = [$tableUpdated, $tiles, array_merge($actions, ["PUT " . $tile["name"] . " " . $rowID]), $nextRowID];
                }
            }
            //We can insert the tile in the set
            if($row["type"] == "set" && $row["value"] == $tile["value"] && !isset($row["colors"][$tile["color"]])) {
                $tableUpdated = $table;
                $tableUpdated[$rowID]["colors"][$tile["color"]] = 1;
                $tableUpdated[$rowID]["display"] = $tile["value"] . "B " . $tile["value"] . "G " . $tile["value"] . "R " . $tile["value"] . "Y";

                $newCheck[] = [$tableUpdated, $tiles, array_merge($actions, ["PUT " . $tile["name"] . " " . $rowID]), $nextRowID];
            }
        }

        $tiles[] = $tile;

        //Try to combine
        foreach($table as $rowID1 => $row1) {
            if($row1["type"] == "set") continue;

            foreach($table as $rowID2 => $row2) {
                if($row2["type"] == "set" || $row1["color"] != $row2["color"]) continue;

                //We can combine at the start
                if($row1["min"] == $row2["max"] + 1) {
                    $tableUpdated = $table;
                    $tableUpdated[$rowID1]["min"] = $row2["min"];
                    $tableUpdated[$rowID1]["display"] = $row2["display"] . " " . $row1["display"];

                    unset($tableUpdated[$rowID2]);
    
                    $newCheck[] = [$tableUpdated, $tiles, array_merge($actions, ["COMBINE $rowID1 $rowID2"]), $nextRowID]; 
                }

                //We can combine at the start
                if($row1["max"] == $row2["min"] - 1) {
                    $tableUpdated = $table;
                    $tableUpdated[$rowID1]["max"] = $row2["max"];
                    $tableUpdated[$rowID1]["display"] = $row1["display"] . " " . $row2["display"];

                    unset($tableUpdated[$rowID2]);
    
                    $newCheck[] = [$tableUpdated, $tiles, array_merge($actions, ["COMBINE $rowID1 $rowID2"]), $nextRowID]; 
                }
            }
        }

        //We can take another tile
        if(count($tiles) < 2) {

            foreach($table as $rowID => $row) {
                //If a set is full we can take any tile
                if($row["type"] == "set" && count($row["colors"]) == 4) {
                    foreach(['B', 'G', 'R', 'Y'] as $color) {
                        $tile = getTile($row["value"] . $color);

                        $tableUpdated = $table;
                        unset($tableUpdated[$rowID]["colors"][$color]);
                        $tableUpdated[$rowID]["display"] = trim(preg_replace("/\s{2,}/", " ", str_replace($tile["name"], "", $tableUpdated[$rowID]["display"])));

                        $newCheck[] = [$tableUpdated, array_merge($tiles, [$tile]), array_merge($actions, ["TAKE " . $tile["name"] . " " . $rowID]), $nextRowID];
                    }
                }

                if($row["type"] == "run" && $row["max"] - $row["min"] >= 3) {
                    //We take the first tile
                    $tile = getTile($row["min"] . $row["color"]);

                    $tableUpdated = $table;
                    $tableUpdated[$rowID]["min"]++;
                    $tableUpdated[$rowID]["display"] = substr($tableUpdated[$rowID]["display"], strpos($tableUpdated[$rowID]["display"], " ") + 1);

                    $newCheck[] = [$tableUpdated, array_merge($tiles, [$tile]), array_merge($actions, ["TAKE " . $tile["name"] . " " . $rowID]), $nextRowID];

                    //We take the last tile
                    $tile = getTile($row["max"] . $row["color"]);

                    $tableUpdated = $table;
                    $tableUpdated[$rowID]["max"]--;
                    $tableUpdated[$rowID]["display"] = substr($tableUpdated[$rowID]["display"], 0, strrpos($tableUpdated[$rowID]["display"], " "));

                    $newCheck[] = [$tableUpdated, array_merge($tiles, [$tile]), array_merge($actions, ["TAKE " . $tile["name"] . " " . $rowID]), $nextRowID];

                }

                //We can take tiles by splitting the run
                if($row["type"] == "run" && $row["max"] - $row["min"] >= 6) {
                    for($i = $row["min"] + 3; $i <= $row["max"] - 3; ++$i) {
                        $tile = getTile($i . $row["color"]);

                        $tableUpdated = $table;

                        preg_match_all("/ /", $row["display"], $matches, PREG_OFFSET_CAPTURE);
    
                        $tableUpdated[$nextRowID++] = ["type" => "run", "color" => $tile["color"], "min" => $i + 1, "max" => $row["max"], "display" => substr($row["display"], $matches[0][$i - $row["min"]][1] + 1)];
    
                        $tableUpdated[$rowID]["max"] = $i - 1;
                        $tableUpdated[$rowID]["display"] = substr($row["display"], 0, $matches[0][$i - $row["min"] - 1][1]);
    
                        $newCheck[] = [$tableUpdated, array_merge($tiles, [$tile]), array_merge($actions, ["TAKE " . $tile["name"] . " " . $rowID]), $nextRowID];
                    }
                }
            }

        }
    }

    $toCheck = $newCheck;
}

error_log(microtime(1) - $start);
