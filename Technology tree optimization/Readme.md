# Puzzle
**Technology tree optimization** https://www.codingame.com/contribute/view/7290797a8cf263d5a862a05c7f077935ff5

# Goal
You are playing a Civilization® type game, and you are trying to figure out how to complete the technology tree as fast as possible.  
The names and links are from Civ1 but for this puzzle, durations and simplifications are created on purpose.  

You are given, for each link between two technologies, the research time needed to get the second if the first one is given (it’s not symmetrical).   
Of course, some technologies might need more than one required technology and some technologies might be needed by more than one technology.  
You have to find the minimum time to complete the given tree, the critical path (the research that must have top priority) and for each technology:  
* The early start time (EST is the earliest time that a technology can be, it can’t start before because of the previous ones)
* The late start time (LST is the latest time that a technology can be acquired, given that the last tech is obtained as early as possible it can’t start after because of the latter ones).
You can match the critical path easily: follow the technology path where EST equals LST.

# Input
* Line 1: The number m of technologies and the number n of links between them
* Next n lines: Tech1 Tech2 Duration

# Output
* Print the critical path.
* For each technology (lexicographic ASCII order), print the EST and LST.

# Constraints
* All the durations are integers.
* You have to find by yourself the first and the last technologies of the tree.
* Some durations might be zero but not negative.
