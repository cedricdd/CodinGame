# Puzzle
**100 Men vs. Gorilla** https://www.codingame.com/contribute/view/124161bf4bd7acaf8452c14f350b9f04f6ea6e

# Goal
Bob, a gorilla, was stuck in a maze with men. Bob aims to swat away as many men as possible, but his banana energy could not last forever. But he has a special trick: he can jump over an object that uses up more banana energy. Given his starting banana energy (b), the amount of banana energy it takes to move one space in the cardinal directions (e), the amount of banana energy it takes to jump over an object (j), and the maze - made up of #, ., G, and M - find the maximum number of men he can swat.

The objects Bob can jump over are only the walls - #.  
Bob can only jump over 1 wall.  
The objects in the maze are not space-separated, and the maze may or may not be fully enclosed.  
Bob cannot revisit a square after swatting a man there.  

* \# = The walls, which Bob can jump over.
* . = The empty spaces, which Bob can walk on.
* G = Bob's starting square.
* M = The men, where if Bob goes to that square, that man is automatically swatted.
  
# Input
* Line 1: An integer b representing his starting banana energy.
* Line 2: An integer e representing the banana energy needed to move one space in the cardinal directions.
* Line 3: An integer j representing the banana energy needed to jump over an object.
* Line 4: An integer w representing the maze's width, not including the spaces.
* Line 5: An integer h representing the maze's height.
* Next h lines: A space-separated maze with length w.

# Output
* Line 1: The maximum number of men Bob can swat.

# Constraints
* 0 ≤ b ≤ 1000
* 1 ≤ e ≤ 100
* 1 ≤ j ≤ 500
* 1 ≤ w, h ≤ 15
