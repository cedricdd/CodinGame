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
}

class Run extends Row {
    public $min;
    public $max;
    private $color;

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

//error_log(var_export($putstone, true));
//error_log(var_export($table, true));

function addTile(Table $table, Tile $tile): array {

    //Try to directly add the tile
    foreach($table->getRows() as $id => $row) {
        if($row->canInsert($tile)) {
            error_log("we can add the stone in row $id");

            $table->insert($id, $tile);

            return [$table, ["PUT " . $tile->getName() . " " . $id]];
        }
    }

    foreach($table->getRows() as $id => $row) {
        $tiles = $row->couldInsert($tile);

        if(count($tiles)) {
            error_log("we could add the stone in row $id");
            error_log(var_export($tiles, true));
        }
    }

    exit("!!!!!!!!!!");
}

[$table, $actions] = addTile($table, $goalTile);

echo implode("\n", $actions) . PHP_EOL;

$table->outputRows();

error_log(microtime(1) - $start);
