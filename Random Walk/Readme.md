# Puzzle
**Random Walk** https://www.codingame.com/training/easy/random-walk

# Goal
Starting at coordinates (0,0) with D[0]=0, a random direction generator D[n+1] = (a*D[n]+b) mod m tells you which direction to go next   
(where D mod 4=0,1,2,3 indicates Up, Down, Left, Right). How many steps does it take to get back to (0,0)?  

# Input
* Line 1: a
* Line 2: b
* Line 3: m

# Output
* The number of steps.

# Constraints
* 1 ≤ a,b,m ≤ 100,000
* steps ≤ 500,000
