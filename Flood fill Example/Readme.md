# Puzzle
**Flood fill Example** https://www.codingame.com/training/medium/flood-fill-example

# Goal
The Resistance have made a map of Alderaan, the planet they are currently settled in.   
They have put defence towers with heavy armaments on specific places in their base.   
Princess Leia has asked for a map showing which defence tower is to operate when an enemy lands.  

This map works on the following principle: whichever defence tower is closest to the spot where the enemy have landed, will operate.   
C3PO and R2D2 have been assigned the job of drafting this map. You must help them...

Of course, to make your job simpler, the map provided has been highly simplified to spots where enemy can land, and those where they can't.

*The Problem:*  
Given a grid consisting of ‘.’ (visitable points) and ‘#’ (un-visitable points), and other entities for the defence towers, output a map showing the area coverage of each tower, based on distance.

# Rules
1. Each tower has an I.D., which is not '#', '.' or '+'. Note that 2 towers may have the same I.D..
2. If 2 towers can reach a spot at the exact same time, mark that spot '+', even if both towers share the same I.D..
3. Towers can't send troops through un-visitable spots ('#').
4. If a tower can get to a spot first, mark the spot by its I.D..
5. This is the legend:
    * '.' = reachable nodes
    * '#' = unreachable nodes
    * any other character = a tower's I.D.
6. Troops sent out by the towers at a particular spot can immediately move by distance 1 in the cardinal directions, i.e. UP, DOWN, LEFT, RIGHT (diagonals not possible).
7. If a spot on the map cannot be accessed (regardless of whether it is visitable or not) assign that spot with the character it had in the original map.

# Input
* Line 1: An integer W, the width of the map
* Line 2: An integer H, the height of the map
* Next H lines: W characters in each line, the map

# Output
* First H lines: W characters in each line, the resulting map

# Constraints
* 1 ≤ W, H ≤ 30
