# Puzzle
**Criminal** https://www.codingame.com/training/medium/criminal

# Goal
You are a criminal. You are in search and capture, nobody should see you.

You are in an area with an altitude H and a length W.  
You have to print how many people are watching you.

*INFORMATION:*  
* ".": nothing
* "Y": you
* "^": person who looks up
* ">": person who looks to the right
* "v": person who looks down
* "<": person who looks to the left
* other character: obstacle

RULES:  
1.You:
* If you are in the field of vision of a person, that person is considered to be watching you.

2.The field of vision of the people:
* The field of vision increases by two characters (starting with 3) depending on where the person is looking:
```
........v........
.......###.......
......#####......
.....#######.....
....#########....
...###########...
..######Y######..
.###############.
#################
```
(is watching you)

* If an obstacle (!!OR ANOTHER PERSON!!) interferes with the field of vision of a person, the person cannot see what is behind the obstacle.

3.Obstacles:
* If the obstacle is right in front of the person, everything that is behind cannot be seen. If the obstacle is to the right or left of the person, the hidden area will increase by one (starting from 2):
```
........v........
.......###.......
......#####......
.....###x###.....
....####.#x##....
...#####.#..##...
..###x##Y#...##..
.###..##.#....##.
###...##.#.....##
```
(is not watching you)

(the physics of this puzzle is not realistic)

# Input
* Line 1: H Height
* Line 2: W Width
* Next H lines: String with one 'Y'

# Output
* How many people are watching you.

# Constraints
* 0 < H, W < 256
