<?php

$start = microtime(1);

class Tile {
    public $value;
    public $color;
    public $isJoker;

    public function __construct(string $tile, bool $isJoker = false) {
        preg_match("/([0-9]{0,2})([BGRYJ])/", $tile, $array);

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
    public $colors;
    public $value;

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

    public function couldInsert(Tile $tile): array {
        $tiles = [];

        if($tile->value == $this->value && $this->hasJoker && !isset($this->colors[$tile->color])) {
            $tiles[] = ["remove", new Tile("J", true)];
            
            foreach($this->colors as $color => $filler) $tiles[] = ["remove", new Tile($tile->value . $color)];
        }

        return $tiles;
    }

    public function couldTake(Tile $tile): array {
        $tiles = [];

        //This set has the same value and has the color we want
        if($this->value == $tile->value && isset($this->colors[$tile->color])) {
            //Set doesn't have a joker, adding one will let us take the tile we want
            if($this->hasJoker == false) ["find", new Tile('J', true)];

            //Adding a color not already in the set will let use take the tile we want
            foreach(['B', 'G', 'R', 'Y'] as $color) {
                if(!isset($this->colors[$color])) $tiles[] = ["find", new Tile($this->value . $color)];
            }
        }

        //We want to take the joker
        if($tile->isJoker && $this->hasJoker) {
            //Adding a color not already in the set will let use take the joker
            foreach(['B', 'G', 'R', 'Y'] as $color) {
                if(!isset($this->colors[$color])) $tiles[] = ["find", new Tile($this->value . $color)];
            }
        }

        return $tiles;
    }

    public function getCount(): int {
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

    public function couldInsert(Tile $tile): array {
        if($this->color != $tile->color) return [];

        $tiles = [];

        if($this->hasJoker) {
            //We can use the joker to extend the start
            $tiles[] = ["find", new Tile($this->max + 2 . $tile->color)]; 
            //We can use the joker to extend the end
            $tiles[] = ["find", new Tile($this->max + 2 . $tile->color)]; 
        }
        else {
            $hasInsideJoker = false;

            foreach($this->tiles as $runTile) {
                if($runTile->isJoker) {
                    $hasInsideJoker = true;
                    break;
                }
            }

            if($hasInsideJoker == false) $tiles[] = ["find", new Tile("J", true)]; //Adding a Joker can only help
        }

        //We need to add tiles at the start
        if($tile->value < $this->min) $tiles[] = ["find", new Tile($this->min - 1 . $tile->color)];
        //We need to add tiles at the end
        if($tile->value > $this->max) $tiles[] = ["find", new Tile($this->max + 1 . $tile->color)]; 
        //Tile is already in the run, to add with a split run we need 2 tiles on both side
        if($tile->value >= 3 && $tile->value <= 11 && $tile->value > $this->min && $tile->value < $this->max) {
            if($this->min > $tile->value - 1) $tiles[] = ["find", new Tile($tile->value - 1 . $tile->color)];
            elseif($this->min > $tile->value - 2) $tiles[] = ["find", new Tile($tile->value - 2 . $tile->color)];

            if($this->max < $tile->value + 1) $tiles[] = ["find", new Tile($tile->value + 1 . $tile->color)];
            elseif($this->max < $tile->value + 2) $tiles[] = ["find", new Tile($tile->value + 2 . $tile->color)];
        }

        return $tiles;
    }

    public function couldTake(Tile $tile): array {
        $tiles = [];

        if($tile->isJoker) {
            //If we can't directly take it means we only have 2 tiles, we just need to add on at the start or end
            if($this->hasJoker) {
                if($this->max != 13) $tiles[] = ["find", new Tile($this->max + 1 . $this->color)];
                if($this->min != 1)  $tiles[] = ["find", new Tile($this->min - 1 . $this->color)];
            } else {
                foreach($this->getTiles() as $runTile) {
                    if($runTile->isJoker) $tiles[] = ["find", new Tile($runTile->value . $runTile->color)];
                }
            }
        } elseif($this->color == $tile->color) {
            //The tile is currently the min -- it means we currently have 3 tiles otherwise it could have been taken directly, we just need to add one at the end
            if($tile->value == $this->min && $this->max != 13) $tiles[] = ["find", new Tile($this->max + 1 . $this->color)];

            //The tile is currently the max -- it means we currently have 3 tiles otherwise it could have been taken directly, we just need to add one at the start
            if($tile->value == $this->max && $this->min != 1) $tiles[] = ["find", new Tile($this->min - 1 . $this->color)];

            //The tile is inside
            if($this->min < $tile->value && $this->max > $tile->value) {
                //Can we remove everything left and still have a valid run
                if($this->max - $tile->value >= 3) $tiles[] = ["remove", new Tile($this->min . $tile->color)];

                //Can we remove everything right and still have a valid run
                if($tile->value - $this->min >= 3) $tiles[] = ["remove", new Tile($this->max . $tile->color)];
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

    public function getCount(): int {
        return $this->count + ($this->hasJoker ? 1 : 0);
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

    public function insert(int $rowID, Tile $tile): bool {
        if(!isset($this->rows[$rowID])) return false;

        $row = $this->rows[$rowID];

        if($tile->isJoker) {
            if($row->getCount() != ($row->type == "set" ? 4 : 13)) {
                $row->hasJoker = true;
                return true;
            } else return false;
        }

        if($row->type == "set") {
            if($row->getCount() != 4 && $tile->value == $row->value && !isset($row->colors[$tile->color])) {
                $row->insert($tile);
                return true;
            }
        }
        elseif($row->color == $tile->color) {
            $tiles = $row->getTiles();

            //Directly insert at the start
            if($tile->value == $row->min - 1) {
                $row->insertStart($tile);
                return true;
            }
            //Directly insert at the end
            elseif($tile->value == $row->max + 1) {
                $row->insertEnd($tile);
                return true;
            }
            //We use the joker to extend the run at the start
            elseif($row->hasJoker && $tile->value == $row->min - 2) {
                $jokerTile = new Tile($tile->value + 1 . $tile->color, true);

                $row->insertStart($jokerTile);
                $row->insertStart($tile);

                $row->hasJoker = false;
                return true;
            }
            //We use the joker to extend the run at the end
            elseif($row->hasJoker && $tile->value == $row->max + 2) {
                $jokerTile = new Tile($tile->value - 1 . $tile->color, true);

                $row->insertEnd($jokerTile);
                $row->insertEnd($tile);

                $row->hasJoker = false;
                return true;
            }
            //Tile is replacing a joker in the middle of a run
            elseif(isset($tiles[$tile->getName()]) && $tiles[$tile->getName()]->isJoker) {
                $tiles[$tile->getName()]->isJoker = false;
                
                $row->hasJoker = true;
                return true;
            }
            //Splitting a run
            elseif($tile->value > $row->min && $tile->value < $row->max && (min($tile->value - $row->min, 2) + min($row->max - $tile->value, 2) + ($row->hasJoker ? 1 : 0)) == 4) {
                //Update the old row, remove all the tile that will create the new run
                while($row->max >= $tile->value) $tilesRemoved[] = $row->removeEnd();
                
                //Add the tile in the row
                $row->insertEnd($tile);

                //Create the new row
                $newRow = new Run(array_reverse($tilesRemoved), 0);

                //Does the joker moves to the new row
                if($row->hasJoker && count($tilesRemoved) == 2) {
                    $row->hasJoker = false;
                    $newRow->hasJoker = true; 
                }

                $this->rows[$this->nextRow++] = $newRow;
                return true;
            }
        }

        return false;
    }

    public function outputRows() {
        ksort($this->rows);

        foreach($this->rows as $id => $row) echo $id . " " . $row->getDisplay() . PHP_EOL;
    }

    public function remove(int $rowID, Tile $tile): bool {
        $row = $this->rows[$rowID];

        if($tile->isJoker) {
            //We have a joker & enough tile, we can just take it
            if($row->hasJoker && $row->getCount() >= 4) {
                $row->hasJoker = false;
                return true;
            } //Check if a joker is inside the run and can be taken by splitting the run 
            elseif($row->type == "run" && $row->getCount() >= 7) {
                foreach($row->getTiles() as $runTile) {
                    if($runTile->isJoker && $runTile->value - 3 >= $row->min && $runTile->value + 3 <= $row->max) {
                        $tiles = [];

                        //Update the old row, remove all the tile that will create the new run
                        while($row->max > $runTile->value) $tiles[] = $row->removeEnd();
        
                        //Remove the tile in the row
                        $row->removeEnd($runTile);
        
                        //Create the new row
                        $this->rows[$this->nextRow++] = new Run(array_reverse($tiles), 0);
        
                        return true;
                    }
                }
            }

            return false;
        }

        if($row->type == "set") {
            //We have the 4 tiles with the right value
            if($row->getCount() == 4 && $row->value == $tile->value && isset($row->colors[$tile->color])) {
                $row->remove($tile);
                return true;
            }
        } elseif($row->color == $tile->color) {
            //If the tile is the first of the run
            if($row->getCount() >= 4 && $tile->value == $row->min) {
                $row->removeStart();
                return true;
            } //If the tile is the last of the run 
            elseif($row->getCount() >= 4 && $tile->value == $row->max) {
                $row->removeEnd();
                return true;
            }//Splitting a run
            elseif($row->getCount() >= 7 && $tile->value - 3 >= $row->min && $tile->value + 3 <= $row->max) {
                $tiles = [];

                //Update the old row, remove all the tile that will create the new run
                while($row->max > $tile->value) $tiles[] = $row->removeEnd();

                //Remove the tile in the row
                $row->removeEnd($tile);

                //Create the new row
                $this->rows[$this->nextRow++] = new Run(array_reverse($tiles), 0);

                return true;
            }
        }

        return false;
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
//error_log(var_export($table->getRows()[16], true));


function tryCombine($tableInitial, $tile, $method): array {
    $solvedSeries = [];

    foreach($tableInitial->getRows() as $rowID => $row) {
        //We can't combine sets
        if($row->type == "set") continue;

        $tileGoal = $tile;

        //We want to combine to take a joker
        if($tile->isJoker) {
            foreach($row->getTiles() as $runTile) {
                if($runTile->isJoker) {
                    $tileGoal = $runTile;
                    break;
                }
            }

            //None of the tile in that run is an "inside" joker
            if($tileGoal->value == '') continue;
        } //The run needs to be of the right color and the tile already in the run
        elseif($row->color != $tile->color || $row->min > $tile->value || $row->max < $tile->value) continue;

        error_log("we can try to combine row $rowID");

        if($method == "PUT") {
            $needCombineStart = $tileGoal->value - $row->min < 2;
            $needCombineEnd   = $row->max - $tileGoal->value < 2;
        } else {
            if($row->max == $tileGoal->value) {
                $needCombineStart = true;
                $needCombineEnd   = false;
            } elseif($row->min == $tileGoal->value) {
                $needCombineStart = false;
                $needCombineEnd   = true;
            } else {
                $needCombineStart = $tileGoal->value - $row->min < 3;
                $needCombineEnd   = $row->max - $tileGoal->value < 3;
            }
        }

        $series = [[clone $tableInitial, []]];

        //We need to combine at the start
        if($needCombineStart) {
            error_log("we need to combine on the start");

            $newSeries = [];

            foreach($series as [$tableCombine, $actions]) {
                foreach($tableCombine->getRows() as $rowID2 => $row2) {
                    //It's a set or not the right color
                    if($row2->type == "set" || $row2->color != $row->color || $row2->max != $row->min -  1) continue;
    
                    error_log("$rowID2 is good to combine at the start");
    
                    if($rowID2 < $rowID) [$rowID, $rowID2] = [$rowID2, $rowID];
    
                    $tableUpdated = clone $tableCombine;
                    $tableUpdated->combine($rowID, $rowID2);

                    $newSeries[] = [$tableUpdated, array_merge($actions, ["COMBINE $rowID $rowID2"])];
                }
            }

            $series = $newSeries;
        }

        //We need to combine at the end
        if($needCombineEnd) {
            error_log("we need to combine on the end");

            $newSeries = [];

            foreach($series as [$tableCombine, $actions]) {
                foreach($tableCombine->getRows() as $rowID2 => $row2) {
                    //It's a set or not the right color
                    if($row2->type == "set" || $row2->color != $row->color || $row2->min != $row->max +  1) continue;

                    error_log("$rowID2 is good to combine at the end");

                    if($rowID2 < $rowID) [$rowID, $rowID2] = [$rowID2, $rowID];

                    $tableUpdated = clone $tableCombine;
                    $tableUpdated->combine($rowID, $rowID2);
                    
                    $newSeries[] = [$tableUpdated, array_merge($actions, ["COMBINE $rowID $rowID2"])];
                }
            }

            $series = $newSeries;
        }

        foreach($series as [$tableCombine, $actions]) {
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

            $solvedSeries[] = [$tableCombine, $actions];
        }
    }

    return $solvedSeries;
}

function findTile(Table $tableInitial, Tile $tile): array {
    error_log("We want to find the tile " . $tile->getName());

    $solvedSeries = [];

    //Try to directly take the tile
    foreach($tableInitial->getRows() as $rowID => $row) {

        //error_log("trying to directly get it in row $rowID");

        $tableUpdated = clone $tableInitial;

        if($tableUpdated->remove($rowID, $tile)) {
            error_log("we can directly remove the tile " . $tile->getName() . " in row $rowID");

            $solvedSeries[] = [$tableUpdated, ["TAKE " . $tile->getName() . " " . $rowID]];
        }
    }

    if(count($solvedSeries)) return $solvedSeries;

    //We first try to combine to take
    $solvedSeries = tryCombine($tableInitial, $tile, "TAKE");

    if(count($solvedSeries)) return $solvedSeries;

    foreach($tableInitial->getRows() as $rowID => $row) {
        $series = [[clone $tableInitial, []]];

        while(count($series)) {
            [$table, $actions] = array_pop($series);

            $rows = $table->getRows();

            $takeInfo = $rows[$rowID]->couldTake($tile);

            //error_log(var_export($takeInfo, true));

            foreach($takeInfo as [$method, $tileInfo]) {
                error_log("to take " . $tile->getName() . " we need to $method " . $tileInfo->getName() . " on row $rowID");

                if($method == "find") { 
                    $seriesUpdated = findTile($table, $tileInfo);
                    
                    foreach($seriesUpdated as [$tableUpdated, $actionsTile]) {
                        //Something went wrong, most likely the row doesn't exist anymore
                        if($tableUpdated->insert($rowID, $tileInfo) == false) continue;

                        $actionsTile = array_merge($actions, $actionsTile);
                        $actionsTile[] = "PUT " . $tileInfo->getName() . " " . $rowID;

                        //We have added all the tiles that were missing, we can add the goal tile
                        if($tableUpdated->remove($rowID, $tile)) {
                            error_log("we can now remove " . $tile->getName() . " on row $rowID");

                            $actionsTile[] = "TAKE " . $tile->getName() . " " . $rowID;
        
                            $solvedSeries[] = [$tableUpdated, $actionsTile];
                        }
                        else $series[] = [$tableUpdated, $actionsTile];
                    }
                } elseif($method == "remove") {
                    $tableUpdated = clone $table;

                    $seriesUpdated = addTile($tableUpdated, $tileInfo, $rowID);
                    
                    foreach($seriesUpdated as [$tableUpdated, $actionsTile]) {
                        //Something went wrong, most likely the row doesn't exist anymore
                        if($tableUpdated->remove($rowID, $tileInfo) == false) continue;

                        $actionsTile = array_merge($actions, ["TAKE " . $tileInfo->getName() . " " . $rowID], $actionsTile);

                        //We have removed all the tiles that were extra, we can add the goal tile
                        if($tableUpdated->remove($rowID, $tile)) {
                            error_log("we can now remove " . $tile->getName() . " on row $rowID");

                            $actionsTile[] = "TAKE " . $tile->getName() . " " . $rowID;
        
                            $solvedSeries[] = [$tableUpdated, $actionsTile];
                        }
                        else $series[] = [$tableUpdated, $actionsTile];
                    }
                }
            } 
        }
    }
    
    if(count($solvedSeries)) return $solvedSeries;
    else return [];
}

function addTile(Table $tableInitial, Tile $tile, int $forbiddenRowID = 0): array {
    error_log("We want to add the tile " . $tile->getName());

    $solvedSeries = [];

    //Try to directly add the tile
    foreach($tableInitial->getRows() as $rowID => $row) {
        if($rowID == $forbiddenRowID) continue;

        //error_log("trying to directly add it in row $id");

        $tableUpdated = clone $tableInitial;

        if($tableUpdated->insert($rowID, $tile)) {
            error_log("we can directly add the tile " . $tile->getName() . " in row $rowID");

            $solvedSeries[] = [$tableUpdated, ["PUT " . $tile->getName() . " " . $rowID]];
        }
    }

    if(count($solvedSeries)) return $solvedSeries;

    //We first try to combine to insert
    $solvedSeries = tryCombine($tableInitial, $tile, "PUT");

    if(count($solvedSeries)) return $solvedSeries;

    foreach($tableInitial->getRows() as $rowID => $row) {
        if($rowID == $forbiddenRowID) continue;

        $series = [[clone $tableInitial, []]];

        while(count($series)) {
            [$table, $actions] = array_pop($series);

            $rows = $table->getRows();

            $insertInfo = $rows[$rowID]->couldInsert($tile);

            foreach($insertInfo as [$method, $tileInfo]) {
                error_log("to insert " . $tile->getName() . " we need to $method " . $tileInfo->getName() . " on row $rowID");

                if($method == "find") { 
                    $seriesUpdated = findTile($table, $tileInfo);

                    foreach($seriesUpdated as [$tableUpdated, $actionsTile]) {
                        //Something went wrong, most likely the row doesn't exist anymore
                        if($tableUpdated->insert($rowID, $tileInfo) == false) continue;

                        $actionsTile = array_merge($actions, $actionsTile);
                        $actionsTile[] = "PUT " . $tileInfo->getName() . " " . $rowID;

                        //We have added all the tiles that were missing, we can add the goal tile
                        if($tableUpdated->insert($rowID, $tile)) {
                            error_log("we can now insert " . $tile->getName() . " on row $rowID");

                            $actionsTile[] = "PUT " . $tile->getName() . " " . $rowID;
        
                            $solvedSeries[] = [$tableUpdated, $actionsTile];
                        }
                        else $series[] = [$tableUpdated, $actionsTile];
                    }
                } elseif($method == "remove") {
                    $tableUpdated = clone $table;

                    $seriesUpdated = addTile($tableUpdated, $tileInfo, $rowID);
                    
                    foreach($seriesUpdated as [$tableUpdated, $actionsTile]) {
                        //Something went wrong, most likely the row doesn't exist anymore
                        if($tableUpdated->remove($rowID, $tileInfo) == false) continue;

                        $actionsTile = array_merge($actions, ["TAKE " . $tileInfo->getName() . " " . $rowID], $actionsTile);

                        //We have removed all the tiles that were extra, we can add the goal tile
                        if($tableUpdated->insert($rowID, $tile)) {
                            error_log("we can now insert " . $tile->getName() . " on row $rowID");

                            $actionsTile[] = "PUT " . $tile->getName() . " " . $rowID;
        
                            $solvedSeries[] = [$tableUpdated, $actionsTile];
                        }
                        else $series[] = [$tableUpdated, $actionsTile];
                    }
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

foreach($series as $i => [$table, $actions]) {
    $count = 0;
    $joker = 0;

    error_log(var_export($actions, true));

    foreach(array_reverse($actions, true) as $j => $action) {
        ++$count;

        if(preg_match("/TAKE J [0-9]+/", $action)) $joker = $j + 1;
    }

    array_push($series[$i], $count, $joker);
}

//error_log(var_export($series, true));

usort($series, function($a, $b) {   
    if($a[2] == $b[2]) {
        return $b[3] <=> $a[3]; //Don't use Joker if possible, if it's used it needs to used as early as possible
    } //In priority we want the least number of actions
    else return $b[2] <=> $a[2];
});

[$table, $actions] = array_pop($series);

echo implode("\n", $actions) . PHP_EOL;
$table->outputRows();

error_log(microtime(1) - $start);
