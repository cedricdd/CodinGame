# Puzzle
**DDCG Mapper** https://www.codingame.com/training/medium/ddcg-mapper

# Goal
Your program must automate the create of maps for the new game "Dance Dance CodinGame". In this game, the player must push 4 keys in rhythm.

One map is composed of lines of 4 characters each: a zero (0) indicates that the corresponding key is released, a cross (X) indicates that the corresponding key is pushed.

You are given the patterns of lines Pattern and their tempo Tempo. You must reproduce the pattern every Tempo lines.  
If one line has no pattern, it is composed of 4 zeros: 0000.  
If one line has multiple patterns, you must accumulate cross. For example, XX00 and X0X0 becomes XXX0.  

Warning: the map starts from the bottom to the top!

# Input
* Line 1: The length L of the map.
* Line 2: The number N of pair Pattern Tempo.
* N next lines: A string Pattern and a number Tempo.

# Output
* L lines representing the map.

# Constraints
* 0 < L < 100
* 0 < N < 10
* 0 < Tempo < 100
