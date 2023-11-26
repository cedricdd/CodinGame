<?php

$start = microtime(1);

class Tile {
    public $value;
    public $color;

    public function __construct(string $tile) {
        preg_match("/([0-9]+)([BGRY])/", $tile, $array);

        $this->value = $array[1];
        $this->color = $array[2];
    }

    public function getName(): string {
        return $this->value . $this->color;
    }
}

abstract class Row {
    protected $tiles;
    protected $count;
    protected $joker;
    public $display;
    public $type;
}

class Set extends Row {
    private $colors;
    private $value;

    public function __construct(array $tiles) {
        $this->type = "set";
        $this->colors = [];
        $this->count = count($tiles);

        foreach($tiles as $tile) {
            $this->value = $tile->value;
            $this->tiles[$tile->getName()] = $tile;
            $this->colors[$tile->color] = 1;
        }

        $this->updateDisplay();
    }

    private function updateDisplay() {
        $output = [];

        foreach(['B', 'G', 'R', 'Y'] as $color) {
            if(isset($this->colors[$color])) $output[] = $this->value . $color;
        }
        
        $this->display = implode(" ", $output);
    }

    public function canInsert(Tile $tile): bool {
        return !isset($this->colors[$tile->color]) && $tile->value == $this->value;
    }

    public function couldInsert(Tile $tile): array {
        return [];
    }

    public function insert(Tile $tile) {
        $this->colors[$tile->color] = 1;
        $this->tiles[$tile->getName()] = $tile;

        $this->count++;

        $this->updateDisplay();
    }

    public function canTake(Tile $tile): bool {
        if($this->count == 4 && $this->value == $tile->value) return true;

        return false;
    }

    public function couldTake(Tile $tile): array {
        if($this->value == $tile->value && isset($this->colors[$tile->color])) {
            foreach(['B', 'G', 'R', 'Y'] as $color) {
                if(!isset($this->colors[$color])) return [["find", [new Tile($tile->value . $color)]]];
            }
        }

        return [];
    }

    public function remove(Tile $tile) {
        unset($this->colors[$tile->color]);
        unset($this->tiles[$tile->getName()]);

        $this->count--;

        $this->updateDisplay();
    }
}

class Run extends Row {
    public $min;
    public $max;
    public $color;

    public function __construct(array $tiles) {
        $this->type = "run";
        $this->min = INF;
        $this->max = -INF;
        $this->count = count($tiles);

        foreach($tiles as $tile) {
            $this->tiles[] = $tile;
            $this->color = $tile->color;
            $this->min = min($this->min, $tile->value);
            $this->max = max($this->max, $tile->value);
        }

        $this->updateDisplay();
    }

    public function updateDisplay() {
        $output = [];

        for($i = $this->min; $i <= $this->max; ++$i) $output[] = $i . $this->color;

        $this->display = implode(" ", $output);
    }

    public function canInsert(Tile $tile): bool {
        if($this->color == $tile->color) {
            //Adding at the start
            if($this->min - 1 == $tile->value) return true;
            //Adding at the end
            if($this->max + 1 == $tile->value) return true;
            //Adding in the middle and splitting the run
            if($this->count >= 5 && $tile->value >= $this->min + 2 && $tile->value <= $this->max - 2) return true;
        } 

        return false;
    }

    public function couldInsert(Tile $tile): array {
        if($this->color != $tile->color) return [];

        $tiles = [];

        if($tile->value < $this->min) {
            for($i = $this->min - 1; $i > $tile->value; --$i) {
                $tiles[] = new Tile($i . $tile->color);
            }
        } elseif($tile->value > $this->max) {
            for($i = $this->max + 1; $i < $tile->value; ++$i) {
                $tiles[] = new Tile($i . $tile->color);
            }
        } else {
            if($this->min > $tile->value - 1) $tiles[] = new Tile($tile->value - 1 . $tile->color);
            if($this->min > $tile->value - 2) $tiles[] = new Tile($tile->value - 2 . $tile->color);
            if($this->max < $tile->value + 1) $tiles[] = new Tile($tile->value + 1 . $tile->color);
            if($this->max < $tile->value + 2) $tiles[] = new Tile($tile->value + 2 . $tile->color);
        }

        return $tiles;
    }

    public function insertStart(Tile $tile) {
        $this->count++;
        $this->min--;

        array_unshift($this->tiles, $tile);

        $this->updateDisplay();
    }

    public function insertEnd(Tile $tile) {
        $this->count++;
        $this->max++;

        array_push($this->tiles, $tile);

        $this->updateDisplay();
    }

    public function removeStart(): Tile {
        $this->min++;
        $this->count--;

        $tile = array_shift($this->tiles);

        $this->updateDisplay();

        return $tile;
    }

    public function removeLast(): Tile {
        $this->max--;
        $this->count--;

        $tile = array_pop($this->tiles);

        $this->updateDisplay();

        return $tile;
    }

    public function getTiles(): array {
        return $this->tiles;
    }

    public function canTake(Tile $tile): bool {
        //If the tile is the first or last
        if($this->count >= 4 && $this->color == $tile->color && ($tile->value == $this->min || $tile->value == $this->max)) return true;
        //If we can take by splitting
        if($this->count >= 7 && $this->color == $tile->color && $tile->value - 3 >= $this->min && $tile->value + 3 <= $this->max) return true;

        return false;
    }

    public function couldTake(Tile $tile): array {
        if($this->color != $tile->color) return [];

        $tiles = [];

        //The tile is currently the min -- it means we currently have 3 tiles otherwise it could have been taken directly, we just need to add one at the end
        if($tile->value == $this->min && $this->max != 13) $tiles[] = ["find", [new Tile($this->max + 1 . $this->color)]];

        //The tile is currently the max -- it means we currently have 3 tiles otherwise it could have been taken directly, we just need to add one at the start
        if($tile->value == $this->max && $this->min != 1) $tiles[] = ["find", [new Tile($this->min - 1 . $this->color)]];

        //The tile is inside
        if($this->min < $tile->value && $this->max > $tile->value) {
            //Can we remove everything left and still have a valid run
            if($this->max - $tile->value >= 3) {
                $tilesToRemove = [];

                for($i = $this->min; $i < $tile->value; ++$i) $tilesToRemove[] = new Tile($i . $tile->color);

                $tiles[] = ["remove", $tilesToRemove];
            }

            //Can we remove everything right and still have a valid run
            if($tile->value - $this->min >= 3) {
                $tilesToRemove = [];

                for($i = $this->max; $i > $tile->value; --$i) $tilesToRemove[] = new Tile($i . $tile->color);

                $tiles[] = ["remove", $tilesToRemove];
            }
        }

        return $tiles;
    }
}

class Table {
    private $rows;
    private $nextRow;

    public function __construct(array $rows, array &$availableTiles) {
        foreach($rows as $row) {
            $rowID = array_shift($row);

            $colors = [];
            $tiles = [];

            foreach($row as $tileName) {
                $tile = new Tile($tileName);

                $tiles[] = $tile;
                $colors[$tile->color] = 1;

                $availableTiles[$tile->color][$tile->value]++;
            }

            $this->rows[$rowID] = count($colors) == 1 ? new Run($tiles) : new Set($tiles);
            $this->nextRow = $rowID + 1;
        }
    }

    public function __clone() {
        foreach ($this->rows as $k => $v) {
            $this->rows[$k] = clone $v;
        }
    }

    public function combine(int $r1, int $r2) {
        $row1 = $this->rows[$r1];
        $row2 = $this->rows[$r2];

        //r2 goes at the end of r1
        if($row1->max == $row2->min - 1) {
            foreach($row2->getTiles() as $tile) $row1->insertEnd($tile);
        } //r2 goes at the start of r1
        else {
            foreach(array_reverse($row2->getTiles()) as $tile) $row1->insertStart($tile);
        }

        unset($this->rows[$r2]);
    }

    public function getHash(): string {
        $hash = [];

        foreach($this->rows as $row) $hash[] = $row->display;

        return implode("-", $hash);
    }

    public function getRows(): array {
        return $this->rows;
    }

    public function outputRows() {
        ksort($this->rows);

        foreach($this->rows as $id => $row) echo $id . " " . $row->display . PHP_EOL;
    }

    public function insert(int $rowID, Tile $tile) {
        $row = $this->rows[$rowID];

        if($row->type == "set") $row->insert($tile);
        elseif($tile->value == $row->min - 1) $row->insertStart($tile);
        elseif($tile->value == $row->max + 1) $row->insertEnd($tile);
        //Splitting a run
        else {
            $tiles = [$tile];

            //Update the old row
            while($row->max > $tile->value) $tiles[] = $row->removeLast();

            //Create the new row
            $this->rows[$this->nextRow++] = new Run($tiles);
        }
    }

    public function remove(int $rowID, Tile $tile) {
        $row = $this->rows[$rowID];

        if($row->type == "set") $row->remove($tile);
        elseif($tile->value == $row->min) $row->removeStart();
        elseif($tile->value == $row->max) $row->removeLast();
        //Splitting a run
        else {
            $tiles = [];

            //Update the old row
            while($row->max >= $tile->value) $tiles[] = $row->removeLast();

            //Don't copy the stone we take to the new run
            array_pop($tiles);

            //Create the new row
            $this->rows[$this->nextRow++] = new Run($tiles);
        }
    }  
}

$goalTile = new Tile(trim(fgets(STDIN)));
$availableTiles = [
    'B' => array_fill(1, 13, 0),
    'G' => array_fill(1, 13, 0),
    'R' => array_fill(1, 13, 0),
    'Y' => array_fill(1, 13, 0),
];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $rows[] = explode(" ", trim(fgets(STDIN)));
}

$table = new Table($rows, $availableTiles);

//$combineActions = $table->combineRows();

//error_log(var_export($putstone, true));
//error_log(var_export($table, true));

function tryCombineTake($tableInitial, $tile): array {
    $series = [];

    foreach($tableInitial->getRows() as $rowID => $row) {
        //It's a set or not the right color
        if($row->type == "set" || $row->color != $tile->color) continue;

        //The tile is the first one but we can't directly take it because we only have 3 tiles in the row
        if($row->min == $tile->value) {
            error_log("we can try to combine row $rowID -- min");

            $tableCombine = clone $tableInitial;
            $actions = [];

            foreach($tableInitial->getRows() as $rowID2 => $row2) {
                //It's a set or not the right color
                if($row2->type == "set" || $row2->color != $row->color || $row->max != $row2->min -  1) continue;

                error_log("$rowID2 is good to combine at the end");

                if($rowID2 < $rowID) [$rowID, $rowID2] = [$rowID2, $rowID];

                //Combine the rows
                $tableCombine->combine($rowID, $rowID2);
                $actions[] = "COMBINE $rowID $rowID2";

                //We now have enough tiles to be able to remove the tile
                $tableCombine->remove($rowID, $tile);
                $actions[] = "TAKE " . $tile->getName() . " " . $rowID;

                $series[] = [$tableCombine, $actions];
            }
        } 
        //The tile is the last one but we can't directly take it because we only have 3 tiles in the row
        if($row->max == $tile->value) {
            error_log("we can try to combine row $rowID -- max");

            $tableCombine = clone $tableInitial;
            $actions = [];

            foreach($tableInitial->getRows() as $rowID2 => $row2) {
                //It's a set or not the right color
                if($row2->type == "set" || $row2->color != $row->color || $row->min != $row2->max +  1) continue;

                error_log("$rowID2 is good to combine at the start");

                if($rowID2 < $rowID) [$rowID, $rowID2] = [$rowID2, $rowID];

                //Combine the rows
                $tableCombine->combine($rowID, $rowID2);
                $actions[] = "COMBINE $rowID $rowID2";

                //We now have enough tiles to be able to remove the tile
                $tableCombine->remove($rowID, $tile);
                $actions[] = "TAKE " . $tile->getName() . " " . $rowID;

                $series[] = [$tableCombine, $actions];
            }
        }
        //The tile is inside the run, check if can combine to end up with enough of both side to take by creating a new run
        if($row->min < $tile->value && $tile->value < $row->max) {
            error_log("we can try to combine row $rowID -- middle");

            $tableCombine = clone $tableInitial;
            $actions = [];

            //There isn't enough on the left
            if($tile->value - $row->min < 3) {
                error_log("we need to combine on the start");

                $success = false;

                foreach($tableInitial->getRows() as $rowID2 => $row2) {
                    //It's a set or not the right color
                    if($row2->type == "set" || $row2->color != $row->color || $row2->max != $row->min -  1) continue;

                    error_log("$rowID2 is good to combine at the start");

                    if($rowID2 < $rowID) [$rowID, $rowID2] = [$rowID2, $rowID];

                    $tableCombine->combine($rowID, $rowID2);
                    $actions[] = "COMBINE $rowID $rowID2";

                    $success = true;

                    break;
                }

                if($success == false) continue;
            }

            //There isn't enough on the right
            if($row->max - $tile->value < 3) {
                error_log("we need to combine on the end");

                $success = false;

                foreach($tableInitial->getRows() as $rowID2 => $row2) {
                    //It's a set or not the right color
                    if($row2->type == "set" || $row2->color != $row->color || $row2->min != $row->max +  1) continue;

                    error_log("$rowID2 is good to combine at the end");

                    if($rowID2 < $rowID) [$rowID, $rowID2] = [$rowID2, $rowID];

                    $tableCombine->combine($rowID, $rowID2);
                    $actions[] = "COMBINE $rowID $rowID2";

                    $success = true;

                    break;
                }

                if($success == false) continue;
            }

            //We now have enough tiles to be able to remove the tile
            $tableCombine->remove($rowID, $tile);
            $actions[] = "TAKE " . $tile->getName() . " " . $rowID;

            $series[] = [$tableCombine, $actions];
        }
    }

    return $series;
}

function tryCombinePut($tableInitial, $tile): array {
    $series = [];

    foreach($tableInitial->getRows() as $rowID => $row) {
        //It's a set or not the right color
        if($row->type == "set" || $row->color != $tile->color) continue;

        if($row->min <= $tile->value && $row->max >= $tile->value) {
            error_log("we can try to combine row $rowID");

            $tableCombine = clone $tableInitial;
            $actions = [];

            //There isn't enough on the left
            if($tile->value - $row->min < 2) {
                error_log("we need to combine on the start");

                $success = false;

                foreach($tableInitial->getRows() as $rowID2 => $row2) {
                    //It's a set or not the right color
                    if($row2->type == "set" || $row2->color != $row->color || $row2->max != $row->min -  1) continue;

                    error_log("$rowID2 is good to combine at the start");

                    if($rowID2 < $rowID) [$rowID, $rowID2] = [$rowID2, $rowID];

                    $tableCombine->combine($rowID, $rowID2);
                    $actions[] = "COMBINE $rowID $rowID2";

                    $success = true;

                    break;
                }

                if($success == false) continue;
            }

            //There isn't enough on the right
            if($row->max - $tile->value < 2) {
                error_log("we need to combine on the end");

                $success = false;

                foreach($tableInitial->getRows() as $rowID2 => $row2) {
                    //It's a set or not the right color
                    if($row2->type == "set" || $row2->color != $row->color || $row2->min != $row->max +  1) continue;

                    error_log("$rowID2 is good to combine at the end");

                    if($rowID2 < $rowID) [$rowID, $rowID2] = [$rowID2, $rowID];

                    $tableCombine->combine($rowID, $rowID2);
                    $actions[] = "COMBINE $rowID $rowID2";

                    $success = true;

                    break;
                }

                if($success == false) continue;
            }

            //Combine was successful, we can now insert the tile which will create a new row
            $tableCombine->insert($rowID, $tile);
            $actions[] = "PUT " . $tile->getName() . " " . $rowID;

            $series[] = [$tableCombine, $actions];
        }
    }

    return $series;
}

function findTile(Table $tableInitial, Tile $tile): array {
    global $availableTiles;

    error_log("We want to find the tile " . $tile->getName());

    //Try to directly take the tile
    foreach($tableInitial->getRows() as $id => $row) {

        //error_log("trying to directly get it in row $id");

        if($row->canTake($tile)) {
            error_log("we can take the tile " . $tile->getName() . " in row $id");

            $tableInitial->remove($id, $tile);

            return [true, [[$tableInitial, ["TAKE " . $tile->getName() . " " . $id]]]];
        }
    }

    //We first try to combine to take
    $series = tryCombineTake($tableInitial, $tile);

    if(count($series)) return [true, $series];

    $solvedSeries = [];

    foreach($tableInitial->getRows() as $id => $row) {

        error_log("checking if we could take " . $tile->getName() . " in row $id");

        $takeInfo = $row->couldTake($tile);

        foreach($takeInfo as [$method, $tiles]) {
            error_log("we could take the tile in row $id");

            /*
            foreach($tiles as $tileToInsert) {
                if($availableTiles[$tile->color][$tileToInsert->value]) error_log("the tile " . $tileToInsert->getName() . " exist, we can try");
                else {
                    error_log("the tile " . $tileToInsert->getName() . " doesn't exist, we can skip");

                    continue 2;
                }
            }*/

            $series = [[clone $tableInitial, []]];

            if($method == "find") {
                foreach($tiles as $tileToInsert) {
                    $newSeries = [];
    
                    foreach($series as [$table, $actions]) {
                        [$success, $series] = findTile($table, $tileToInsert);
                        
                        if($success) {
                            foreach($series as [$updatedTable, $actionsTile]) {
    
                                $updatedTable->insert($id, $tileToInsert);
                                $actionsTile[] = "PUT " . $tileToInsert->getName() . " " . $id;
    
                                $newSeries[] = [$updatedTable, array_merge($actions, $actionsTile)];
                            }
                        }
                    }
    
                    $series = $newSeries;
                }
            } elseif($method == "remove") {
                foreach($tiles as $tileToRemove) {
                    $newSeries = [];

                    error_log("we need to remove the tile " . $tileToRemove->getName());
    
                    foreach($series as [$table, $actions]) {
                        $table->remove($id, $tileToRemove);
                        $actions[] = "TAKE " . $tileToRemove->getName() . " " . $id;

                        [$success, $seriesUpdated] = addTile($table, $tileToRemove, $id);

                        if($success) {
                            foreach($seriesUpdated as [$tableUpdated, $actionsTile]) {
                                $newSeries[] = [$tableUpdated, array_merge($actions, $actionsTile)];
                            }
                        }
                    }
    
                    $series = $newSeries;
                }
            }


            if(count($series)) {
                //We have added all the tiles that were missing, we can add the goal tile
                foreach($series as [$tableUpdated, $actions]) {
                    $tableUpdated->remove($id, $tile);
                    $actions[] = "TAKE " . $tile->getName() . " " . $id;
                }

                $solvedSeries[] = [$tableUpdated, $actions];
            }
        }
    }
    
    if(count($solvedSeries)) return [true, $solvedSeries];
    else return [false, []];
}

function addTile(Table $tableInitial, Tile $tile, int $forbidden = 0): array {
    global $availableTiles;

    error_log("We want to add the tile " . $tile->getName());

    //Try to directly add the tile
    foreach($tableInitial->getRows() as $id => $row) {
        if($id == $forbidden) continue;

        error_log("trying to directly add it in row $id");

        if($row->canInsert($tile)) {
            error_log("we can add the tile in row $id");

            $tableInitial->insert($id, $tile);

            return [true, [[$tableInitial, ["PUT " . $tile->getName() . " " . $id]]]];
        }
    }

    //We first try to combine to insert
    $series = tryCombinePut($tableInitial, $tile);

    if(count($series)) return [true, $series];

    $solvedSeries = [];

    foreach($tableInitial->getRows() as $id => $row) {
        if($id == $forbidden) continue;

        $tiles = $row->couldInsert($tile);

        if(count($tiles)) {
            error_log("we could add the tile in row $id");
            //error_log(var_export($tiles, true));

            foreach($tiles as $tileToInsert) {
                if($availableTiles[$tile->color][$tileToInsert->value]) error_log("the tile " . $tileToInsert->getName() . " exist, we can try");
                else {
                    error_log("the tile " . $tileToInsert->getName() . " doesn't exist, we can skip");

                    continue 2;
                }
            }

            $series = [[clone $tableInitial, []]];

            foreach($tiles as $tileToInsert) {
                $newSeries = [];

                foreach($series as [$table, $actions]) {
                    [$success, $series] = findTile($table, $tileToInsert);

                    if($success) {
                        foreach($series as [$tableUpdated, $actionsTile]) {

                            $tableUpdated->insert($id, $tileToInsert);
                            $actionsTile[] = "PUT " . $tileToInsert->getName() . " " . $id;

                            $newSeries[] = [$tableUpdated, array_merge($actions, $actionsTile)];
                        }
                    }
                }

                $series = $newSeries;
            }

            if(count($series)) {
                //We have added all the tiles that were missing, we can add the goal tile
                foreach($series as [$tableUpdated, $actions]) {
                    $tableUpdated->insert($id, $tile);
                    $actions[] = "PUT " . $tile->getName() . " " . $id;

                    $solvedSeries[] = [$tableUpdated, $actions];
                }
            }
        }
    }

    if(count($solvedSeries)) return [true, $solvedSeries];
    else return [false, []];
}

[, $series] = addTile($table, $goalTile);

error_log("We have " . count($series) . " to solve");

if(count($series) == 0) exit();

usort($series, function($a, $b) {   
    $countA = count($a[1]);
    $countB = count($b[1]);

    return $a <=> $b;
});

[$table, $actions] = array_pop($series);

echo implode("\n", $actions) . PHP_EOL;

$table->outputRows();

error_log(microtime(1) - $start);
