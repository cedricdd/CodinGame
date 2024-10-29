# Puzzle
**Castle Siege** https://www.codingame.com/training/hard/castle-siege

# Goal
This is an implementation of a castle siege on a rectangular map.  
Enemies attempt to reach the castle at the top of the map, while towers attempt to fend them off.

Each round of the game has the following three phases:

1. Each tower targets a single enemy within a 5×5 square centred on itself, if any.

Towers prioritise targets by the following criteria, in order of precedence. Each criteria is used to break ties of the above criteria.

Criteria:  
* The enemy furthest NORTH
* The enemy closest to the tower
* The enemy furthest EAST


2. Each enemy's HP is reduced by the number of towers that targeted it. Then, each enemy that has 0 or less HP is DESTROYED. Then, if no enemies remain, the player WINS.

3. Each enemy moves NORTH one cell. If an enemy moves into a tower this way, the enemy is DESTROYED. If an enemy moves off the top of the map, the player LOSES.

You must output WIN/LOSE followed by the round number when the game ended.

# Input
* Line 1: The width W and the height H of the map.
* Next H Lines: Strings W characters long, representing entities in each cell of the initial state of the map. Entities are represented by the following characters:
    * . Empty Space
    * N An enemy with N HP
    * T A Tower

# Output
* A single line containing the WIN/LOSE state of the game State (either 'WIN' or 'LOSE') followed by the round number R (starting from 1) when the game ended.

# Constraints
* 0 ≤ N ≤ 9
* 1 ≤ W, H ≤ 8
