# Puzzle
**The Descent - Part 2** https://www.codingame.com/contribute/view/143433c7b7e8188840bd55bfa77d154b28c045

# Goal
Uh oh, there seem to be more mountains than you thought. Help the starship find a place to land!

You are given a 2D grid of width w and height h. Each cell in the grid contains a number representing the height of a mountain. You are also given two integers, a and b, which represent the dimensions of your starship.

Your task is to determine the minimum number of shots required to reduce the heights of the mountains so that there is a level rectangular area of size a × b or b × a where the starship can land, all within t moves. All cells within the chosen landing area must be reduced to the same height, though that height does not need to be 0. Each shot reduces the height of a single mountain cell by 1, and mountain heights cannot drop below 0.

This is a sequel to the puzzle "The Descent" (https://www.codingame.com/training/easy/the-descent)

# Input
* Line 1: 2 space-separated integers width w and height h
* Next h lines: w space-separated integers, representing the heights of the mountains
* Next line: 2 space-separated integers a and b, representing the dimensions of the starship.
* Next line: An integer t, representing the maximum number of shots allowed.

# Output
* Line 1: The minimum number of shots needed to create a level area big enough for the starship to land. Output Not Possible if it is not possible to do so.

# Constraints
* 3 ≤ w, h ≤ 15
* 1 ≤ a, b ≤ 15
* 1 ≤ t ≤ 3000
* 0 ≤ Height of Mountains ≤ 50
* It is guaranteed that the starship can fit inside the grid in at least one orientation, i.e. (a ≤ w and b ≤ h) or (a ≤ h and b ≤ w).
