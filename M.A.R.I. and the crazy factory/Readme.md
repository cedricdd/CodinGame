# Puzzle
**M.A.R.I. and the crazy factory** https://www.codingame.com/training/hard/m-a-r-i--and-the-crazy-factory

# Goal
M.A.R.I. is a Mobile Autonomous Robotic Intelligence who works in a factory.  
After a thunder storm, the factory has gone crazy and you need to help her fixing it, crossing the factory to the last room where the central command is.  

Instructions  
Here are M.A.R.I.’s instructions:  
* p1 Go 1 square forward
* p2 Go 2 squares forward
* nop Do nothing (use it only as the last instruction of a set)
* tl Turn left
* tr Turn right
* bk Drop the remaining instructions in the set (can be used as nop if it is the last instruction of a set)
* x2 Run twice the next instruction
* uk Use key (to slide the door)
* zl Turn left then acts like a zr
* zr Turn right then acts like a zl

*How to play*  
But M.A.R.I. is also a bit messed up.  
You are given a list of instructions but you must play them one by one in a specific way.  
When you use an instruction from the list, it’s popped out of the list and M.A.R.I. runs the complete set of instructions from the beginning of the set, not only the one you used.  
An instruction can only be used once, or twice if it’s listed twice.  
You can insert the new instruction wherever you want.  
You might not use all the instructions.  
The first instruction is already in the set but you must use a new instruction to move M.A.R.I.  
If the instruction list begins with a space, no instruction is already in the set.  

Example  
The solution of the first room is p2/p1 p2/p1 tr p2. But why?  
The instructions list is p1 tr p2, that starts with a space. Thus, the first set will be empty before you play the first instruction.  
First set, you play p2. She has not reached the exit so you must use another instruction.  
Second set, you insert p1 before p2, M.A.R.I. must execute p1 p2. Still not on the exit.  
Third set, finally you insert tr between p1 and p2, follows p1 tr p2. M.A.R.I. reaches the exit when p2 ends. Well done!  
Just write these six instructions, each set on a line.  

*The rooms*  
Each room is 5 squares wide and 7 squares high. M.A.R.I. must not step out of the room!  
Here is the meaning of the squares:  
* \# Wall, do not bump into.
* . Empty square.
* 0 north 1 east 2 south 3 west is the initial position and direction of M.A.R.I.
* E The exit where you need to end a set of instructions to finish the game.
* G A gear unfortunately fallen on the ground. You can only push it to an empty square (like sokoban) but not step on it.
* k A key. If this tile is present, you need to grab it to finish the game or to slide the door; and to end an instruction on it to grab it (beware of p2).
* dd Sliding door that can move 1 square on the r. rdd becomes ddr and vice-versa. Don’t crush M.A.R.I. when she is on the railway!
* r Railway for the door, you can walk on it if the door is not there. If the door has slid, the square where the door was is now a railway.

# Input
* Line 1: The available instructions
* Next 7 lines: The room

# Output
* The instructions that bring M.A.R.I. to the exit, one line by set

# Constraints
* Each room has got only one solution if nop is used as the last instruction of a set.
