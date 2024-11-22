# Puzzle
**Elevator** https://www.codingame.com/training/hard/elevator

# Goal
A building has n floors.  
It has an elevator that is controlled by two buttons only: UP and DOWN.

By pressing the UP button, the elevator will go exactly a floors up.  
By pressing the DOWN button, the elevator will go exactly b floors down.

If the elevator is commanded to go lower than the first floor or higher than the n-th floor, it will refuse to move and remain on its current floor.

The elevator starts on the k-th floor. Count how many times the buttons should be pressed to move the elevator to the m-th floor.

# Input
* Line 1: 5 space separated integers in order: n a b k m

# Output
* One line that contains 1 integer - minimal number of buttons pressed, required to move the elevator to the floor m.
* If it is impossible to move the elevator to the floor m, print IMPOSSIBLE

# Constraints
* 1 ≤ n ≤ 10000
* 1 ≤ a ≤ n
* 1 ≤ b ≤ n
* 1 ≤ k ≤ n
* 1 ≤ m ≤ n
