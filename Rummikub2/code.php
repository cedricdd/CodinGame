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
    public $hasJoker;
    public $type;
}

class Set extends Row {
    public $colors;
    public $value;

    public function __construct(array $tiles, bool $hasJoker) {
        $this->type = "set";
        $this->colors = [];
        $this->hasJoker = $hasJoker;

        foreach($tiles as $tile) {
            $this->value = $tile->value;
            $this->colors[$tile->color] = 1;
            $this->tiles[$tile->getName()] = $tile;
        }
    }

    //Returns the ways we could insert a given tile into this set
    public function couldInsert(Tile $tile): array {
        $tiles = [];

        //The only case is when the set is full (4 tiles) and a joker is currently at the place of the tile we would like to insert
        if($tile->value == $this->value && $this->getCount() == 4 && $this->hasJoker && !isset($this->colors[$tile->color])) {
            //Removing the Joker will free the space for the tile
            $tiles[] = ["remove", new Tile("J", true)];
            
            //Removing any of the current tiles will let us insert our tile
            foreach($this->colors as $color => $filler) $tiles[] = ["remove", new Tile($tile->value . $color)];
        }

        return $tiles;
    }

    //Returns the ways we could take a given tile from this set
    public function couldTake(Tile $tile): array {
        $tiles = [];

        if($this->getCount() == 4) return []; //If we have 4 tiles we can directly take the tile if it's there

        //This set has the same value and has the color we want
        if($this->value == $tile->value && isset($this->colors[$tile->color])) {
            //Set doesn't have a joker, adding one will let us take the tile we want
            if($this->hasJoker == false) $tiles[] = ["find", new Tile('J', true)];

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

    //Get the number of tiles in this set
    public function getCount(): int {
        return count($this->tiles) + ($this->hasJoker ? 1 : 0);
    }

    //Get a string representing this set
    public function getDisplay(): string {
        $output = [];

        foreach(['B', 'G', 'R', 'Y'] as $color) {
            if(isset($this->colors[$color])) $output[] = $this->value . $color;
        }

        if($this->hasJoker) $output[] = 'J';
        
        return implode(" ", $output);
    }

    //Add a tile into the set
    public function insert(Tile $tile) {
        $this->colors[$tile->color] = 1;
        $this->tiles[$tile->getName()] = $tile;
    }

    //Remove a tile from this set
    public function remove(Tile $tile) {
        unset($this->colors[$tile->color]);
        unset($this->tiles[$tile->getName()]);
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
        $this->hasJoker = $hasJoker;

        foreach($tiles as $tile) {
            $this->tiles[$tile->getName()] = $tile;
            $this->color = $tile->color;
            $this->min = min($this->min, $tile->value);
            $this->max = max($this->max, $tile->value);
        }
    }

    //Returns the ways we could insert a given tile into this run
    public function couldInsert(Tile $tile): array {
        if($this->color != $tile->color) return [];

        $tiles = [];

        if($this->hasJoker) {
            //We can use the joker to extend the start
            if($tile->value < $this->min - 2) $tiles[$this->min - 2] = ["find", new Tile($this->min - 2 . $tile->color)]; 
            //We can use the joker to extend the end
            if($tile->value > $this->max + 2) $tiles[$this->max + 2] = ["find", new Tile($this->max + 2 . $tile->color)]; 
        }
        else {
            $hasInsideJoker = false;

            foreach($this->tiles as $runTile) {
                if($runTile->isJoker) {
                    $hasInsideJoker = true;
                    break;
                }
            }

            if($hasInsideJoker == false) $tiles[0] = ["find", new Tile("J", true)]; //Adding a Joker can only help
        }

        //We need to complete at the start to add the tile
        if($tile->value < $this->min - 1) $tiles[$this->min - 1] = ["find", new Tile($this->min - 1 . $tile->color)];
        //We need to complete at the end to add the tile
        if($tile->value > $this->max + 1) $tiles[$this->max + 1] = ["find", new Tile($this->max + 1 . $tile->color)]; 

        //Tile is already in the run, to add with a split run we need 2 tiles on both side
        if($tile->value >= $this->min && $tile->value <= $this->max && min(2, $tile->value - $this->min) + min(2, $this->max - $tile->value) + ($this->hasJoker ? 1 : 0) < 4) {
            //We can insert by splitting on the tile itself or after splitting on a direct neighbor of the tile
            for($i = max(3, $tile->value - ($this->hasJoker ? 2 : 1), $this->min); $i <= min(11, $tile->value + ($this->hasJoker ? 2 : 1), $this->max); ++$i) {
                $left =  min(2, $i - $this->min);
                $right = min(2, $this->max - $i);

                //If we split here we will be able to insert the tile after that split
                if($left + $right + ($this->hasJoker ? 1 : 0) >= 4) $tiles[$i] = ["find", new Tile($i . $tile->color)];
                //We need more tiles to be able to split here
                else {
                    if($left != 2)  $tiles[$i - $left - 1]  = ["find", new Tile(($i - $left - 1) . $tile->color)];
                    if($right != 2) $tiles[$i + $right + 1] = ["find", new Tile(($i + $right + 1) . $tile->color)];
                }
            }
        }

        return $tiles;
    }

    //Returns the ways we could take a given tile from this run
    public function couldTake(Tile $tile): array {
        $tiles = [];

        //We want to take a joker
        if($tile->isJoker) {
            if($this->hasJoker) {
                //If we already have at least 3 tiles we can directly take the Joker
                if($this->getCount() == 3) {
                    if($this->max != 13) $tiles[$this->max + 1] = ["find", new Tile($this->max + 1 . $this->color)];
                    if($this->min != 1)  $tiles[$this->min - 1] = ["find", new Tile($this->min - 1 . $this->color)];
                }
            } else {
                //Check if we have an 'inside' joker 
                foreach($this->getTiles() as $runTile) {
                    if($runTile->isJoker) {
                        //We could just replace it with the tile it currently represent to free the joker
                        $tiles[$runTile->value] = ["find", new Tile($runTile->value . $runTile->color)];

                        //Can we remove everything left and still have a valid run
                        if($this->max - $runTile->value >= 3) $tiles[$this->min] = ["remove", new Tile($this->min . $runTile->color)];

                        //Can we remove everything right and still have a valid run
                        if($runTile->value - $this->min >= 3) $tiles[$this->max] = ["remove", new Tile($this->max . $runTile->color)];
                    }
                }
            }
        } elseif($this->color == $tile->color) {
            //The tile is currently the min but we only have 3 tiles
            if($tile->value == $this->min && $this->getCount() == 3 && $this->max != 13) $tiles[$this->max + 1] = ["find", new Tile($this->max + 1 . $this->color)];

            //The tile is currently the max but we only have 3 tiles
            if($tile->value == $this->max && $this->getCount() == 3 && $this->min != 1) $tiles[$this->min - 1] = ["find", new Tile($this->min - 1 . $this->color)];

            //The tile is inside the run
            if($this->min < $tile->value && $this->max > $tile->value) {
                //Can we remove everything left and still have a valid run
                if($this->max - $tile->value >= 3) $tiles[$this->min] = ["remove", new Tile($this->min . $tile->color)];

                //Can we remove everything right and still have a valid run
                if($tile->value - $this->min >= 3) $tiles[$this->max] = ["remove", new Tile($this->max . $tile->color)];
            }
        }

        return $tiles;
    }

    //Get a string representing this run
    public function getDisplay(): string {
        $output = [];

        foreach($this->tiles as $name => $tile) {
            if($tile->isJoker) $output[] = 'J';
            else $output[] = $name;
        }

        if($this->hasJoker) $output[] = 'J';

        return implode(" ", $output);
    }

    //Get the number of tiles in this run
    public function getCount(): int {
        return count($this->tiles) + ($this->hasJoker ? 1 : 0);
    }

    //Get the tiles in this run
    public function getTiles(): array {
        return $this->tiles;
    }

    //Insert a tile at the end of the run
    public function insertEnd(Tile $tile) {
        $this->max = max($tile->value, $this->max);

        $this->tiles = $this->tiles + [$tile->getName() => $tile];
    }

    //Insert a tile at the start of the run
    public function insertStart(Tile $tile) {
        $this->min = min($tile->value, $this->min);

        $this->tiles = [$tile->getName() => $tile] + $this->tiles;
    }

    //Remove the tile at the end of the run
    public function removeEnd(): Tile {
        $this->max--;

        $tile = end($this->tiles);

        unset($this->tiles[key($this->tiles)]);

        //Check if the new last tile was an 'inside' joker
        if($this->tiles[$key = array_key_last($this->tiles)]->isJoker) {
            $this->hasJoker = true;
            $this->max--;

            unset($this->tiles[$key]);
        }

        return $tile;
    }

    //Remove the tile at the start of the run
    public function removeStart(): Tile {
        $this->min++;

        $tile = reset($this->tiles);

        unset($this->tiles[key($this->tiles)]);

        //Check if the new first tile was an 'inside' joker
        if($this->tiles[$key = array_key_first($this->tiles)]->isJoker) {
            $this->hasJoker = true;
            $this->min++;

            unset($this->tiles[$key]);
        }

        return $tile;
    }
}

class Table {
    private $rows;
    private $nextRow;

    public function __construct(array $rows) {
        foreach($rows as $row) {
            $rowID = array_shift($row);

            $tiles = [];
            $colors = [];
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

    //Combine row r1 & r2, r2 is merged with r1 and is removed
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

    //Get all the rows
    public function getRows(int $rowID = null) {
        if($rowID) return $this->rows[$rowID];
        else return $this->rows;
    }

    //Try to insert $tile into row $rowID
    public function insert(int $rowID, Tile $tile): array {
        if(!isset($this->rows[$rowID])) return [];

        $row = $this->rows[$rowID];

        //We can insert a joker as long as the row is not already full
        if($tile->isJoker) {
            if($row->getCount() != ($row->type == "set" ? 4 : 13)) {
                $row->hasJoker = true;
                return [$rowID];
            } else return [];
        }

        if($row->type == "set") {
            if($row->getCount() != 4 && $tile->value == $row->value && !isset($row->colors[$tile->color])) {
                $row->insert($tile);
                return [$rowID];
            }
        }
        elseif($row->color == $tile->color) {
            $tiles = $row->getTiles();

            //Directly insert at the start
            if($tile->value == $row->min - 1) {
                $row->insertStart($tile);
                return [$rowID];
            }
            //Directly insert at the end
            elseif($tile->value == $row->max + 1) {
                $row->insertEnd($tile);
                return [$rowID];
            }
            //We use the joker to extend the run at the start
            elseif($row->hasJoker && $tile->value == $row->min - 2) {
                $jokerTile = new Tile($tile->value + 1 . $tile->color, true);

                $row->insertStart($jokerTile);
                $row->insertStart($tile);

                $row->hasJoker = false;
                return [$rowID];
            }
            //We use the joker to extend the run at the end
            elseif($row->hasJoker && $tile->value == $row->max + 2) {
                $jokerTile = new Tile($tile->value - 1 . $tile->color, true);

                $row->insertEnd($jokerTile);
                $row->insertEnd($tile);

                $row->hasJoker = false;
                return [$rowID];
            }
            //Tile is replacing a joker in the middle of a run
            elseif(isset($tiles[$tile->getName()]) && $tiles[$tile->getName()]->isJoker) {
                $tiles[$tile->getName()]->isJoker = false;
                
                $row->hasJoker = true;
                return [$rowID];
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

                $newRowID = $this->nextRow++;
                $this->rows[$newRowID] = $newRow;
                return [$rowID, $newRowID];
            }
        }

        return [];
    }

    //Print all the rows
    public function outputRows() {
        ksort($this->rows);

        foreach($this->rows as $id => $row) echo $id . " " . $row->getDisplay() . PHP_EOL;
    }

        //Print all the rows
        public function outputRows2() {
            ksort($this->rows);
    
            foreach($this->rows as $id => $row) error_log($id . " " . $row->getDisplay());

            error_log("end");
        }

    //Try to remove $tile from row $rowID
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
        
                        //Joker became a row joker since it's now the last tile of the row
                        $row->hasJoker = false;
        
                        //Create the new row
                        $this->rows[$this->nextRow++] = new Run(array_reverse($tiles), 0);
        
                        return true;
                    }
                }
            }

            return false;
        }

        if($row->type == "set") {
            //We have 4 tiles with the right value
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

function addTile(Table $tableInitial, Tile $tile, array $forbiddenRows): array {
    $solvedSeries = [];

    //Try to directly add the tile
    foreach($tableInitial->getRows() as $rowID => $row) {
        if(isset($forbiddenRows[$rowID])) continue;

        $tableUpdated = clone $tableInitial;

        if(count($tableUpdated->insert($rowID, $tile))) $solvedSeries[] = [$tableUpdated, ["PUT " . $tile->getName() . " " . $rowID]];
    }

    //We first try to combine to insert
    $solvedSeries = array_merge($solvedSeries, tryCombine($tableInitial, $tile, "PUT", $forbiddenRows));

    //if(count($solvedSeries)) return $solvedSeries;

    foreach($tableInitial->getRows() as $rowID => $row) {
        if(isset($forbiddenRows[$rowID])) continue;

        $series = [[clone $tableInitial, []]];

        while(count($series)) {
            [$table, $actions] = array_pop($series);

            $rows = $table->getRows();

            foreach($rows[$rowID]->couldInsert($tile) as [$method, $tileInfo]) {

                if($method == "find") { 
                    $seriesUpdated = findTile($table, $tileInfo, $forbiddenRows + [$rowID => 1]);

                    foreach($seriesUpdated as [$tableUpdated, $actionsTile]) {
                        $rowsAffected = $tableUpdated->insert($rowID, $tileInfo);

                        $actionsTile = array_merge($actions, $actionsTile);
                        $actionsTile[] = "PUT " . $tileInfo->getName() . " " . $rowID;

                        //We have added all the tiles that were missing, we can add the goal tile
                        foreach($rowsAffected as $rowID2) {
                            if($tableUpdated->insert($rowID2, $tile)) {
                                $actionsTile[] = "PUT " . $tile->getName() . " " . $rowID2;
            
                                $solvedSeries[] = [$tableUpdated, $actionsTile];

                                continue 2;
                            } 
                        }
                       
                        $series[] = [$tableUpdated, $actionsTile]; //We still can't add the tile
                    }
                } elseif($method == "remove") {
                    $tableUpdated = clone $table;

                    $seriesUpdated = addTile($tableUpdated, $tileInfo, $forbiddenRows + [$rowID => 1]);
                    
                    foreach($seriesUpdated as [$tableUpdated, $actionsTile]) {
                        //Something went wrong, most likely the row doesn't exist anymore
                        if($tableUpdated->remove($rowID, $tileInfo) == false) continue;

                        $actionsTile = array_merge($actions, ["TAKE " . $tileInfo->getName() . " " . $rowID], $actionsTile);

                        //We have removed all the tiles that were extra, we can add the goal tile
                        if($tableUpdated->insert($rowID, $tile)) {
                            $actionsTile[] = "PUT " . $tile->getName() . " " . $rowID;
        
                            $solvedSeries[] = [$tableUpdated, $actionsTile]; //We still can't add the tile
                        }
                        else $series[] = [$tableUpdated, $actionsTile];
                    }
                }
            } 
        }
    }

    return $solvedSeries;
}

function findTile(Table $tableInitial, Tile $tile, array $forbiddenRows): array {
    $solvedSeries = [];

    //Try to directly take the tile
    foreach($tableInitial->getRows() as $rowID => $row) {
        if(isset($forbiddenRows[$rowID])) continue;

        $tableUpdated = clone $tableInitial;

        if($tableUpdated->remove($rowID, $tile)) $solvedSeries[] = [$tableUpdated, ["TAKE " . $tile->getName() . " " . $rowID]];
    }

    //We first try to combine to take
    $solvedSeries = array_merge($solvedSeries, tryCombine($tableInitial, $tile, "TAKE", $forbiddenRows));

    //if(count($solvedSeries)) return $solvedSeries;

    foreach($tableInitial->getRows() as $rowID => $row) {
        if(isset($forbiddenRows[$rowID])) continue;

        $series = [[clone $tableInitial, []]];

        while(count($series)) {
            [$table, $actions] = array_pop($series);

            $rows = $table->getRows();

            foreach($rows[$rowID]->couldTake($tile) as [$method, $tileInfo]) {

                if($method == "find") { 
                    $seriesUpdated = findTile($table, $tileInfo, $forbiddenRows + [$rowID => 1]);
                    
                    foreach($seriesUpdated as [$tableUpdated, $actionsTile]) {
                        $rowsAffected = $tableUpdated->insert($rowID, $tileInfo);

                        $actionsTile = array_merge($actions, $actionsTile);
                        $actionsTile[] = "PUT " . $tileInfo->getName() . " " . $rowID;

                        //We have added all the tiles that were missing, we can add the goal tile
                        foreach($rowsAffected as $rowID2) {
                            if($tableUpdated->remove($rowID2, $tile)) {
                                $actionsTile[] = "TAKE " . $tile->getName() . " " . $rowID2;
            
                                $solvedSeries[] = [$tableUpdated, $actionsTile];

                                continue 2;
                            } 
                        }
                       
                        $series[] = [$tableUpdated, $actionsTile]; //We still can't add the tile
                    }
                } elseif($method == "remove") {
                    $tableUpdated = clone $table;

                    $seriesUpdated = addTile($tableUpdated, $tileInfo, $forbiddenRows + [$rowID => 1]);
                    
                    foreach($seriesUpdated as [$tableUpdated, $actionsTile]) {
                        //Something went wrong, most likely the row doesn't exist anymore
                        if($tableUpdated->remove($rowID, $tileInfo) == false) continue;

                        $actionsTile = array_merge($actions, ["TAKE " . $tileInfo->getName() . " " . $rowID], $actionsTile);

                        //We have removed all the tiles that were extra, we can add the goal tile
                        if($tableUpdated->remove($rowID, $tile)) {
                            $actionsTile[] = "TAKE " . $tile->getName() . " " . $rowID;
        
                            $solvedSeries[] = [$tableUpdated, $actionsTile];
                        }
                        else $series[] = [$tableUpdated, $actionsTile]; //We still can't take the tile
                    }
                }
            } 
        }
    }

    return $solvedSeries;
}

//Try to take or add a tile by combining rows
function tryCombine($tableInitial, $tile, $method, $forbiddenRows): array {
    $solvedSeries = [];

    foreach($tableInitial->getRows() as $rowID => $row) {
        if(isset($forbiddenRows[$rowID])) continue;

        //We can't combine sets
        if($row->type == "set") continue;

        $series = [];
        $tileGoal = $tile;

        //We want to combine to take a joker, we never need to combine to put a joker
        if($tile->isJoker) {
            //Row has a joker, if we can't take it directly it means we don't have enough tiles
            if($row->hasJoker) {
                //We can potentially combine at the start
                if($row->min > 3)  $series[] = [clone $tableInitial, [], $rowID, 1, 0];
                //We can potentially combine at the end
                if($row->max < 11) $series[] = [clone $tableInitial, [], $rowID, 0, 1];
            } else {
                //Do we have an inside joker
                foreach($row->getTiles() as $runTile) {
                    if($runTile->isJoker) {
                        $tileGoal = $runTile;
                        break;
                    }
                }
            }
        } 
        
        //The run needs to be of the right color
        if($tileGoal->value != '' && $row->color == $tileGoal->color) {
            //To add the tile we need two or more tiles on each sides
            if($method == "PUT") {
                if($row->min <= $tileGoal->value && $row->max >= $tileGoal->value) {
                    $series[] = [clone $tableInitial, [], $rowID, ($tileGoal->value - $row->min < 2), ($row->max - $tileGoal->value < 2)];
                }
            } else {
                //The tile is the last in the run, we need to add more at the start
                if($row->max == $tileGoal->value && $row->min > 3) {
                    $series[] = [clone $tableInitial, [], $rowID, 1, 0];
                } 
                //The tile is the first in the run, we need to add more at the end
                if($row->min == $tileGoal->value && $row->max < 11) {
                    $series[] = [clone $tableInitial, [], $rowID, 0, 1];
                } 
                //To take the tile we need three or more tiles on each sides
                if($row->min < $tileGoal->value && $row->max > $tileGoal->value) {
                    $series[] = [clone $tableInitial, [], $rowID, ($tileGoal->value - $row->min < 3), ($row->max - $tileGoal->value < 3)];
                }
            }
        }

        while(count($series)) {
            [$tableCombine, $actions, $rowID, $start, $end] = array_pop($series);

            $row1 = $tableCombine->getRows($rowID);

            foreach($tableCombine->getRows() as $rowID2 => $row2) {

                //It's a set or not the right color
                if($row2->type == "set" || $row2->color != $row1->color || isset($forbiddenRows[$rowID2])) continue;

                //We need to combine at the start
                if($start) {
                    //We can directly combine
                    if($row2->max == $row1->min -  1) {
                        $rowID1 = $rowID;

                        //Rows are combine into the row with the lowest ID
                        if($rowID2 < $rowID1) [$rowID1, $rowID2] = [$rowID2, $rowID1];
        
                        $tableUpdated = clone $tableCombine;
                        $tableUpdated->combine($rowID1, $rowID2);
    
                        $actionsUpdated = array_merge($actions, ["COMBINE $rowID1 $rowID2"]);
    
                        if($end) $series[] = [$tableUpdated, $actionsUpdated, $rowID1, 0, 1]; //We still need to combine at the end
                        else $solvedSeries[] = [$tableUpdated, $actionsUpdated, $rowID1];
                    }

                    //If we remove some tiles at the start of row1 we might be able to combine (we need at least 3 tiles left)
                    if($row1->min <= $row2->max && $row1->max - $row2->max >= 3) {
                        $tileInfo = new Tile($row1->min . $row1->color);

                        $seriesUpdated = addTile($tableCombine, $tileInfo, $forbiddenRows + [$rowID => 1, $rowID2 => 1]); 

                        foreach($seriesUpdated as [$tableUpdated, $actionsRemoval]) {
                            $tableUpdated->remove($rowID, $tileInfo);

                            array_splice($actionsRemoval, count($actionsRemoval) - 1, 0, "TAKE " . $tileInfo->getName() . " " . $rowID);
                            $actionsRemoval = array_merge($actions, $actionsRemoval);

                            $series[] = [$tableUpdated, $actionsRemoval, $rowID, $start, $end];
                        } 
                    }
                }

                //We need to combine at the end
                if($end) {
                    //We need to combine at the start
                    if($row2->min == $row1->max +  1) {
                        $rowID1 = $rowID;

                        //Rows are combine into the row with the lowest ID
                        if($rowID2 < $rowID1) [$rowID1, $rowID2] = [$rowID2, $rowID1];
    
                        $tableUpdated = clone $tableCombine;
                        $tableUpdated->combine($rowID1, $rowID2);
    
                        $actionsUpdated = array_merge($actions, ["COMBINE $rowID1 $rowID2"]);
    
                        if($start) $series[] = [$tableUpdated, $actionsUpdated, $rowID1, 1, 0]; //We still need to combine at the start
                        else $solvedSeries[] = [$tableUpdated, $actionsUpdated, $rowID1];
                    }

                    //If we remove some tiles at the end of row1 we might be able to combine (we need at least 3 tiles left)
                    if($row1->max >= $row2->min && $row2->min - $row1->min >= 3) {
                        $tileInfo = new Tile($row1->max . $row1->color);

                        $seriesUpdated = addTile($tableCombine, $tileInfo, $forbiddenRows + [$rowID => 1, $rowID2 => 1]); 

                        foreach($seriesUpdated as [$tableUpdated, $actionsRemoval]) {
                            $tableUpdated->remove($rowID, $tileInfo);

                            array_splice($actionsRemoval, count($actionsRemoval) - 1, 0, "TAKE " . $tileInfo->getName() . " " . $rowID);
                            $actionsRemoval = array_merge($actions, $actionsRemoval);

                            $series[] = [$tableUpdated, $actionsRemoval, $rowID, $start, $end];
                        }
                    }
                }
            }
        }
    }

    //Combine was successful, we can now apply the action
    foreach($solvedSeries as [&$tableCombine, &$actions, $rowID]) {
        if($method == "PUT") {
            //We now have enough tiles to be able to add the tile 
            $tableCombine->insert($rowID, $tile);
            $actions[] = "PUT " . $tile->getName() . " " . $rowID;
        } else {
            //We now have enough tiles to be able to remove the tile
            $tableCombine->remove($rowID, $tile);
            $actions[] = "TAKE " . $tile->getName() . " " . $rowID;
        }

        //if(isset($debug)) error_log(var_export($actions, true));
    }

    return $solvedSeries;
}

$goalTile = new Tile(trim(fgets(STDIN)));

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $rows[] = explode(" ", trim(fgets(STDIN)));
}

$table = new Table($rows);

$solutions = addTile($table, $goalTile, []);
$bestSolution = [INF, INF];

//Generate info to sort the solutions
foreach($solutions as $i => [$table, $actions]) {
    $count = count($actions);

    $firstCombine = INF;

    foreach($actions as $index => $action) {
        $a1 = explode(" ", $action);
        //Check if we can move the combine earlier
        if($a1[0] == "COMBINE") {
            $indexCombine = $index;
    
            while($indexCombine > 0) {
                if(strpos($actions[$indexCombine - 1], "COMBINE") !== false) break;
    
                //Check if we can move the combine before the TAKE/PUT
                $a2 = explode(" ", $actions[$indexCombine - 2]);
                $a3 = explode(" ", $actions[$indexCombine - 1]);
                
                //There's no conflict we don't use the rows in the combine
                if($a1[1] != $a2[2] && $a1[2] != $a2[2] && $a1[2] != $a3[2] && $a1[2] != $a3[2]) {
                    unset($actions[$indexCombine]);
                    $indexCombine -= 2;
                    array_splice($actions, $indexCombine, 0, $action);
                } else break;
            }  
            
            $firstCombine = min($firstCombine, $indexCombine);
        }
    }

    if($count > $bestSolution[0]) continue; //Our current best solution has less steps
    elseif($count == $bestSolution[0] && $firstCombine != INF) { //Same number of steps
        if($firstCombine > $bestSolution[1]) continue; //Our current best solution has a combine ealier
        if($firstCombine == $bestSolution[1]) {
            [$c1, $r1, $r2] = explode(" ", $bestActions[$firstCombine]);
            [$c2, $r3, $r4] = explode(" ", $actions[$firstCombine]);
    
            if($r1 < $r3 || ($r1 == $r3 && $r2 < $r4)) continue; //Our current best solution is combining lower numbered rowid
        }
    }

    $bestSolution = [$count, $firstCombine];
    [$bestTable, $bestActions] = [$table, $actions];
}

echo implode("\n", $bestActions) . PHP_EOL;
$bestTable->outputRows();

error_log(microtime(1) - $start);
