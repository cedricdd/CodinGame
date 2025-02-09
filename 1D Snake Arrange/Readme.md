# Puzzle
**1D Snake Arrange** https://www.codingame.com/contribute/view/1157130bbaba6db6ff2da433a9c0dc5eb30f1e

# Goal
Given a list of snakes and a pattern, can you calculate the number of possible arrangements?

Each 1D snake has a length. A snake of length 3 looks like ###.  
Snakes are elegant and arrogant animals. Any two snakes will not touch each other, thus, at least one free space (denoted by .) should be between two snakes. For example, two snakes of lengths 2 and 4 could be arranged as ##.#### or ##..####.

In the pattern .#...#....###., there are 3 snakes of lengths 1, 1, and 3.

Now, part of the pattern is obscured with ?. For example:
```
.??..??...?##.
```
And given the snake list of 1, 1, 3.
The possible arrangements could be:
```
.#...#....###.
..#..#....###.
.#....#...###.
..#...#...###.
```

Therefore, there are 4 possible arrangements.

# Input
* Line 1: n as number of cases to solve
* Following n Lines: pattern snake list (comma-separated integers representing the lengths of the snakes), separated by one space

# Output
* n Lines: each line is number of possible arrangements of corresponding case
