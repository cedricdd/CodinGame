# Puzzle
**Light Bulbs** https://www.codingame.com/training/medium/light-bulbs

# Goal
You are given a row of N light bulbs, represented by a string of 0 or 1, totally N characters in the string.  
0 means the light bulb is OFF.  
1 means the light bulb is ON.  

The left-most character is light bulb 1.  
The right-most character is light bulb N.  

Each light bulb has an independent switch allowing you to switch it ON or OFF.  

To switch ON/OFF any light bulb, there are two rules:
* Rule 1 You can change the state of light bulb i if i+1 is ON AND i+2, i+3,... N are OFF.
* Rule 2 Rule 1 does not apply to light bulb N, which can be switched ON/OFF at will.

The game starts with a given lighting pattern.  
You will also have a target lighting pattern.  

Find the minimum number of switches needed to change the pattern from start to target.

Example  
To change pattern from 1101 to 0100  
```
1101 (start)
1100 (switch #4, by Rule 2)
0100 (switch #1, by Rule 1) - reached target by switching 2 times.
```

# Input
* Line 1: Start pattern - a string of 0 or 1, totally N characters
* Line 2: Target pattern - a string of 0 or 1, totally N characters

# Output
* Line 1: The minimum number of switching needed to change the lighting pattern from start to target.

# Constraints
* 1 ≤ N ≤ 25
