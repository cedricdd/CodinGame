# Puzzle
**Find a safe place** https://www.codingame.com/contribute/view/11924469afefb72da0fd14a9629ebffdb4d81d

# Goal
Hero is surrounded by monsters in a deep dungeon. He is exhausted and injured, so he can't fight. Hero has a medical kit, but he can't use it if monsters are attacking him. Your goal is to help him find a safe place where monsters can't attack him.

You will be given an ASCII representation of the dungeon map, where:  
* H is hero
* Digit from 1 to 9 is monster. Its speed equals this digit.
* X is empty space

Each monster can move as many squares per turn as its speed. If a monster ends adjacent to a hero, the hero will be attacked. Monsters can't attack or move diagonally.  
Hero has no movement limitation.  
You must find the cell which can't be attacked by monsters at the end of this turn and output coordinates of this cell (top left corner is (0,0)). If there are several such cells, print the coordinates of the one closest to the hero.

Example:
```
XXX
1XX
XXX
```
1 is the enemy.

```
OXX
1OX
OXX
```
It can move on cells marked as O.

```
OAX
1OA
OAX
```
It can attack cells marked as A.

So the cells (2,0) and (2,2) are safe.

# Input
* Line 1: n, which is side of square dungeon map
* Next n lines: ASCII representation of this map

# Output
* A single line containing coordinates of the closest safe cell to the hero in format (x,y)

# Constraints
* 0 < n < 16
* It is guaranteed that there is at least one safe cell in each case.
* There won't be cases when there are several safe cells which are of equal distance to the hero.
