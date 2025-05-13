# Puzzle
**Cows in a Maze** https://www.codingame.com/training/medium/cows-in-a-maze/discuss

# Goal
Farmer John is having a hard time. Due to recent thunderstorms, his cows are cooped up in the barn all day, making them sad. Farmer Nhoj offers to take some of Farmer John's cows, but it comes with a catch; the cow must prove itself worthy by going through a maze filled with obstacles. Each cow starts at the top left corner of the maze and can move up, down, left or right one square as long as the cow doesn't leave the maze or steps on a square that has a "difficulty level" higher than what the cow can endure. A cow exits the maze if it reaches the lower right square. Please help Farmer John to find the number of cows that can pass the maze!

# Input
* Line 1: Three space separated integers, C, N, and M, representing the number of cows, the height, and the width of the maze.
* Next C lines: 1 integer, representing the highest "difficulty level" the cow can endure.
* Next N lines: M space separated integers representing the "difficulty level" of each square.

# Output
* Line 1: The number of cows that can pass through the maze.

# Constraints
* 1 <= C <= 5
* 1 <= N, M < =10
