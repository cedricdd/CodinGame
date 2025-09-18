# Puzzle
**Pips** https://www.codingame.com/contribute/view/13396223d8a613f63164fae35b4379894c8bb7

# Goal
You are given a board with predefined cells where domino tiles must be placed. Some areas of the board come with special constraints (described in Rules section). Your task is to correctly place all given dominoes so that every condition is satisfied.

The board has a variable size and contains marked regions. Each marked region will be subject to one of the following constraints:
* \==: all cells must contain the same value.
* \!=: all cells must contain unique values.
* \> ruleValue: the sum of the cells must be greater than ruleValue.
* \< ruleValue: the sum of the cells must be less than ruleValue.
* \= ruleValue: the sum of the cells must be exactly ruleValue.

You will receive a board description, a set of rules to satisfy, and a set of unique domino pieces. Each domino is rotated 0, 1, 2, or 3 times as needed before being placed on the board. Find out more in Game input section.  
The board's top-left position is [0, 0].  
Example of a solved puzzle where all rules are satisfied.  

## Victory Conditions
* Place all dominoes on the board so that all rules are satisfied.

## Loss Conditions
* You fail to output a solution within the time limit.
* You do not place all the dominoes.
* You attempt to place a domino that does not exist or has already been placed.
* You provide an unrecognized orientation.
* You specify an invalid x,y combination (out-of-bounds or already occupied cell).
* Your final domino placement violates at least one rule.

# Input
* Line 1: 2 space separated integers height and width of the board.
* Next height lines: width space separated integers = cell descriptions depicting the board (-1 = unavailable cell; 0 = cell without any rule; ruleId otherwise)
* Next line: single integer rulesCount
* Next rulesCount lines: space separated ruleId, rule, ruleValue
  * 1 ≤ ruleid ≤ rulesCount.
  * rule is ==, !=, >, < or =.
  * ruleValue is a non-negative integer for >, < and = rules, and it is -1 for == and != rules.
* Next line: dominoesCount - the number of available dominoes.
* Next dominoesCount lines: 2 space-separated integers a b as number of pips on current domino piece

# Output
* dominoesCount lines: 5 space-separated integers a b x y orientation (0 = horizontal, 1 = vertical)
  * a and b are the number of pips on the two halves of a domino piece.
  * [x, y] is the position where the half with a is placed.
  * If orientation = 0 (horizontal), the half with b is placed at [x + 1, y].
  * If orientation = 1 (vertical), the half with b is placed at [x, y + 1].

# Constraints
* 1 ≤ height, width ≤ 10
* 1 ≤ rulesCount ≤ 20
* 1 ≤ dominoesCount ≤ 20
* Allotted response time to output solution is ≤ 5s
