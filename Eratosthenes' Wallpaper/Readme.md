# Puzzle
**Eratosthenes' Wallpaper** https://www.codingame.com/training/medium/eratosthenes-wallpaper

# Goal
Eratosthenes wants a wallpaper containing the prime factors of numbers. You are tasked to supply a nice wallpaper.

Print consecutive numbers and its prime factors on wallpaper with fixed width and height.

The number is written first, then an equal sign and then the prime factors in ascending order. Examples are:
- 10=2*5
- 11=11
- 12=2*2*3

If multiple numbers fit on a single they must be separated by a comma.  
If no more numbers fit on a line, the line must be right padded with minus signs to the full width.  
If the number won't fit on the next line either, all the next lines should be filled with only minus signs.  

Numbers are added to the wallpaper consecutively.  
So if the first number on the wallpaper is 2, the first line will start with 2, then 3, then 4 etc. If 5 won't fit on the first line then the second line will start with 5

With the above example if the width of the wallpaper is 15, the line starting with 10 will contain 10=2*5,11=11---. 10 and 11 will fit on the line and 12 won't fit.   
The three dashes fill up the line to it's width of 15.

# Input
* Line 1: Three integers separated by a space: width of the wallpaper in characters, height of the wallpaper in characters and the first number to be prime factorized

# Output
* height lines: strings containing the content of the wallpaper

# Constraints
* 3 ≤ width ≤ 100
* 1 ≤ height ≤ 100
* 2 ≤ number ≤ 1000000000
