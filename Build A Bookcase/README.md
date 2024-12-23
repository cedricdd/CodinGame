# Puzzle
**Build A Bookcase** https://www.codingame.com/training/easy/build-a-bookcase

# Goal
You are building a bookcase of a certain height and width, with a certain numberOfShelves:
* Except for the decorative top, you will use only the underline (_) and pipe (|) characters (and of course spaces) to do this.
* Divide the bookcase into as evenly distributed shelf-spaces as possible.
* If some have to be larger, put those below the others so they can hold the bigger heavier books.

*Notes:*  
* The decorative top of the bookcase (which is included in the height measurement) does not count as a shelf.
* The bottom of the bookcase does count as a shelf.
* For simplicity, assume a shelf itself doesn't take up any space.

The decorative top consists of / on the left side and \ on the right side, and a single ^ in the middle if needed.

# Input
* Line 1: integer height
* Line 2: integer width
* Line 3: integer numberOfShelves

# Output
* height lines, drawing the bookcase

# Constraints
* height, width ≥ 3
* numberOfShelves ≥ 2
* height > numberOfShelves
