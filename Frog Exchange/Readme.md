# Puzzle
**Frog Exchange** https://www.codingame.com/training/medium/frog-exchange

# Goal
Given are n stones as array. The middle stone s is unoccupied at the start. On each of the left (n-1)/2 stones sits a male m frog looking to the right;  
On each of the right (n-1)/2 stones is a female f frog looking to the left.  
(m)> (m)> (m)> (m)> ... (m)> s <(f) ... <(f) <(f) <(f) <(f)  

The frogs can only jump in the direction they are facing. If the corresponding neighboring stone is free, the frog can jump directly to this stone.  
It is also possible to jump over one neighboring frog in order to get to a corresponding free stone.

We are looking for a sequence of jumps such that all male frogs are on the right (n-1)/2 stones and all female frogs are on the left (n-1)/2 stones. if there is no frog, return the input.

Male and female start positions can also be reversed, in which case their end position is also reversed.

Schematic example:
```
n=3, m=f=1
(m s f) -> start with f and jump just to the left
(m f s) -> a new stone is free
(m f s) -> consider the next possible male frog(s) and jump to the free stone
(s f m) -> a new stone is free
(s f m) -> consider the next possible female fog(s) and jump to the free stone
(f s m) -> a new stone is free
(f s m) -> result
```

Output:
Return the state of the array on a separate line after each round.
e.g. Input:
```
m s f
```

Output:
```
m s f
s m f
f m s
f s m
```

Be courteous and start with the ladies.

# Input
* Line 1: A string with frog position

# Output
* Line 1: starting grid
* Line 2: first move
* Last line: final grid

# Constraints
* 3 ≤ n ≤ 100
* n is odd
* number of m = number of f
