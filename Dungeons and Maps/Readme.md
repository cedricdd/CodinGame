# Puzzle
**Dungeons and Maps** https://www.codingame.com/training/easy/dungeons-and-maps

# Goal
Your adventure path led you to an inn in a small, forgotten town somewhere to the North of Golem Hills.  
After gulping the last drop from the 9th mug of elf wine a shady old man materializes out of nowhere, in-front of you.  
You start to doubt the wine.  
The old man (throwing a pack of old maps on the table): Do you want to earn some good coins?  
You (without looking at him): I've enough for food and wine!  
The old man: What about a whole inn...!  
You: Hm...  
The old man: Yeees and you'll get the glory of being the first one to get to this treasure!  
You (looking at the bunch of maps): But they look the same!?  
The old man: Or do they, you must choose wisely.  
The voice of the old man (from nowhere): Ah right, one more thing, beware of the Dragons!  
You grab your staff and sword, swallow one more whole mug of wine:  
Well, it's glory time!  

You are given N maps for a dungeon. Each map may contain a path to a treasure T, from starting position [ startRow; startCol ].   
Determine the index of the map which holds the shortest path from the starting position to T, but be careful a map may lead you to a TRAP.  

A path is marked on the map with ^, v, <, > symbols, each corresponding to UP, DOWN, LEFT, RIGHT directions respectively, i.e. each symbol shows you the next cell to move on.

A valid path must start from [ startRow; startCol ] and end on T.

The path length is the count of direction symbols plus 1, for the T cell.

# Input
* Line 1: Width W and height H of the maps
* Line 2: startRow and startCol for the starting position on the map
* Line 3: An integer N for the number of maps to check
* N * H Lines: Each H consecutive lines are representing a single map. Each line contains W characters representing a row of a map.

Characters can be:  
* \. - Empty square
* \# - Wall
* \^ - Move UP
* v - Move DOWN
* \< - Move LEFT
* \> - Move RIGHT
* T - The treasure square

# Output
* Index of the map with the shortest path. If there isn't a map with valid path from [ startRow; startCol ] to T output TRAP.

# Constraints
* There is always a T on the maps.
* If there are maps with valid path from [ startRow; startCol ] to T only one map holds the shortest path.
* The given maps are representing the same dungeon, but the position for T may differ.
* 0 < N < 10
* 2 < W, H < 20
