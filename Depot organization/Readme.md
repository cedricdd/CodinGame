# Puzzle
**Depot organization** https://www.codingame.com/training/medium/depot-organization

# Goal
In this puzzle, there are 7 depots on a floor plan. Each depot is shown as a hexagon, and each of its 6 walls (sides) are marked with its texture (denoted by a character).   
We have to arrange the depots with one in the center and the other 6 surrounding it observing the following rules:

*Rules*  
1. Each depot may be rotated clockwise or anticlockwise as many times as needed (see illustration 1 below).
2. Depots may not be flipped as a mirror image.
3. The center depot must be oriented such that the texture denoted by the alphabetically lowest character is on the wall to the right.
4. Every wall shared by two depots must have a matching texture.

See illustration 2 below for a complete example.

Illustration 1  
A depot may be rotated clockwise once like this:  
https://user-images.githubusercontent.com/5595067/32763380-4cadec04-c93a-11e7-8d52-6884c9dea40a.png  
Below shows the same illustration:  
```
      .                  .      
     / \                / \
    /   \              /   \
   /     \            /     \  
  / N   D \          / G   N \
 /         \        /         \
|           |      |           |
|           |      |           |
|G         W|  ->  |J         D|
|           |      |           |
|           |      |           |
 \         /        \         /
  \ J   T /          \ T   W /
   \     /            \     /
    \   /              \   /
     \ /                \ /
      v                  v
```

Illustration 2  
This is the illustration of the solution to the Example test case:  
https://user-images.githubusercontent.com/5595067/32763805-ee635f64-c93c-11e7-9050-7996f726a882.png  
Below shows the same illustration:  
```
            .           .      
           / \         / \
          /   \       /   \
         /     \     /     \  
        / D   V \   / C   M \
       /         \ /         \
      |           |           |
      |           |           |
      |S    4    K|K    1    X|
      |           |           |
      |           |           |
     / \         / \         / \
    /   \ T   M /   \ W   F /   \
   /     \     /     \     /     \
  / X   T \   / M   W \   / F   S \
 /         \ /         \ /         \
|           |           |           |
|           |           |           |
|N    2    R|R    6    C|C    5    G|
|           |           |           |
|           |           |           |
 \         / \         / \         /
  \ M   W /   \ T   G /   \ B   K /
   \     /     \     /     \     /
    \   / W   T \   / G   B \   /
     \ /         \ /         \ /
      |           |           |
      |           |           |
      |D    0    J|J    3    C|
      |           |           |
      |           |           |
       \         / \         /
        \ N   G /   \ Q   V /
         \     /     \     /
          \   /       \   /
           \ /         \ /
            v           v
```

(Problem based on: Hexagon Puzzle (Problem 24) from HP CodeWars 2017 NA)

# Input
* Lines 1 to 7: One line of 6 space-separated characters denoting the texture of the walls in clockwise order for each depot. 
* The depots are ordered by their index from 0 to 6, i.e. the nth line relates to depot indexed n - 1.

# Output
* Line 1: One line of 7 space-separated pairs of the depots' index and texture on the walls to the right, after arranging the depots in a way which satisfies the rules.
* Order the pairs by the depots' positions left-to-right, top-to-bottom (i.e. the first pair refers to the depot in the top left, and the last pair refers to the depot in the bottom right).

# Constraints
* For each case there is a unique arrangement (solution) which satisfies the rules.
* The alphabetically lowest character in a depot may appear once only in that depot.
