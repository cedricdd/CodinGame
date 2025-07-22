# Puzzle
**Treasure Rush** https://www.codingame.com/contribute/view/1236662563aa96ba72779bc6f470c91bc1fbf2

# Goal
After falling through a covered hole in the dark forest, you find yourself in an ancient maze below the ground. Luckily, there is a map of the maze and you figure out where you are located. Time is ticking. You must find the fastest way to the treasure chest and then to one of the exits to escape. You can only move north, east, south or west, not diagonally. Note that the fastest way is not necessarily the shortest.

You start at the starting point S on the map. Make your way to the treasure chest T, then escape using any of the available exits E. You must find a path that requires the shortest total time. If there are multiple such fastest paths, use the path among them that requires the least amount of moves. This is called the best path.

The time to move depends on the type of the target field you move to:  
* Moving to a water field W requires two units of time to swim through.
* Moving to a morass field M requires five units of time to wade through.
* Moving to a mud block X requires ten units of time to destroy the mud block, but then stays empty after destruction.
* Moving to any other field (empty field represented by a space, the starting point S, the treasure chest T or an exit E) requires one unit of time.

The whole maze is always surrounded by an impenetrable stone wall #. Stone walls can also appear inside the maze and cannot be traversed.

You need to output the number of moves and the number of time units for the best path.

# Input
* Line 1: width and height, separated by a space, where width is the width of the maze and height is the height of the maze
* Following height lines: the rows of the maze, each width characters long

# Output
* Line 1: moves and time, separated by a space, where moves is the total number of moves and time is the total number of time units for the best path from the starting point to the treasure chest and then to the nearest exit.

# Constraints
* 8 <= width <= 140
* 3 <= height <= 70
* There is always one starting point S, one treasure chest T and at least one exit E. All of these are in different positions.
