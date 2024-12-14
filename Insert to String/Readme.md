# Puzzle
**Insert to String** https://www.codingame.com/training/easy/insert-to-string

# Goal
You're given a string and a list of changes to do on that string.  
Each change includes a line number, a column number, and a string to add at that location.  
Commit all of the changes to the given string so they wouldn't interfere with each other.  

("\n" should be replaced with a newline.)

# Input
* Line 1: A string s to manipulate.
* Line 2: An integer changeCount for the number of changes.
* Next changeCount lines: A string rawChange that manipulates the string.

# Output
* The manipulated string.

# Constraints
* s String of length ≥ 1
* 1 ≤ changeCount ≤ 10
* rawChange = {Line number (int)}|{Column number (int)}|{String to add at the position (string)}
