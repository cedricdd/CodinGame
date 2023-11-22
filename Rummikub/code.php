<?php

$start = microtime(1);

class Stone {
    public $value;
    public $color;

    public function __construct(string $stone) {
        preg_match("/([0-9]+)([BGRY])/", $stone, $array);

        $this->value = $array[1];
        $this->color = $array[2];
    }

    public function getStoneName(): string {
        return $this->value . $this->color;
    }
}

abstract class Row {
    protected $stones;
    protected $count;
    protected $joker;
    public $display;
    public $type;
}

class Set extends Row {
    private $colors;
    private $value;

    public function __construct(array $stones) {
        $this->type = "set";
        $this->colors = [];
        $this->count = count($stones);

        foreach($stones as $stone) {
            $this->value = $stone->value;
            $this->stones[$stone->getStoneName()] = $stone;
            $this->colors[$stone->color] = 1;
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

    public function canInsert(Stone $stone): bool {
        return !isset($this->colors[$stone->color]) && $stone->value == $this->value;
    }

    public function insert(Stone $stone) {
        $this->colors[$stone->color] = 1;
        $this->stones[$stone->getStoneName()] = $stone;

        $this->count++;

        $this->updateDisplay();
    }

    public function remove(Stone $stone) {
        unset($this->colors[$stone->color]);
        unset($this->stones[$stone->getStoneName()]);

        $this->count--;

        $this->updateDisplay();
    }

    public function canTake(): array {
        if($this->count > 3) return $this->stones;
        else return [];
    }
}

class Run extends Row {
    public $min;
    public $max;
    private $color;

    public function __construct(array $stones) {
        $this->type = "run";
        $this->min = INF;
        $this->max = -INF;
        $this->count = count($stones);

        foreach($stones as $stone) {
            $this->stones[] = $stone;
            $this->color = $stone->color;
            $this->min = min($this->min, $stone->value);
            $this->max = max($this->max, $stone->value);
        }

        $this->updateDisplay();
    }

    public function canInsert(Stone $stone): bool {
        if($this->color == $stone->color) {
            //Adding at the start
            if($this->min - 1 == $stone->value) return true;
            //Adding at the end
            if($this->max + 1 == $stone->value) return true;
            //Adding in the middle and splitting the run
            if($this->count >= 5 && $stone->value >= $this->min + 2 && $stone->value <= $this->max - 2) return true;
        } 

        return false;
    }

    public function updateDisplay() {
        $output = [];

        for($i = $this->min; $i <= $this->max; ++$i) $output[] = $i . $this->color;

        $this->display = implode(" ", $output);
    }

    public function insertStart(Stone $stone) {
        $this->count++;
        $this->min--;

        array_unshift($this->stones, $stone);

        $this->updateDisplay();
    }

    public function insertEnd(Stone $stone) {
        $this->count++;
        $this->max++;

        array_push($this->stones, $stone);

        $this->updateDisplay();
    }

    public function removeStart(): Stone {
        $this->min++;
        $this->count--;

        $stone = array_shift($this->stones);

        $this->updateDisplay();

        return $stone;
    }

    public function removeLast(): Stone {
        $this->max--;
        $this->count--;

        $stone = array_pop($this->stones);

        $this->updateDisplay();

        return $stone;
    }

    public function canTake(): array {
        $stones = [];

        if($this->count > 3) {
            $stones[] = reset($this->stones);
            $stones[] = end($this->stones);
        }

        if($this->count > 6) {
            foreach($this->stones as $stone) {
                if($stone->value >= $this->min + 3 && $stone->value <= $this->max - 3) {
                    $stones[] = $stone;
                }
            }
        }

        return $stones;
    }
}

class Table {
    private $rows;
    private $nextRow;

    public function __construct(array $rows) {
        foreach($rows as $row) {
            $rowID = array_shift($row);

            $colors = [];
            $stones = [];

            foreach($row as $stoneName) {
                $stone = new Stone($stoneName);

                $stones[] = $stone;
                $colors[$stone->color] = 1;
            }

            $this->rows[$rowID] = count($colors) == 1 ? new Run($stones) : new Set($stones);
            $this->nextRow = $rowID + 1;
        }
    }

    public function __clone() {
        foreach ($this->rows as $k => $v) {
            $this->rows[$k] = clone $v;
        }
    }

    public function getHash(): string {
        $hash = [];

        foreach($this->rows as $row) $hash[] = $row->display;

        return implode("-", $hash);
    }

    public function getRows(): array {
        return $this->rows;
    }

    public function remove(int $rowID, Stone $stone) {
        $row = $this->rows[$rowID];

        if($row->type == "set") $row->remove($stone);
        elseif($stone->value == $row->min) $row->removeStart();
        elseif($stone->value == $row->max) $row->removeLast();
        //Splitting a run
        else {
            $stones = [];

            //Update the old row
            while($row->max >= $stone->value) $stones[] = $row->removeLast();

            //Don't copy the stone we take to the new run
            array_pop($stones);

            //Create the new row
            $this->rows[$this->nextRow++] = new Run($stones);
        }
    }

    public function insert(int $rowID, Stone $stone) {
        $row = $this->rows[$rowID];

        if($row->type == "set") $row->insert($stone);
        elseif($stone->value == $row->min - 1) $row->insertStart($stone);
        elseif($stone->value == $row->max + 1) $row->insertEnd($stone);
        //Splitting a run
        else {
            $stones = [$stone];

            //Update the old row
            while($row->max > $stone->value) $stones[] = $row->removeLast();

            //Create the new row
            $this->rows[$this->nextRow++] = new Run($stones);
        }
    }

    public function outputRows() {
        ksort($this->rows);

        foreach($this->rows as $id => $row) echo $id . " " . $row->display . PHP_EOL;
    }
}

$stones[] = new Stone(trim(fgets(STDIN)));


fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $rows[] = explode(" ", trim(fgets(STDIN)));
}

$table = new Table($rows);

//error_log(var_export($putstone, true));
//error_log(var_export($table, true));

$history = [];
$toCheck = [[$stones, $table, []]];

while(count($toCheck)) {
    $newCheck = [];

    error_log("we have " . count($toCheck) . " to check");

    foreach($toCheck as [$stones, $table, $actions]) {

        $hash = $table->getHash();

        if(isset($history[$hash])) {
            error_log("!!!!!!!!!!!!!!!");
            continue;
        }
        $history[$hash] = 1;
    
        if(count($stones) > 0) {
            $stone = array_pop($stones);

            foreach($table->getRows() as $id => $row) {
                if($row->canInsert($stone)) {
                    error_log("we can add the stone in row $id");

                    $tableUpdated = clone $table;
                    $tableUpdated->insert($id, $stone);

                    $actionsUpdated = $actions;
                    $actionsUpdated[] = "PUT " . $stone->getStoneName() . " " . $id;

                    $newCheck[] = [$stones, $tableUpdated, $actionsUpdated];
                }
            }

            $stones[] = $stone;
        } 

        if(count($stones) == 0) {
            echo implode("\n", $actions) . PHP_EOL;

            $table->outputRows();

            error_log(microtime(1) - $start);
            exit();
        }

        if(count($stones) == 1) {
            foreach($table->getRows() as $id => $row) {
                foreach($row->canTake() as $stone) {
                    error_log("on row $id we can take " . $stone->getStoneName());
        
                    $tableUpdated = clone $table;
                    $tableUpdated->remove($id, $stone);
        
                    $actionsUpdated = $actions;
                    $actionsUpdated[] = "TAKE " . $stone->getStoneName() . " " . $id;
        
                    $stones[1] = $stone;
        
                    $newCheck[] = [$stones, $tableUpdated, $actionsUpdated];
                }
            }
        }
    }
    //break;

    $toCheck = $newCheck;
}
