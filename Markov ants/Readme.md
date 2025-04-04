# Puzzle
**Markov ants** https://www.codingame.com/training/medium/markov-ants

# Goal
An ant leaves its anthill in order to forage for food, but it doesn't know where to go, therefore every second it moves randomly step cm directly north, south, east or west with equal probability.

You will work with an ascii representation of the anthill, where the initial position of the ant is represented by the letter A, and the borders of the anthill by the characters |, - and + for the corners.  
The distance between each element of the anthill is equal to 1 cm. In this version, the anthill is always a RECTANGLE.

If the food is located at the borders of the anthill, how long will it take the ant to reach it on average (rounded to 1 decimal place)?  

NOTE: The ant reaches its food if it ends on the border of the anthill OR outside the anthill.

The original problem can be found here: https://web.archive.org/web/20220817071104/https://optiver.com/working-at-optiver/career-opportunities/5841549002/

# Input
* Line 1: An integer step.
* Line 2: Two space-separated integers w and h: the width and height of the ascii anthill.
* Next h lines: w characters representing the h-th row of the ascii anthill.

# Output
* The average time (in seconds) it takes the ant to reach its food (a float rounded to 1 decimal place).

# Constraints
* 1 <= step <= 3
* 3 <= w, h <= 15
* The ant always starts INSIDE the anthill (never at the borders or outside).
