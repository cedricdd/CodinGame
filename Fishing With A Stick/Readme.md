# Puzzle
**Fishing With A Stick** https://www.codingame.com/training/medium/fishing-with-a-stick

# Goal
Your goal is to count how many fish you have caught.  
You are fishing in a water with an altitude of H and a length of W and a current pointing towards currentD with a very cheap fishing rod, it is broken by touching any garbage, but at least it is used to catch fish.

*INFORMATION:*  
* ".": water
* ">": a fish that goes to the right
* "<": a fish that goes to the left
* "|": fishing rod
* "C": hook. If it is just below the fishing rod or if it is the first "C" in the first row and there is no "|", it is considered to be the fishing rod, otherwise it is garbage.
* any other character: garbage

*RULES:*  
1) Fishing rod:
  * Fish can touch any part of your fishing rod to be caught
  * If the trash touches the fishing rod it breaks (you can not fish anymore)
  * If garbage and fish touch the fishing rod at the same time, fish is caught (and then the rod breaks)
  * There always has to be a hook
2) Fish:
  * Fish can move in both directions regardless of the current
  * If two fish collide with each other, they get stuck (they stop moving and disappear)
  * The fish die when colliding with the garbage (the fish and garbage stop moving and disappear)
3) Garbage:
  * Trash moves in the direction of the current

# Input
* Line1: H Height
* Line2: W Width
* Line3: currentD current direction
* H Lines: row string

# Output
* The number of fish caught

# Constraints
* 0 < H < 256
* 0 < W < 256
* currentD = LEFT(right to left) or RIGHT(left to right)
