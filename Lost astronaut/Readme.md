# Puzzle
**Lost astronaut** https://www.codingame.com/training/medium/lost-astronaut

# Goal
We lost an astronaut in space! But luckily the astronaut survived and he made a signal transmitter from broken parts of his spaceship.   
It is transmitting but some letters are converted to binary, octal, or hexadecimal randomly.  

You are the best programmer we got. We need you to make a program to convert these values and decode an original sentence typed by the astronaut.  

You should assume that the transmission contains only the ASCII codes for letters and space.  
For example, if you receive "45" it is the hexadecimal code for the character E. It cannot be octal code for % because that character is not a letter or space.

# Input
* Line 1 : int N number of characters in original message
* Line 2: string MESSAGE, N values(can be in Bin,Oct,Hex or original character) separated by spaces.

# Output
* The original sentence typed by the astronaut.

# Constraints
* 2 ≤ N ≤ 350
* MESSAGE only has A to Z, a to z, and space
