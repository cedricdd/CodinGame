# Puzzle 
**A Bunny and Carrots** https://www.codingame.com/training/easy/a-bunny-and-carrots

# Goal
Farmer Fibo has a nice M×N grid of carrots in his garden. However, he also owns a very hungry bunny named Bugs who really likes carrots.  
In each turn, Bugs hops along one of the N columns and eats the first carrot he finds. i.e. if the ith column is chosen, he eats the carrot in (j,i) where j is the highest value for which there is a carrot.

Given an array with the column choices of Bugs, for each of them print the perimeter of the region of carrots remaining after Bugs has eaten that carrot.

For example, take the following 2×2 garden where "C" stands for a carrot and "X" stands for eaten:
```
 _ _
|C C|
|C C|
 - -
```
The perimeter is 8 as all grid is covered with carrots.

Suppose the choices are the array [2,1,1,2].  
This is how the garden will look like after each eaten carrot:
```
 _ _
|C C|
   -
|C|X
 -

 _ _
|C C|
 - -
 X X

   _
 X|C|
   -
 X X
```
and finally:
```
 X X
 X X
```
The perimeters of the area occupied by the carrots are respectively 8, 6, 4 and 0.

# Input
* Line 1: A pair M,N for the height and width of the carrots garden.
* Line 2: An integer T - the total number of choices from Bugs.
* Line 3: T space-separated integers choices.

# Output
* T lines: The perimeters delimited by the carrots after Bugs ate each carrot.

# Constraints
* 0 < M,N ≤ 20
* T ≤ M×N
* 1 ≤ choices ≤ N
  
No column will be chosen more than M times.
