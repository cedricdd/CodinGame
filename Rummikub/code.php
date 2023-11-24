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
                if(!isset($this->colors[$color])) return [new Tile($tile->value . $color)];
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
        if($tile->value == $this->min && $this->max != 13) $tiles[] = new Tile($this->max + 1 . $this->color);

        //The tile is currently the max -- it means we currently have 3 tiles otherwise it could have been taken directly, we just need to add one at the start
        if($tile->value == $this->max && $this->min != 1) $tiles[] = new Tile($this->min - 1 . $this->color);

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

    public function combineRows(): array {
        $actions = [];

        foreach($this->rows as $id => $row) {
            if($row->type == "set") continue;

            foreach($this->rows as $id2 => $row2) {
                if($id2 <= $id || $row2->type == "set") continue;

                if($row->color != $row2->color) continue;

                error_log("trying to merge row $id & $id2");

                //Row2 after Row1
                if($row->max == $row2->min - 1) {
                    foreach($row2->getTiles() as $tile) $row->insertEnd($tile);

                    unset($this->rows[$id2]);
                } //Row2 before Row1
                elseif($row2->max == $row->min - 1) {
                    foreach(array_reverse($row2->getTiles()) as $tile) $row->insertStart($tile);

                    unset($this->rows[$id2]); 
                }
                else continue;

                $actions[] = "COMBINE $id $id2";
            }
        }

        return $actions;
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

$combineActions = $table->combineRows();

//error_log(var_export($putstone, true));
//error_log(var_export($table, true));

function findTile(Table $table, Tile $tile): array {
    global $availableTiles;

    error_log("We want to find the tile " . $tile->getName());

    //Try to directly take the tile
    foreach($table->getRows() as $id => $row) {

        error_log("trying to directly get it in row $id");

        if($row->canTake($tile)) {
            error_log("we can take the tile " . $tile->getName() . " in row $id");

            $table->remove($id, $tile);

            return [true, [[$table, ["TAKE " . $tile->getName() . " " . $id]]]];
        }
    }

    foreach($table->getRows() as $id => $row) {

        error_log("checking if we could take in row $id");

        $tiles = $row->couldTake($tile);

        if(count($tiles)) {
            error_log("we could take the tile in row $id");

            foreach($tiles as $tileToInsert) {
                if($availableTiles[$tile->color][$tileToInsert->value]) error_log("the tile " . $tileToInsert->getName() . " exist, we can try");
                else {
                    error_log("the tile " . $tileToInsert->getName() . " doesn't exist, we can skip");

                    continue 2;
                }
            }

            $series = [[$table, []]];

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

            if(count($series)) {
                //We have added all the tiles that were missing, we can add the goal tile
                foreach($series as [&$table, &$actions]) {
                    $table->remove($id, $tile);
                    $actions[] = "TAKE " . $tile->getName() . " " . $id;
                }

                return [true, $series];
            }
        }
    }
    
    return [false, [], []];
}

function addTile(Table $table, Tile $tile): array {
    global $availableTiles;

    error_log("We want to add the tile " . $tile->getName());

    //Try to directly add the tile
    foreach($table->getRows() as $id => $row) {

        error_log("trying to directly add it in row $id");

        if($row->canInsert($tile)) {
            error_log("we can add the tile in row $id");

            $table->insert($id, $tile);

            return [true, [[$table, ["PUT " . $tile->getName() . " " . $id]]]];
        }
    }

    foreach($table->getRows() as $id => $row) {
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

            $series = [[$table, []]];

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

            if(count($series)) {
                //We have added all the tiles that were missing, we can add the goal tile
                foreach($series as [&$table, &$actions]) {
                    $table->insert($id, $tile);
                    $actions[] = "PUT " . $tile->getName() . " " . $id;
                }

                return [true, $series];
            }
        }
    }

    return [false, [], []];
}

[, $series] = addTile($table, $goalTile);

error_log("We have " . count($series) . " to solve");

if(count($series) == 0) exit();

usort($series, function($a, $b) {   
    $countA = count($a[1]);
    $countB = count($b[1]);

    return $b <=> $a;
});

[$table, $actions] = array_pop($series);

echo implode("\n", array_merge($combineActions, $actions)) . PHP_EOL;

$table->outputRows();

error_log(microtime(1) - $start);
