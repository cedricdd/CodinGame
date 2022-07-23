<?php

class BoardGame {
    private $players;
    private $rolls;
    private $playing = 0;

    public function __construct(array $players, array $rolls) {
        $this->players = $players;
        $this->rolls = $rolls;
        $this->playing = array_shift($players);
    }

    //Switch to the next player
    private function nextPlayer() {
        $this->playing = $this->players[($this->playing->getId() + 1) % count($this->players)];
    }

    //Run the game
    public function play() {

        foreach($this->rolls as $rolls) {
            list($r1, $r2) = $rolls;
            $double = $r1 == $r2;

            $this->playing->increaseThrowCount();

            //Current player is in jail
            if($this->playing->isJailed()) {
                //Player stays in jail
                if(!$double && $this->playing->getThrowCount() != 3) {
                    $this->nextPlayer();
                    continue;
                } //Player leaves jail
                else {
                    $this->playing->leaveJail();
                }

                //You can't roll multiple time when leaving jail
                $double = false;
            }

            //Player rolled a double 3 times in row
            if($double && $this->playing->getThrowCount() == 3) {
                $this->playing->goToJail();
                $this->nextPlayer();
                continue;
            }

            //Player moves
            $this->playing->move($r1 + $r2);

            //Player can't roll again
            if($double == false || $this->playing->isJailed()) {
                $this->playing->resetThrowCount();
                $this->nextPlayer();
            }
        }
    }

    public function printResult() {
        foreach($this->players as $player) echo $player->toString() . "\n";
    }
}

class Player {

    private $id;
    private $name;
    private $position;
    private $jailed = 0;
    private $throwCount = 0;

    public function __construct(int $id, string $name, int $position) {
        $this->id = $id;
        $this->name = $name;
        $this->position = $position;
    }

    public function getId() {
        return $this->id;
    }

    public function getThrowCount() {
        return $this->throwCount;
    }

    public function goToJail() {
        $this->position = 10;
        $this->jailed = 1;
        $this->throwCount = 0;
    }

    public function increaseThrowCount() {
        $this->throwCount++;
    }

    public function isJailed() {
        return $this->jailed;
    }

    public function leaveJail() {
        $this->jailed = 0;
    }

    public function move(int $positions) {
        $this->position = ($this->position + $positions) % 40;

        if($this->position == 30) $this->goToJail();
    }

    public function toString() {
        return $this->name . " " . $this->position;
    }

    public function resetThrowCount() {
        $this->throwCount = 0;
    }
}

fscanf(STDIN, "%d", $P);
for ($i = 0; $i < $P; $i++) {
    $player = explode(" ", stream_get_line(STDIN, 256 + 1, "\n"));
    $players[] = new Player($i, $player[0], $player[1]);
}

fscanf(STDIN, "%d", $D);
for ($i = 0; $i < $D; $i++) {
    $diceRolls[] = explode(" ", stream_get_line(STDIN, 256 + 1, "\n"));
}

for ($i = 0; $i < 40; $i++) {
    $boardline = stream_get_line(STDIN, 256 + 1, "\n");
}

$game = new BoardGame($players, $diceRolls);
$game->play();
$game->printResult();
?>
