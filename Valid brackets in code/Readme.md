# Puzzle
**Valid brackets in code** https://www.codingame.com/training/medium/valid-brackets-in-code

# Goal
You are given an integer n. In the next n lines you get the whole code. You must return whether the code is valid - that means the brackets are valid.   
You don't have to check anything else. If there are no brackets, return No brackets, if it is valid - Valid, otherwise Invalid  

Notes:  
* Brackets to check for in code: ( ) { } [ ]  
* There can be brackets in strings and you have to ignore them. That means, ignore everything that is in quotes "ignore (this)".
* All string will be valid: they will open and close. But there can be escapes. For example: "some \" string\" \\ -_-"
* There will be no comments in code.
* There will be no empty lines.

# Input
* Line 1: An integer n for the number lines of code.
* Next n lines: A line of code.

# Output
* Line 1 : Valid, Invalid or No brackets

# Constraints
* 1 ≤ n ≤ 50
