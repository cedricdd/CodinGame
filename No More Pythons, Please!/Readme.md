# Puzzle
**No More Pythons, Please!** https://www.codingame.com/training/easy/no-more-pythons-please

# Goal
Given an ASCII drawing of NxM characters. You must output the longest snake size in the image. It is also necessary to output the number of snakes with such size.

On the field "." means an empty space (no snake)

The snake is depicted by the following constant symbols:
* "o" - a snake's head
* "-","|" - intermediate part of the snake in horizontal/vertical position
* "v","<",">","^" - a snake's tail
* "*" - a curved part of the snake, i.e. a turn. 

It is guaranteed that it's possible to unambiguously determine which symbol refers to which snake:

The second character from the head and from the tail cannot be a "*".  
Also, one snake cannot have two "*"s in a row.

# Input
* Line 1: Two space-separated integers N and M for the height and the width of the figure.
* Next N lines: The M characters which can only be o, |, -, *, <, v, ^, >, or .

# Output
* Line 1 : The size of the largest snake in the input figure.
* Line 2 : Count of snakes with the largest size.

# Constraints
* 5 ≤ N ≤ 80
* 5 ≤ M ≤ 80
