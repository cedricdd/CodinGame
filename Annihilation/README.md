# Puzzle 
**Annihilation** https://www.codingame.com/training/easy/annihilation

# Goal
Starting with an HxW grid at t=0, at each time step the arrows ^v<> move one space up/down/left/right respectively (wrapping around if they go off the edge).  
After each time step, if two or more arrows are in the same position they are all destroyed.  
How many time steps does it take until there are no arrows remaining?  

# Input
* Line 1: H W
* Next H lines: The grid values.

# Output
* The number of time steps until there are no arrows remaining.

# Constraints
* 4 ≤ H,W ≤ 50
