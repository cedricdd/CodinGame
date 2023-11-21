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

class Row {
    private $stones;
    private $type;
    private $colors;
    private $min;
    private $max;

    public function __construct(array $stones) {
        $this->min = INF;
        $this->max = -INF;
        $this->colors = [];

        foreach($stones as $stone) {
            $stone = new Stone($stone);

            $this->stones[] = $stone;
            $this->colors[$stone->color] = 1;
            $this->min = min($this->min, $stone->value);
            $this->max = max($this->max, $stone->value);
        }

        $this->type = $this->min == $this->max ? "set" : "run";
    }

    public function canInsert(Stone $stone): bool {
        if($this->type == "set") return !isset($this->colors[$stone->color]) && $stone->value == $this->min;
        else return isset($this->colors[$stone->color]) && ($this->min - 1 == $stone->value || $this->max + 1 == $stone->value);
    }

    public function insert(Stone $stone) {
        if($this->type == "set") {
            $this->colors[$stone->color] = 1;
            $this->stones[] = $stone;
        }
        else {
            if($this->min - 1 == $stone->value) {
                $this->min--;
                array_unshift($this->stones, $stone);
            } else {
                $this->max++;
                array_push($this->stones, $stone);
            }
        }
    }

    public function output(): string {
        $output = [];

        if($this->type == "set") {
            if(isset($this->colors['B'])) $output[] = $this->min . 'B';
            if(isset($this->colors['G'])) $output[] = $this->min . 'G';
            if(isset($this->colors['R'])) $output[] = $this->min . 'R';
            if(isset($this->colors['Y'])) $output[] = $this->min . 'Y';
        } else {
            $color = array_key_first($this->colors);

            for($i = $this->min; $i <= $this->max; ++$i) $output[] = $i . $color;
        }

        return implode(" ", $output);
    }
}

class Table {
    private $rows;
    private $nextRow;

    public function __construct(array $rows) {
        foreach($rows as $row) {
            $rowID = array_shift($row);

            $this->rows[$rowID] = new Row($row);
            $this->nextRow = $rowID + 1;
        }
    }

    public function getRows(): array {
        return $this->rows;
    }

    public function insert(int $rowID, Stone $stone) {
        $this->rows[$rowID]->insert($stone);
    }

    public function outputRows() {
        ksort($this->rows);

        foreach($this->rows as $id => $row) echo $id . " " . $row->output() . PHP_EOL;
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

$toCheck = [[$stones, $table, []]];

while(true) {
    $newCheck = [];

    foreach($toCheck as [$stones, $table, $actions]) {
    
        if(count($stones) > 0) {
            $stone = array_pop($stones);

            foreach($table->getRows() as $id => $row) {
                if($row->canInsert($stone)) {
                    $tableUpdated = $table;
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
    }

    $toCheck = $newCheck;
}
