# Puzzle
**Lunar Lockout** https://www.codingame.com/training/medium/lunar-lockout

# Goal
Lunar Lockout is a game edited by Binary Arts in 1999.  
The object : To maneuver the Red Spacepod (X) assisted by the Helper-Bots (A, B, C, ...), until it lands on the Emergency Entry Port at the center of the Mothership's Landing Grid.

The Rules:
1) Spacepod and Helper-Bots (both may be described as tokens below) travel between the grid lines, and can only move up (U), left (L), down (D) and right (R).
No diagonal movement is allowed.
2) You can only move a token on the grid if its movement can be blocked by a Helper-Bot or the Spacepod. 
Without this block, the Spacepod or Helper-Bot will jet off the Landing Grid into space --- forever !
3) A move is complete when a moving token lands on the grid square next to the blocking token (the blocking token acts like your brakes).
4) The Spacepod must jet over the Emergency Entry Port unless a blocking token stops the Spacepod from moving further.

Example in video : https://www.youtube.com/watch?v=KXGcwYqiSLM

# Input
* 5 lines The grid

# Output
* Line 1 : The list of moves as shown in the example
* Line 2 : A blank line
* 5 lines : The grid giving the final position of the Helper-Bots and the Spacepod

# Constraints
* The number of Helper-Bots varies between 1 and 5 (A to E).
* If there are several solutions, the shortest one is given.
* If there are still several solutions, we will give the first one in alphabetical order.
