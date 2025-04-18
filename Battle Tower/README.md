# Puzzle
**Battle Tower** https://www.codingame.com/training/medium/battle-tower

# Goal
NineTenTwo is inviting leading constructors to design and construct the Battle Tower in a Pokemon theme park planning to be built.

Basic requirements are released. The Battle Tower itself is a maze, composed of multiple arenas called cells, interconnected by corridors.  
Players will walk into a cell, complete a mission or battle, then select a corridor to walk to another cell.  
Repeat it until they have finished enough missions or battles, or found a way to exit early. 

*Specifications*
1. All cells are interconnected by corridors.
2. There is no loop between the cells and no self-loop in any cell.
3. To avoid people being trapped in the maze and also to keep people safe, there must have enough emergency exits scattered around in the Tower.
   
Emergency exits are short-cut ways to get out of the Building, directly leading people to the ground.

To comply with Fire Safety Regulations...  
1. All emergency exits are installed in the cells. Corridors do not have emergency exit.
2. At least one end of a corridor must connect to a cell with an emergency exit.
3. Complying with above regulations means that if a cell is not adjacent to a cell with an emergency exit, then it must have one.

Installing emergency exit in every cell is one of the possible solutions but it is too costly and brainless.

NineTenTwo provided some sample blueprints of the Tower. To filter away poor quality tendering, only those companies which can figure out the minimum number of emergency exits necessary for each blueprint will be qualified. Can you do it?

# Input
* Line 1: An integer N for the number of cells.
* Next N lines: Each line describes the structure of one cell.
* The first integer is the ID of the cell. It always counts from 1 to N.
* The second integer xCount is the number of corridors this cell has.
* The following xCount integers are the IDs of the cells that the corridors connect to.

# Output
* Line 1: The minimum number of emergency exits needed

# Constraints
* 1 ≤ N ≤ 1000
