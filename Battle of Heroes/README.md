# Puzzle
**Battle of Heroes** https://www.codingame.com/training/easy/battle-of-heroes

# Goal
Imagine yourself on a battlefield like in the good-old times when you played Heroes of Might and Magic (HoMM).  
The combat is turn-based. Two stacks of units sequentially attack each other until one of them is destroyed.

Combat rules:  
* Stack 1 always attacks first.
* Each stack has a unit name, the total amount of units in stack, the health of 1 unit and the damage dealt by 1 unit.
* Damage is applied to the enemy stack unit by unit. If part of the damage is enough to kill the first unit, the remaining damage is applied to the subsequent unit.
* Units cannot avoid or counter attacks (as they did in HoMM), instead they attack on their turn.
* Combat always starts from Round 1.
* A round ends when both stacks have attacked each other, or when one of the stacks has been eliminated.

# Input
* Each line is a string that consists of stack data separated by; in the following format.
* Data includes: name of units (string);amount of units (integer);health per unit (integer);damage per unit (integer).
* Line 1: Stack 1 data.
* Line 2: Stack 2 data.

# Output
You have to list combat log and announce the winner.
Refer to the example for the exact output format and wordings to use.
Common log section consists of:
* Line 1: Current round number.
* Line 2: Stack 1 attack result (who attacks whom dealing how much damage).
* Line 3: Number of units perished during the attack.
* Line 4: Mid-round separator ----------
* Line 5: If Stack 1 defeats Stack 2 there must be a win message and this line will be the last.
* Line 6: Stack 2 attack result (who attacks whom dealing how much damage).
* Line 7: Number of units perished during the attack.
* Line 8: Round end separator ##########
* Line 9: If Stack 2 defeats Stack 1 there must be a win message and this line will be the last.
  
While both stacks have at least 1 unit the battle continues.

# Constraints
* 3 ≤ length of name ≤ 20
* 1 ≤ amount ≤ 10000
* 1 ≤ health ≤ 300
* 1 ≤ damage ≤ 50
