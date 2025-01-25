# Puzzle
**Paper-folding curve** https://www.codingame.com/training/hard/paper-folding-curve

# Goal
Get a stripe of paper. Fold it into half. Fold it into half again in the same direction. Fold it the third time into half, in the same direction. Then open it, so that every fold is at a right angle. Viewing it from the edge you could see a pattern like this:
```
   _ 
|_| |_
     _|
```

Since we made 3 folds to create this curve, we call it an order-3 curve.

Following the same procedure we can arrive at different orders of the curve.  
```
order-1

_|
```
```
order-2
   _
|_|
```
```
order-3
 _
|_   _
  |_| |
```
```
order-4
   _   _
  |_|_| |_
   _|    _|
|_|
```

The curve can expand to infinite orders.

If you follow one end of the curve to go along the path, you will meet either LEFT or RIGHT turns. We write LEFT as 1, and RIGHT as 0. We describe a curve by a sequence of 0 and 1.

Depending on which end you are viewing the paper, and from which end you start walking through the path, the same curve can be represented in four different ways. We arbitrarily choose one as the "correct" representation:

The sequence of order-1 curve is: 1
The sequence of order-2 curve is: 110
The sequence of order-3 curve is: 1101100

Your task is to find the Sequence of higher order curves using the same representation scheme as above.

# Input
* Line 1 An integer N for the order of the curve
* Line 2 A starting index and an ending index (both 0-based and inclusive) of a sub-string of the Sequence

# Output
* You do not need to output the full sequence. You only need to output a sub-Sequence as defined above.

# Constraints
* 1 ≤ N ≤ 50
* ending index - starting index ≤ 255
* starting index, ending index ≤ 1,000,000,000,000,000
