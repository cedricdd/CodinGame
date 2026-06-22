## Puzzle
**Hunt the Mumpus** https://www.codingame.com/contribute/view/149670100d88410d82be501bbcc2bab50f638d

# Goal
You must explore a dark cave system and slay the fearsome creature known as the Mumpus with your trusty arrow.

* The cave consists of interconnected rooms. Each room has exactly three exits leading to other rooms. Some rooms may contain:
  * Bats: they will carry you to another room.
  * Shaft: a bottomless pit; falling into one means instant death.
  * The Mumpus: entering its room is fatal… unless you shoot it first.
* You can only move or shoot into adjacent rooms
* Entering a room with a shaft or the Mumpus results in death
* If you enter a room with bats, they will carry you to a different room
* If your arrow hits the Mumpus, you win
* If your arrow misses, you lose
* You cannot see hazards directly, but you receive clues when you are near them:
  * You hear the flapping of wings → a bat is nearby
  * You feel a draft → a shaft is nearby
  * You smell a Mumpus → the Mumpus is nearby
* Each clue only indicates that at least one adjacent room contains that hazard.

* Bats will attempt to drop you into a random unexplored room
* If no suitable unexplored rooms exist, bats will drop you in an explored room
* Bats will never drop you directly on another hazard, however, being dropped in an unfamiliar area can easily be fatal
* After transporting you, the bat flies away, leaving the original room unoccupied
* The topology of the caves is not known, but it is guaranteed that none of the tunnels form a triangle. i.e., if A connects to B and B connects to C, then C will not connect to A

Each turn, you must decide whether to move or shoot into an adjacent room.

Be careful: due to poor planning, you only have one arrow.

# Input
* Three integers:
  * roomCount: number of rooms
  * batsCount: number of rooms containing bats
  * shaftsCount: number of rooms containing shafts

# Input for a game round
* One integer: currentRoom: your current room number
* Three integers: a b c: the three adjacent rooms
* Three integers (0 or 1):
  * bats: 1 if at least one adjacent room contains bats
  * shaft: 1 if at least one adjacent room contains a shaft
  * mumpus: 1 if the Mumpus is in an adjacent room

# Output
* One command:
  * MOVE roomId (Move to one of the adjacent rooms)
  * SHOOT roomId (Shoot your arrow into an adjacent room)

# Constraints
* 8 <= roomCount <= 64
* 0 <= batsCount <= 8
* 0 <= shaftsCount <= 8
* The game ends after 200 turns
