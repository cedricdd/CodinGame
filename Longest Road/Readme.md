# Puzzle
**Longest Road** https://www.codingame.com/training/medium/longest-road

# Goal
Determine which player in a rectangular "Settlers of Catan" themed game board has the longest road.

Given an ascii game board:
```
aa##b
#A##B
#aa#b
##a##
```

The lower case letters "a" denote a road belonging to player A.  
Uppercase letters denote a settlement.  

If a player has at least 5 consecutive (non-repeating) roads then they can be awarded the "longest road" victory points.  
Roads connected diagonally are not considered consecutive. Roads can be linked together by settlements, but the settlements do not count towards the total length of the player's roads.  
In the above example player A would have the longest road with a length of 5.  

The input will never include the case where multiple players are tied for longest road.  

Loops and branches  
A road may form a loop or branch out in multiple directions.   
In all cases the longest possible consecutive link of roads is used to determine the players' longest roads.  

Inspired by the board game "Settlers of Catan" by Klaus Teuber.  
Image by dograapps from Pixabay.  

# Input
* Line 1: Integer n the length of the square board.
* Next n lines: String of characters representing the game board. # represents an open space. 
* Lowercase letters represent roads, and uppercase letters represent settlements.

# Output
* Output the capital letter of the player with the longest road, and the length of the road, e.g. A 6.
* If no player has the longest road then output the number 0.

# Constraints
* 5 ≤ n ≤ 10
