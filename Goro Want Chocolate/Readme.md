# Puzzle
**Goro Want Chocolate** https://www.codingame.com/training/medium/goro-want-chocolate

# Goal
Goro hungry. Goro want chocolate.  
Goro picky. Goro only like chocolate shape like square. Goro like few big square better than mucho little square.  
You smart. You help Goro find best chocolate chop so squares bigger, no waste.

You are provided with Goro's chocolate bar's dimensions. You are to answer with the minimal number of squares it's possible to chop out of it, with no leftovers allowed.

Goro chopping works karate-style:  
* Goro picks a piece of chocolate among those available.
* Goro holds it firmly between his lower-left and lower-right hands.
* Goro grunts loudly.
* Goro forcefully slashes down the chocolate with his upper-right arm and breaks it in two new rectangular pieces.

Goro is very strong, yet he is disciplined enough that he only splits the chocolate rectangle along its major axes (horizontal and vertical), on the lines.

Example on a 3×5 chocolate grid:
```
┌─────────────────────┬──────┬──────┐
│                     │      │      │
│                     │   1  │   1  │
│                     │      │      │
│                     ├──────┴──────┤
│                     │             │
│          3          │             │
│                     │             │
│                     │      2      │
│                     │             │
│                     │             │
│                     │             │
└─────────────────────┴─────────────┘
```

It's possible to split down to 4 square pieces, of sides 3, 2, 1 and 1: first split the 3-sided square from the rest, then split the 2-sided one out, then separate the 1-sided remnants from each other.

# Input
* Single line: H and W, dimensions of the chocolate rectangle, space-separated.

# Output
* N the minimal number of squares we can chop out with no waste.
  
# Constraints
* 1 ≤ H, W ≤ 150
