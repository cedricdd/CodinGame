<?php

$start = microtime(1);

class Tile {
    public $value;
    public $color;
    public $isJoker;

    public function __construct(string $tile, bool $isJoker = false) {
        preg_match("/([0-9]+)([BGRY])/", $tile, $array);

        $this->value = $array[1];
        $this->color = $array[2];
        $this->isJoker = $isJoker;
    }

    public function getName(): string {
        return $this->value . $this->color;
    }
}

abstract class Row {
    protected $tiles;
    protected $count;
    public $hasJoker;
    public $type;
}

class Set extends Row {
    private $colors;
    private $value;

    public function __construct(array $tiles, bool $hasJoker) {
        $this->type = "set";
        $this->colors = [];
        $this->count = count($tiles);

        foreach($tiles as $tile) {
            $this->hasJoker = $hasJoker;
            $this->value = $tile->value;
            $this->colors[$tile->color] = 1;
            $this->tiles[$tile->getName()] = $tile;
        }
    }

    public function canInsert(Tile $tile): bool {
        return $this->getCount() != 4 && !isset($this->colors[$tile->color]) && $tile->value == $this->value;
    }

    public function canTake(Tile $tile): bool {
        if($this->getCount() == 4 && $this->value == $tile->value) return true;

        return false;
    }

    public function couldInsert(Tile $tile): array {
        return [];
    }

    public function couldTake(Tile $tile): array {
        if($this->value == $tile->value && isset($this->colors[$tile->color])) {
            foreach(['B', 'G', 'R', 'Y'] as $color) {
                if(!isset($this->colors[$color])) return [["find", [new Tile($tile->value . $color)]]];
            }
        }

        return [];
    }

    private function getCount(): int {
        return $this->count + ($this->hasJoker ? 1 : 0);
    }

    public function getDisplay(): string {
        $output = [];

        foreach(['B', 'G', 'R', 'Y'] as $color) {
            if(isset($this->colors[$color])) $output[] = $this->value . $color;
        }

        if($this->hasJoker) $output[] = 'J';
        
        return implode(" ", $output);
    }

    public function insert(Tile $tile) {
        $this->colors[$tile->color] = 1;
        $this->tiles[$tile->getName()] = $tile;

        $this->count++;
    }

    public function remove(Tile $tile) {
        unset($this->colors[$tile->color]);
        unset($this->tiles[$tile->getName()]);

        $this->count--;
    }
}

class Run extends Row {
    public $min;
    public $max;
    public $color;

    public function __construct(array $tiles, bool $hasJoker) {
        $this->type = "run";
        $this->min = INF;
        $this->max = -INF;
        $this->count = count($tiles);

        foreach($tiles as $tile) {
            $this->tiles[$tile->getName()] = $tile;
            $this->hasJoker = $hasJoker;
            $this->color = $tile->color;
            $this->min = min($this->min, $tile->value);
            $this->max = max($this->max, $tile->value);
        }
    }

    public function canInsert(Tile $tile): bool {
        if($this->color == $tile->color) {
            //Adding at the start
            if($this->min - 1 == $tile->value) return true;
            //Adding at the end
            if($this->max + 1 == $tile->value) return true;
            //Adding in the middle and splitting the run
            if($this->getCount() >= 5 && $tile->value >= $this->min + 2 && $tile->value <= $this->max - 2) return true;
            //This tile is currently a joker
            if(isset($this->tiles[$tile->getName()]) && $this->tiles[$tile->getName()]->isJoker) return true;
            //We use the joker to extend the run
            if($this->hasJoker && ($tile->value == $this->max + 2 || $tile->value == $this->min - 2)) return true;
        } 

        return false;
    }

    public function canTake(Tile $tile): bool {
        //If the tile is the first or last
        if($this->getCount() >= 4 && $this->color == $tile->color && ($tile->value == $this->min || $tile->value == $this->max)) return true;
        //If we can take by splitting
        if($this->getCount() >= 7 && $this->color == $tile->color && $tile->value - 3 >= $this->min && $tile->value + 3 <= $this->max) return true;

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

    public function getDisplay(): string {
        $output = [];

        foreach($this->tiles as $name => $tile) {
            if($tile->isJoker) $output[] = 'J';
            else $output[] = $name;
        }

        if($this->hasJoker) $output[] = 'J';

        return implode(" ", $output);
    }

    private function getCount(): int {
        return $this->count + ($this->hasJoker ? 1 : 0);
    }

    private function getJoker(): Tile {
        return $this->tiles['J'];
    }

    public function getTiles(): array {
        return $this->tiles;
    }

    public function insertEnd(Tile $tile) {
        $this->count++;
        $this->max = max($tile->value, $this->max);

        $this->tiles = $this->tiles + [$tile->getName() => $tile];
    }

    public function insertStart(Tile $tile) {
        $this->count++;
        $this->min = min($tile->value, $this->min);

        $this->tiles = [$tile->getName() => $tile] + $this->tiles;
    }

    public function removeEnd(): Tile {
        $this->count--;
        $this->max--;

        $tile = end($this->tiles);

        unset($this->tiles[key($this->tiles)]);

        return $tile;
    }

    public function removeStart(): Tile {
        $this->count--;
        $this->min++;

        $tile = reset($this->tiles);

        unset($this->tiles[key($this->tiles)]);

        return $tile;
    }
}

class Table {
    private $rows;
    private $nextRow;

    public function __construct(array $rows) {
        foreach($rows as $row) {
            $rowID = array_shift($row);

            $colors = [];
            $tiles = [];
            $previousTile = null;
            $hasJoker = false;

            foreach($row as $i => $tileName) {

                //This tile is a joker
                if($tileName == 'J') {
                    //Is the joker the last of the tile
                    if($i == count($row) - 1) {
                        $hasJoker = true;
                        break;
                    }
                    //The joker is inside the run and is a specific tile
                    else  $tile = new Tile($previousTile->value + 1 . $previousTile->color, true);
                } //Normal tile
                else $tile = new Tile($tileName);

                $colors[$tile->color] = 1;
                $previousTile = $tile;
                $tiles[] = $tile;
            }

            $this->rows[$rowID] = count($colors) == 1 ? new Run($tiles, $hasJoker) : new Set($tiles, $hasJoker);
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

    public function getRows(): array {
        return $this->rows;
    }

    public function insert(int $rowID, Tile $tile) {
        $row = $this->rows[$rowID];

        if($row->type == "set") $row->insert($tile);
        else {
            $tiles = $row->getTiles();

            if($tile->value == $row->min - 1) $row->insertStart($tile);
            elseif($tile->value == $row->max + 1) $row->insertEnd($tile);
            elseif(isset($tiles[$tile->getName()]) && $tiles[$tile->getName()]->isJoker) {
                $tiles[$tile->getName()]->isJoker = false;
                
                $row->hasJoker = true;
            }
            elseif($row->hasJoker && $tile->value == $row->max + 2) {
                $jokerTile = new Tile($tile->value - 1 . $tile->color, true);

                $row->insertEnd($jokerTile);
                $row->insertEnd($tile);

                $row->hasJoker = false;
            }
            elseif($row->hasJoker && $tile->value == $row->min - 2) {
                $jokerTile = new Tile($tile->value + 1 . $tile->color, true);

                $row->insertStart($jokerTile);
                $row->insertStart($tile);

                $row->hasJoker = false;
            }
            //Splitting a run
            else {
                //Update the old row, remove all the tile that will create the new run
                while($row->max >= $tile->value) $tilesRemoved[] = $row->removeEnd();
    
                //Add the tile in the row
                $row->insertEnd($tile);

                //Create the new row
                $this->rows[$this->nextRow++] = new Run(array_reverse($tilesRemoved), 0);
            }
        }
    }

    public function outputRows() {
        ksort($this->rows);

        foreach($this->rows as $id => $row) echo $id . " " . $row->getDisplay() . PHP_EOL;
    }

    public function remove(int $rowID, Tile $tile) {
        $row = $this->rows[$rowID];

        if($row->type == "set") $row->remove($tile);
        elseif($tile->value == $row->min) $row->removeStart();
        elseif($tile->value == $row->max) $row->removeEnd();
        //Splitting a run
        else {
            $tiles = [];

            //Update the old row, remove all the tile that will create the new run
            while($row->max > $tile->value) $tiles[] = $row->removeEnd();

            //Remove the tile in the row
            $row->removeEnd($tile);

            //Create the new row
            $this->rows[$this->nextRow++] = new Run(array_reverse($tiles), 0);
        }
    }  
}

$goalTile = new Tile(trim(fgets(STDIN)));

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $rows[] = explode(" ", trim(fgets(STDIN)));
}

$table = new Table($rows);

//$combineActions = $table->combineRows();

//error_log(var_export($putstone, true));
//error_log(var_export($table, true));

function tryCombine($tableInitial, $tile, $method): array {
    $series = [];

    foreach($tableInitial->getRows() as $rowID => $row) {
        //It's a set or not the right color
        if($row->type == "set" || $row->color != $tile->color) continue;

        if($row->min <= $tile->value && $row->max >= $tile->value) {
            error_log("we can try to combine row $rowID");

            if($method == "PUT") {
                $needCombineStart = $tile->value - $row->min < 2;
                $needCombineEnd   = $row->max - $tile->value < 2;
            } else {
                if($row->max == $tile->value) {
                    $needCombineStart = true;
                    $needCombineEnd   = false;
                } elseif($row->min == $tile->value) {
                    $needCombineStart = false;
                    $needCombineEnd   = true;
                } else {
                    $needCombineStart = $tile->value - $row->min < 3;
                    $needCombineEnd   = $row->max - $tile->value < 3;
                }
            }

            $tableCombine = clone $tableInitial;
            $actions = [];

            //We need to combine at the start
            if($needCombineStart) {
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

            //We need to combine at the end
            if($needCombineEnd) {
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

            //Combine was successful, we can now apply the action
            if($method == "PUT") {
                //We now have enough tiles to be able to add the tile and create a new row
                $tableCombine->insert($rowID, $tile);
                $actions[] = "PUT " . $tile->getName() . " " . $rowID;
            } else {
                //We now have enough tiles to be able to remove the tile
                $tableCombine->remove($rowID, $tile);
                $actions[] = "TAKE " . $tile->getName() . " " . $rowID;
            }

            $series[] = [$tableCombine, $actions];
        }
    }

    return $series;
}

function findTile(Table $tableInitial, Tile $tile): array {
    error_log("We want to find the tile " . $tile->getName());

    $solvedSeries = [];

    //Try to directly take the tile
    foreach($tableInitial->getRows() as $id => $row) {

        //error_log("trying to directly get it in row $id");

        if($row->canTake($tile)) {
            error_log("we can take the tile " . $tile->getName() . " in row $id");

            $tableInitial->remove($id, $tile);

            $solvedSeries[] = [$tableInitial, ["TAKE " . $tile->getName() . " " . $id]];
        }
    }

    if(count($solvedSeries)) return $solvedSeries;

    //We first try to combine to take
    $solvedSeries = tryCombine($tableInitial, $tile, "TAKE");

    if(count($solvedSeries)) return $solvedSeries;

    foreach($tableInitial->getRows() as $id => $row) {

        error_log("checking if we could take " . $tile->getName() . " in row $id");

        $takeInfo = $row->couldTake($tile);

        foreach($takeInfo as [$method, $tiles]) {
            error_log("we could take the tile in row $id");

            $series = [[clone $tableInitial, []]];

            if($method == "find") {
                foreach($tiles as $tileToInsert) {
                    $newSeries = [];
    
                    foreach($series as [$table, $actions]) {
                        $seriesUpdated = findTile($table, $tileToInsert);
                        
                        foreach($seriesUpdated as [$updatedTable, $actionsTile]) {

                            $updatedTable->insert($id, $tileToInsert);
                            $actionsTile[] = "PUT " . $tileToInsert->getName() . " " . $id;

                            $newSeries[] = [$updatedTable, array_merge($actions, $actionsTile)];
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

                        $seriesUpdated = addTile($table, $tileToRemove, $id);

                        foreach($seriesUpdated as [$tableUpdated, $actionsTile]) {
                            $newSeries[] = [$tableUpdated, array_merge($actions, $actionsTile)];
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
    
    if(count($solvedSeries)) return $solvedSeries;
    else return [];
}

function addTile(Table $tableInitial, Tile $tile, int $forbidden = 0): array {
    error_log("We want to add the tile " . $tile->getName());

    $solvedSeries = [];

    //Try to directly add the tile
    foreach($tableInitial->getRows() as $id => $row) {
        if($id == $forbidden) continue;

        error_log("trying to directly add it in row $id");

        if($row->canInsert($tile)) {
            error_log("we can add the tile in row $id");

            $tableInitial->insert($id, $tile);

            $solvedSeries[] = [$tableInitial, ["PUT " . $tile->getName() . " " . $id]];
        }
    }

    if(count($solvedSeries)) return $solvedSeries;

    //We first try to combine to insert
    $solvedSeries = tryCombine($tableInitial, $tile, "PUT");

    if(count($solvedSeries)) return $solvedSeries;

    foreach($tableInitial->getRows() as $id => $row) {
        if($id == $forbidden) continue;

        $tiles = $row->couldInsert($tile);

        if(count($tiles)) {
            error_log("we could add the tile in row $id");
            //error_log(var_export($tiles, true));

            $series = [[clone $tableInitial, []]];

            foreach($tiles as $tileToInsert) {
                $newSeries = [];

                foreach($series as [$table, $actions]) {
                    $seriesUpdated = findTile($table, $tileToInsert);

                    foreach($seriesUpdated as [$tableUpdated, $actionsTile]) {

                        $tableUpdated->insert($id, $tileToInsert);
                        $actionsTile[] = "PUT " . $tileToInsert->getName() . " " . $id;

                        $newSeries[] = [$tableUpdated, array_merge($actions, $actionsTile)];
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

    if(count($solvedSeries)) return $solvedSeries;
    else return [];
}

$series = addTile($table, $goalTile);

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
