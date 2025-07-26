# Puzzle
**Bash Maze — Escape the Terminal** https://www.codingame.com/contribute/view/1307280a7ce4f2678fd72b758ee909464a0ea4

# Goal
You're trapped inside a Linux terminal session.

You must simulate a simplified shell environment to reach a directory named exit.
Your goal is to determine whether the user successfully escapes by navigating the directory tree.

Each line of input is a simplified shell command:
* mkdir DIR — Create a subdirectory named DIR in the current directory
* cd DIR — Move into the subdirectory named DIR (must already exist)
* cd .. — Move up to the parent directory (if not at root)
* pwd — Print the current directory
* ls, touch FILENAME — These commands do not change the current directory.

The user always starts in the root directory.  
At any point, if the user executes the command pwd while located inside a directory named exit, they escape successfully.  
If they attempt to cd into a directory that doesn’t exist, the session fails.  
If the session ends without errors, but no pwd was called inside an exit directory, the user is considered lost.  

Note: If the session ends without errors, moving to a different directory after calling pwd in an exit directory still counts as escaped — escaping is permanent once triggered.

# Input
* Line 1: An integer N, the number of shell commands.
* Next N lines: Each line contains one shell command in string format.

# Output
Print one of the following depending on the outcome:
* YOU ESCAPED — The user successfully called pwd inside a directory named exit.
* TRAPPED — The user attempted to cd into a non-existent directory.
* LOST — The session ended without errors, but the user never escaped.

# Constraints
* 1 ≤ N ≤ 100
* Only the shell commands in the statement are used.
