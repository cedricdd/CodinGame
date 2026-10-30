## Puzzle
**Hunt the Mumpus** https://www.codingame.com/training/medium/hunt-the-mumpus

# Goal
You must explore a dark cave system and slay the fearsome creature known as the Mumpus.  
Each turn, you must decide whether to move to or shoot into an adjacent room.  
Avoid hazards, identify the location of the Mumpus, and shoot your arrow into that room to win.  

* The cave consists of interconnected rooms.
* Each room has exactly three exits leading to other rooms.
* Some rooms may contain one of these hazards:
 * Bats: they will carry you to another room.
 * Shaft: a bottomless pit; falling into one means instant death.
 * The Mumpus: entering its room is fatal… unless you shoot it first.
* You can only move to or shoot into adjacent rooms.
* A room can contain at most one hazard (bats, shaft, or Mumpus.)
* If you enter a room with bats, they will carry you to a different room and then disappear.
* Entering a room with a shaft or the Mumpus results in death; you lose the game.
* You only have one arrow.
* If you shoot the arrow into the room containing the Mumpus, you will slay it and win the game.
* If you shoot the arrow into any other room, the arrow will be lost and you lose the game.
* You cannot see hazards directly, but you receive clues when you are near them, along with a console message:
 * You hear the flapping of wings → bats are nearby
 * You feel a draft → a shaft is nearby
 * You smell a Mumpus → the Mumpus is nearby
* Each clue only indicates that at least one adjacent room contains that hazard.
* A room may contain any combination of clues.
 * For example, receiving both a draft and a Mumpus smell means that at least one adjacent room contains a shaft and one adjacent room contains the Mumpus.
* If you do not receive any clues in a room, then all three adjacent rooms are safe to move to.
* The starting room and all of its adjacent rooms will always be free of hazards.
* None of the hazards will ever move on their own.
* All of the test cases and validators can be solved without guessing.

* Bats will drop you into a random hazard-free room. They will take you to an empty room that you have not explored yet, if one exists.
* Otherwise, the bats will drop you into a safe explored room.
* Bats will never drop you directly on another hazard. However, being dropped in an unfamiliar area can be dangerous.
* After transporting you, the bats fly out of the cave, leaving the original room unoccupied.
* The cave topology varies, but every cave follows these rules:
 * All rooms are connected. Ignoring hazards, every room can be reached from every other room.
 * Every room has exactly three exits.
 * The cave graph contains no triangles. (Equivalently, no cycles of length three.) 
* Room IDs are arbitrary; the numbering of rooms does not convey any information about the cave layout.
* You can view room numbers by toggling the option in SETTINGS

# Input
* Line 1: Three space-separated integers:
 * roomCount: number of rooms
 * batsCount: number of rooms containing bats
 * shaftsCount: number of rooms containing shafts

# Input for a game round
* Line 1: One integer: your current room number
* Line 2: Three space-separated integers: the room IDs of the three adjacent rooms (in ascending numerical order)
* Line 3: Three space-separated integers:
 * bats: 1 if at least one adjacent room contains bats, 0 otherwise
 * shaft: 1 if at least one adjacent room contains a shaft, 0 otherwise
 * mumpus: 1 if the Mumpus is in an adjacent room, 0 otherwise

# Output
* One of the following commands:
  * MOVE roomId //Move to one of the adjacent rooms, roomId must be one of the adjacent room IDs given for the current room
  * SHOOT roomId // Shoot your arrow into an adjacent room. roomId must be one of the adjacent room IDs given for the current room

# Constraints
* 8 <= roomCount <= 30
* 0 <= batsCount <= 11
* 0 <= shaftsCount <= 6
* 0 <= roomId < roomCount
* You lose if you provide invalid input.
* You lose if you have not slain the Mumpus after 200 turns
