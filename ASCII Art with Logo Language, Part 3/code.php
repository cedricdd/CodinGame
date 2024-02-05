<?php

class Logo {
    private $angle;
    private $pen;
    private $symbols;
    private $coordinates;
    private $background;
    private $grid;

    function __construct() {
        $this->angle = 90;
        $this->pen = 1;
        $this->symbols = ["characters" => "#", "index" => 0];
        $this->coordinates = [0, 0];
        $this->background = " ";
        $this->grid = [];
    }

    //Turtle is changing direction
    public function changeAngle(int $angle) {
        $this->angle = ($this->angle + $angle + 360) % 360;

        //error_log("Angle is now: " . $this->angle);
    }

    //We have run all the commands, print the logo
    public function draw() {
        //We need the coordinates of the top left & bottom right of the art generated
        $minY = min(array_keys($this->grid));
        $maxY = max(array_keys($this->grid));
        $minX = INF;
        $maxX = -INF;

        foreach($this->grid as $y => $line) {
            $minX = min(min(array_keys($line)), $minX);
            $maxX = max(max(array_keys($line)), $maxX);
        }

        $width = $maxX - $minX + 1;

        for($y = $minY; $y <= $maxY; ++$y) {
            $line = str_repeat($this->background, $width);

            foreach($this->grid[$y] ?? [] as $x => $c) $line[$x - $minX] = $c;

            echo rtrim($line) . PHP_EOL;
        }
    }

    //Turle is moving
    public function move(int $turns) {
        [$x, $y] = $this->coordinates;
        $radiant = deg2rad($this->angle);
        [$x1, $y1] = [$x + round(($turns - 1) * cos($radiant), 0, PHP_ROUND_HALF_UP), $y + round(($turns - 1) * sin($radiant), 0, PHP_ROUND_HALF_UP)];

        //Pen is down, add symbol
        if($this->pen) {

            [$x0, $y0] = [$x, $y];

            //https://en.wikipedia.org/wiki/Bresenham%27s_line_algorithm
            $dx = abs($x1 - $x0);
            $sx = ($x0 < $x1) ? 1 : -1;
            $dy = -abs($y1 - $y0);
            $sy = ($y0 < $y1) ? 1 : -1;
            $error = $dx + $dy;

            while (true) {
                $this->grid[$y0][$x0] = $this->symbols["characters"][$this->symbols["index"]];
                $this->symbols["index"] = ($this->symbols["index"] + 1) % strlen($this->symbols["characters"]);

                if ($x0 == $x1 && $y0 == $y1) break;

                $e2 = 2 * $error;

                if ($e2 >= $dy) {
                    if ($x0 == $x1) break;
                    $error = $error + $dy;
                    $x0 = $x0 + $sx;
                }
                if ($e2 <= $dx) {
                    if ($y0 == $y1) break;
                    $error = $error + $dx;
                    $y0 = $y0 + $sy;
                }
            }
        }

        $this->coordinates = [$x + round($turns * cos($radiant), 0, PHP_ROUND_HALF_UP), $y + round($turns * sin($radiant), 0, PHP_ROUND_HALF_UP)];
    }

    //Set background of the logo
    public function setBackground(string $value) {
        $this->background = $value;
    }

    //Set the status of the pen
    public function setPen(int $value) {
        $this->pen = $value;
    }

    //Set the characters used by the pen
    public function setSymbols(string $value) {
        $this->symbols["characters"] = $value;
        $this->symbols["index"] = 0;

        error_log("Symbol is now $value");
    }
}

function getExpressionValue(string $expression, array $variables): float {
    //error_log("Expression is: $expression");

    //Replace all the variables
    preg_match_all("/:([a-z]+)/", $expression, $matches);

    //error_log(var_export($matches, true));

    foreach($matches[1] as $match) {
        $expression = str_replace(":" . $match, $variables[$match], $expression);
    }

    return eval("return $expression;");
}

function runProcedure(string $name, float $value, array $variables) {
    global $procedures;

    error_log(var_export($variables, true));

    [$param, $procedure] = $procedures[$name];
    $variables[$param] = $value;

    parse($procedure, $variables);
}

function parse(string $input, array &$variables) {
    global $logo, $procedures;

    $input = trim($input);
    if(empty($input)) return;

    $command = "";
    $count = 0;

    //Make sure the input ends with ;
    if($input[-1] != ";") $input .= ";";

    //error_log(var_export($input, true));

    foreach(str_split($input) as $index => $c) {

        switch($c) {
            case "[": ++$count; break;
            case "]": --$count; break;
            case ";": 
                if($count == 0) {
                    $command = trim($command);
                    $cmd = substr($command, 0, 2);

                    error_log($command);

                    if(strcasecmp($cmd, "RT") == 0) $logo->changeAngle(getExpressionValue(substr($command, 3), $variables) * -1); //Turning right
                    elseif(strcasecmp($cmd, "LT") == 0) $logo->changeAngle(getExpressionValue(substr($command, 3), $variables)); //Turning left
                    elseif(strcasecmp($cmd, "SE") == 0) $logo->setSymbols(substr($command, 6)); //Changes the symbols printed
                    elseif(strcasecmp($cmd, "FD") == 0) $logo->move(getExpressionValue(substr($command, 3), $variables)); //Turtle is moving
                    elseif(strcasecmp($cmd, "MK") == 0) {
                        [$name, $expression] = explode(" ", substr($command, 4));

                        $variables[$name] = getExpressionValue($expression, $variables);
                    } elseif(strcasecmp($cmd, "RP") == 0) {
                        preg_match("/^RP (.+)\s\[(.*)\]$/i", $command, $matches);

                        //error_log(var_export($matches));

                        $count = getExpressionValue($matches[1], $variables);

                        for($i = 0; $i < $count; ++$i) {
                            parse($matches[2]);
                        }
                    } elseif(strcasecmp($cmd, "IF") == 0) {
                        preg_match("/(.*) ([<=>]+) (.*) \[(.*)\]/", substr($command, 3), $matches);

                        if($matches[2] == "=") $matches[2] = "==";

                        $check = getExpressionValue($matches[1], $variables) . $matches[2] . getExpressionValue($matches[3], $variables);

                        error_log("Checking $check");

                        if(eval("return (" . $check . ") ? 1 : 0;")) {
                            if(strcasecmp($matches[4], "stop") == 0) return;
                            else parse($matches[4], $variables);
                        }
                    } //It's a procedure
                    else {
                        [$name, $expression] = explode(" ", $command);

                        if(!isset($procedures[$name])) {
                            error_log("$index undefined command: " . $command);
                            exit();
                        }

                        $value = getExpressionValue($expression, $variables);

                        error_log("Calling procedure $name with $value");
                        runProcedure($name, $value, $variables);
                    }

                    /*

                    elseif(strcasecmp($cmd, "PU") == 0) $logo->setPen(0); //PENUP
                    elseif(strcasecmp($cmd, "PD") == 0) $logo->setPen(1); //PENDOWN
                    
                    
                    elseif(strcasecmp($cmd, "CS") == 0) $logo->setBackground(substr($command, 3)); //Changes the background
                    
                    */

                    $command = "";
                    continue 2;
                }
                break;
        }

        $command .= $c;
    }
}

$logo = new Logo();
$command = "";
$variables = [];

fscanf(STDIN, "%d", $n);
for ($i = 0; $i < $n; $i++) {
    $input = trim(fgets(STDIN));

    if($input[-1] != ";") $input .= ";"; //Make sure it ends with ";"

    $command .= $input;
}

//Extract all the procedures
preg_match_all("/TO .*END;/iU", $command, $procedureMatches);

foreach($procedureMatches[0] as $procedure) {
    error_log("Procedure: " . substr($procedure, 3, -4));

    preg_match("/^([a-zA-Z_]+) :([a-zA-Z_]+);(.*)$/", substr($procedure, 3, -4), $matches);

    $procedures[$matches[1]] = [$matches[2], $matches[3]];

    $command = str_replace($procedure, "", $command);
}

error_log(var_export($procedures, true));

parse($command, $variables);
$logo->draw();
