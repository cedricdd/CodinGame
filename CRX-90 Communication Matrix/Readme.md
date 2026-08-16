# Puzzle
**CRX-90 Communication Matrix** https://www.codingame.com/contribute/view/136800eee96db978c1024536180e2de4b34c0f

# Goal
The CRX (Cross Routing eXchanger) Communication Matrix is a multilayer routing module used in high-density communication systems. It consists of horizontal and vertical strips arranged in multiple layers. During normal operation, every strip is controlled automatically by the synchronization system.

Each position on a strip represents one communication channel and is encoded by one of the following characters:
* 'A' — Channel A, which routes only Type-A signals.
* 'B' — Channel B, which routes only Type-B signals.
* ' ' (whitespace) — Open Channel, which imposes no routing restriction.

During a maintenance cycle, engineers are given manual control over only the front-center strip. All other strips continue operating automatically and are outside the scope of this simulation.

Initially, the front-center strip is vertical. It rotates about its center in 90° increments. The center horizontal strip never rotates.

The two strips always have the same channel at the center cell, as they share that cell.

The diagnostic bus is the communication state observed along the center horizontal row.

When the front-center strip is vertical, only the center horizontal strip contributes to the diagnostic bus.  
When the front-center strip is horizontal, the overlapping positions of the two strips combine according to the following routing rules:  
* whitespace + whitespace → whitespace
* A + A → A
* B + B → B
* A + B or B + A → whitespace
* whitespace + X or X + whitespace → X (where X is either A or B)


For each maintenance round:
* A positive integer represents the number of 90° clockwise rotations.
* A negative integer represents the number of 90° counter-clockwise rotations.

The communication matrix does not reset between maintenance rounds. Each maintenance round starts from the matrix state produced by the previous round.

When the front-center strip is horizontal, overlapping positions are combined using the routing rules above. Non-overlapping positions belonging only to the longer strip retain their original channel.

After applying each of the specified rotations, output the current state of the diagnostic bus.

Example

Suppose the rotations for each maintenance round are +1 +2 -1.

Initial communication matrix:
```
 AABA          A               A
 BBA           B               B
BABAA          B               B
B ABA  ===>  B ABA  ===>       A      &     B ABA
BB  B                           
BAABA          A               A
 BB A          B               B

(raw-data) (needed-data) (front-center) (center-horizontal)
```

#Rotation +1

The front-center strip rotates 90° clockwise and becomes horizontal: ```BA ABBA```

It overlaps the center horizontal strip:
```
Front strip  : 'B' 'A' ' ' 'A' 'B' 'B' 'A'
Center strip :     'B' ' ' 'A' 'B' 'A'
                │   │   │   │   │   │   │
Result       : 'B' ' ' ' ' 'A' 'B' ' ' 'A'
```

Output: ```B  AB A```

#Rotation +2

The matrix does not reset.

The strip rotates two additional quarter-turns from its current orientation, becoming horizontal again: ```ABBA AB```

It overlaps the center horizontal strip:
```
Front strip  : 'A' 'B' 'B' 'A' ' ' 'A' 'B'
Center strip :     'B' ' ' 'A' 'B' 'A'
                │   │   │   │   │   │   │
Result       : 'A' 'B' 'B' 'A' 'B' 'A' 'B'
```

Output: ```ABBABAB```

#Rotation -1

The strip rotates one quarter-turn counter-clockwise from its current orientation and becomes vertical.

Since the front-center strip is now vertical, it no longer overlaps the center horizontal strip.

The diagnostic bus therefore remains unchanged.

Output: ```B ABA```

# Input
* Line 1: An odd integer h, the height of the communication matrix.
* Line 2: An odd integer w, the width of the communication matrix.
* Line 3: An integer n, the number of maintenance rounds.
* Line 4: n signed integers separated by spaces, each integer (turn) representing the rotations to perform in each maintenance round.
* Next h Lines: A string of length w, representing one row of the communication matrix.

# Output
* n Lines: The resulting state of the diagnostic bus after each maintenance round, one line per round.

# Constraints
* 0 < h, w < 50
* 0 < n ≤ 15
* -100 ≤ turn ≤ 100
