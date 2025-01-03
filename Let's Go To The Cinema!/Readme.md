# Puzzle
**Let's Go To The Cinema!** https://www.codingame.com/training/medium/lets-go-to-the-cinema

# Goal
There is a cinema with maxRow * maxColumn seats (all rows having same number of seats). n groups of people are arriving in order and trying to sit down.   
For each group, you get as input the numPersons number of peoples it consists of, and the row and seat their ticket is issued for.   
(Meaning they purchased the seats from ( row , seat ) to ( row , seat + numPersons - 1), these seats included.)   
The same seat might have been sold several times!  

You have to simulate and output how many groups and how many persons could sit on their original appointed seat.  

If a group cannot sit to its place because it is already occupied, they try to find another place using a seat finding method:
- To understand the procedure, consult the diagram at: https://www.aviationfanatic.com/cg/cinema.png
- The group sits ONLY if ALL of them can sit next to each other.
- They try to shift together: left by 1, right by 1, left by 2, right by 2, etc.
- If unsuccessful in the row, then try 1 row towards the front, then by 1 row to back, 2 rows to front, etc.
- In each row use the same seat-finding procedure (starting at the same seat position).

If they tried every possible places but still without success:
- They adapt to the situation and split into two subgroups of same size (the first subgroup shall be bigger, if the size of the group was odd.).
- Now the first subgroup tries to sit on the original row seat position using the same seat-finding procedure as above.
- As the group size is now smaller, they might succeed this time.
- If they don't succeed, they keep splitting the subgroupsize by another half, and continue trying, BEFORE the original another half subgroup gets the chance to try.
- Note: Latest when the subgroup size reaches 1 person, it will always succeed to find a place.
- After the whole original group got seated, the next group arrives, and so on.

You have to output two numbers:  
groupSuccess is the number of groups, who could sit instantly in their original places.   
(If a split subgroup can sit later on the original place, that does not count towards this counter.)  
personSuccess is the number of individuals, who could find a place on their original group ticket.   
A person shall be counted as successful, no matter after how many iterations he found the place, if and only if the seat is any of the places appointed to the original group: ( row , seat ) to ( row , seat + numPersons - 1).

Note: no performance optimization is needed for this puzzle. Just make a simple seat-finding simulator.

# Input
* Line 1: Space separated integers maxRow maxColumn for the size of the cinema.
* Line 2: Integer n the number of groups arriving to the cinema.
* Next n lines: Three space separated integers numPersons rowand column for the size of the group and their (leftmost) appointed seat position.

Note: Rows and seats are counted from 0. The 0 0 seat is the leftmost one, immediately in front of the screen.

# Output
* Line 1: Two space separated integers groupSuccess and personSuccess as defined in the statement.

# Constraints
* 1 ≤ maxRow ≤ 100
* 1 ≤ maxColumn ≤ 100
* 1 ≤ n ≤ 1000
* 1 ≤ numPersons ≤ maxColumn
* 0 ≤ row ≤ maxRow - 1
* 0 ≤ column ≤ maxColumn - 1
* column + numPersons ≤ maxColumn
