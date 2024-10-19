# Puzzle
**Azimut** https://www.codingame.com/training/easy/azimut

# Goal
Your companion on the other side of the phone is exploring a maze, however they don't have a compass! Can you help determine what direction they are facing after a succession of turns?

Directions are given in cardinal and ordinal directions:  
N, NE, E, SE, S, SW, W, and NW

Your companion can either turn:  
- RIGHT : 45° clockwise (e.g. : N -> NE)  
- LEFT : 45° counter- clockwise (e.g. : N -> NW)  
- BACK : 180° (e.g. : N -> S)  
- FORWARD : 0° (e.g. : N -> N)  

# Input
* First line : A string startDirection giving the initial direction your companion is facing.
* Second line : An integer N giving the number of directions your companion takes
* N following lines : A string containing either RIGHT, LEFT, BACK, or FORWARD

# Output
* Line 1: A string containing the final direction your companion is facing.

# Constraints
* 1 <= N <= 15