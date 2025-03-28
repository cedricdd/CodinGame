# Puzzle
**Boarding passes ready!** https://www.codingame.com/training/medium/boarding-passes-ready

# Goal
CodinGame Airlines are always trying to improve efficiency. To that end, they are trying a new way of boarding passengers onto their planes:

Boarding group 1: Starting from the back row of the plane, and working up to the front, board the left-most waiting passenger whose seat is on the left half of the row.  
Boarding group 2: Starting from the back row of the plane, and working up to the front, board the right-most waiting passenger whose seat is on the right half of the row.  

Repeat for the next boarding groups, until everyone is on board. Empty boarding groups do not need to be called.

You must call the name of the passengers in each boarding group, in the order the passengers should board, when it's that group's turn.

*Notes:*  
- Seat 1A is the left-most seat of the front row of the plane.
- The aisle always divides the seats evenly: In a plane with 6 seats to a row, seats A,B,C are on the left, and D,E,F are on the right.
- Some seats may be unsold. If a seat is unsold, the next eligible passenger in that half of the row boards.

Example
```
4
4
8
Alice,1A
Brian,2C
Cathy,2D
Debra,4C
Ellen,4D
Frank,2B
Geoff,1C
Helen,3A
```

w=4, so the seats are A & B on the left, C & D on the right  
After boarding, the passengers will be seated like this:
```
             FRONT
    A     B         C     D  
1 Alice ----- xxx Geoff -----
2 ----- Frank xxx Brian Cathy
3 Helen ----- xxx ----- -----
4 ----- ----- xxx Debra Ellen
```

Boarding Group 1: Left hand side, from row 4 to row 1
- There is no passenger in 4A, or 4B. Nobody boards
- Call Helen to board seat 3A
- There is no passenger in 2A; Call Frank to board seat 2B
- Call Alice to board seat 1A

Now boarding: Helen,Frank,Alice

Boarding Group 2: Right hand side, from row 4 to row 1
- Call Ellen to board seat 4D
- There is no passenger in 3D, or 3C. Nobody boards
- Call Cathy to board seat 2D
- There is no passenger in 1D; Call Geoff to board seat 1C

Now boarding: Ellen,Cathy,Geoff

Not everyone is on the plane - another round of boarding is needed.

Boarding Group 3: Left hand side, from row 4 to row 1
- There is still no passenger in 4A, or 4B; nobody boards
- 3A has already boarded, there is no passenger in 3B; nobody boards
- 2B has already boarded; nobody boards
- 1A has already boarded, there is no passenger in 1B; nobody boards

(No boarding announcement here, as nobody is getting on.)

Boarding Group 4: Right hand side, from row 4 to row 1
- 4D has already boarded; Call Debra to board seat 4C
- There is no passenger in 3D, or 3C; nobody boards
- 2D has already boarded; Call Brian to board seat 2C
- 1C has already boarded; nobody boards

Now boarding: Debra,Brian

# Input
* Line 1: An integer h, the number of rows of seating on the plane
* Line 2: An integer w, the number of seats in each row of the plane.
* Line 3: An integer n, the number of passengers boarding.
* Next n lines: A string passenger containing each passenger's details in the format: name,seat

seat is an integer followed by a letter, eg. 14C

# Output
* A line for each non-empty boarding group, in order of boarding.

Each line starts "Now boarding: " followed by the comma-separated passenger names, in the order they should board
n names should be listed in total.

# Constraints
* 1 <= h <= 20
* 2 <= w <= 8; w is even
* n > 0
* Every passenger has a different name
