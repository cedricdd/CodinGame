# Puzzle
**Dice galaxy** https://www.codingame.com/training/medium/dice-galaxy

# Goal
The first numbers were finally born in the universe.  
That is "1".  
In order to keep the balance of the dice galaxy, 6 must be arranged according to the dice law.  

# Rule
Net of cube is "#" or "1" or "6".  
The blank value is ".".  
There is always one "1" in each net.  
When the net is made into a cube, “6” is placed on the opposite side of “1”.  
There may be multiple nets,each nets is not touch.  

The trouble is when "6" is in the wrong place. In that case, fix "6" to the correct place.

Finally, display net that balanced "1" and "6".

# Input
* Line 1: An integer w width
* Line 2: An integer h height
* Next h lines: string line length w

# Output
* h lines: string outline set 6

# Constraints
* 4 ≤ w ≤ 15
* 2 ≤ h ≤ 10
* 4 ≤ line length ≤ 15
