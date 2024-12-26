# Puzzle
**Misère Nim** https://www.codingame.com/training/hard/misere-nim

# Goal
In a game of Nim, two players take turns removing objects from distinct heaps. On each turn, a player must remove at least one object, and may remove any number of objects provided they all come from the same heap. The goal of the normal game is to be the player to remove the last object.

In the Misère Nim variant of the game, the player who takes the last object loses.

Given a list of starting game positions, for each position find all possible moves that will ensure your victory.

# Input
* Line 1: Two space separated Integers N and K.
* N is the number of heaps; it is shared between all of the following positions.
* K is number of positions.
* Next K Lines: N space separated integers Mi, the number of objects in each heap.

# Output
* K lines: Solutions for each board position, in the order they were given.
* If the position has no winning moves, its solution is the word CONCEDE.
* If the position has winning moves, its solution is a line of one or more space-separated moves. Each move is a colon-separated pair of integers i:a, where:
  - i is the number of the heap to remove objects from: 1 ≤i ≤ N.
  - a is the amount of objects to take: 1 ≤ a ≤ Mi.
* Moves must be sorted by heap number i first, number of objects a second.

# Constraints
* 1 ≤ N ≤ 3
* 1 ≤ Mi ≤ 50
* 1 ≤ K ≤ 5
* The positions are provided in ascending order of initial heap size.
