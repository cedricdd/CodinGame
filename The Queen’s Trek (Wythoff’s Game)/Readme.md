# Puzzle
**The Queen’s Trek (Wythoff’s Game)** https://www.codingame.com/training/medium/the-queens-trek-wythoffs-game

# Goal
Two players are playing a game with two piles of stones. On each turn, a player can perform one of three moves:
- Remove any positive number of stones from the first pile.
- Remove any positive number of stones from the second pile.
- Remove an equal positive number of stones from both piles.

If a player has no legal move, he loses the game. In other words, the player who takes the last stone (reducing both piles to (0,0)) wins the game.

NOTE: If the 2 piles are initially empty, the first player has no legal move and loses.

Both players play optimally. Determine whether the first or second player wins.

# Input
* Line 1: Two space-separated integers, n (the number of stones in the first pile) and m (the number of stones in the second pile).

# Output
* Line 1: FIRST if the first player wins, or SECOND if the second player wins.

# Constraints
* 0 ≤ n,m ≤ 20
