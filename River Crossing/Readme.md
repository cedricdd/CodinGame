# Puzzle
**River Crossing** https://www.codingame.com/training/medium/river-crossing

# Goal
There is a farmer, a wolf, a goat and a cabbage.  

They need to cross a river with the following restrictions:
* The farmer can move from one side to the other freely, and can optionally carry one other entity
* The wolf can’t be on the same side with the goat without the farmer
* The goat can’t stay at the same side with the cabbage without the farmer

The river has two sides L for Left and R for Right.

You are given the initial positions and the target positions, in the following order Farmer, Wolf, Goat, Cabbage. 

For example you may be given the positions like so: L L L R which would mean that the farmer, wolf, and goat are on the left side and the cabbage is on the right side.

Without breaking the restrictions, print out the minimum legal states starting at the initial state to get to the target state and including the target state.

FOR MULTIPLE SOLUTIONS  
If there are multiple solutions with the same length, return the one that is alphabetically first.

# Input
* Line 1: 4 letters representing the initial state
* Line 2: 4 letters representing the target state

# Output
* Lines: Solution states, starting with the initial state and ending in the target state

# Constraints
* All problems have a solution, and each solution has fewer than 20 transition states
