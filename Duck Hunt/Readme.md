# Puzzle
**Duck Hunt** https://www.codingame.com/training/medium/duck-hunt

# Goal
You are a hunter, and you have to shoot the most ducks before they go out your field of view. On each turn, every duck moves on their own way, but always with the same motion (linearly, same speed, same direction,...).

The first two turns, you can't fire randomly, but you have to observe how the ducks move. To that end, the field of view is given to you, represented by h lines of w characters. (Note : the point of coordinates [0, 0] is in the top left corner).  
Numbers describe the ID of each duck, whereas dots are free space.

From the third turn, you can shoot them in a certain order (only one per turn), but there is a unique solution so that you kill the most ducks before they go out of your sight.

Your goal is to output the ID and the coordinates of the duck you want to kill for each turn, in the correct order. If there are ducks you can't shoot, they must not appear in your output.

Example :
```
w = 6
h = 5
```

First turn :
```
......
...1..
......
.2....
......
```

Second turn :
```
......
..1...
...2..
......
......
```

The duck n°1 starts from [3, 1] and goes to [2, 1].  
The duck n°2 starts from [1, 3] and goes to [3, 2].  

The third turn would be :
```
......
.1...2
......
......
......
```

You have to shoot the duck n°2 first, otherwise it will disappear on the next turn. Its coordinates are [5, 1], so you must output "2 5 1".

On the fourth and last turn, there is one duck still alive :
```
......
1.....
......
......
......
```

So you must output "1 0 1".

# Input
* w = the width of your field of view.
* h = the height of your field of view.
* Next h lines : the field of view on the first turn.
* Next h lines : the field of view on the second turn.

# Output
* ID x y
* Where ID is the ID of the duck you want to kill, and x y its coordinates on the current turn.

# Constraints
* 0 < w < 100
* 0 < h < 100
* 1 ⩽ ID ⩽ 9
  
