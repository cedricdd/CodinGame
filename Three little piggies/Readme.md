# Puzzle
**Three little piggies** https://www.codingame.com/training/hard/three-little-piggies

# Goal
The three little pigs have to build their houses on the field of grass but they fear the big bad wolf. Help them place their 3 homes on their land so that they can be protected. Sometimes, there are only two pigs but you still must place the three houses.  
Their land is a 4×4 grid which has X’s for grass and dots (periods) for trees. The pigs, which always stay on the same spot of grass and are too lazy to move, show up as P’s. The big bad wolf, who will only show up at night, is a W (during the day he’s sleeping in his lair).  

For example:
```
Day:
.XX.
PXXX
XXPX
.XXX
```

```
Night:
.WX.
XXXX
XPPX
.XPX
```

The straw house’s tile is an L with the house in the corner:
```
Hs
s
```

The sticks house’s tile is a bar with the house in the middle:
```
SHS
```

The brick house’s tile is a longer L:
```
HBB
B
```

You can rotate but not mirror the tiles: the longer L can become a 7, never a Γ.  
The tiles can’t cover a tree or the wolf.  

There are two kinds of inputs: one for day and one for night (only at night a wolf can be seen).  
If it is day: place the houses so that the pigs can be seen. No tile much cover a pig.  
If it is night: place the houses so that each pig is covered by an H. A house might not cover a pig, if there are only two pigs.  

Each puzzle has a single solution.  

# Input
* 4 lines: The field
  
# Output
* The field filled with the three tiles.
* Show the pigs if it’s the day, hide them if not.
* Some areas of the field may remain Xs, day or night.
