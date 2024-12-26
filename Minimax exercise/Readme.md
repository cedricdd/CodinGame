# Puzzle
**Minimax exercise** https://www.codingame.com/training/medium/minimax-exercise

# Goal
Topic: Minimax algorithm, Alpha–beta pruning, Zero-sum games, Negamax

We are given a 2-player, zero-sum game, where players alternate turns. The game always lasts D turns, and during its move, every player has to choose from B choices.  
Thus, D is the game tree depth, B its branching factor, and depending on players' choices, the game has B^D possible outcomes.  

Assuming the game tree is small enough, we can check all outcomes and solve the game (i.e. compute the best strategy for every player) using the Minimax algorithm ( https://en.wikipedia.org/wiki/Minimax ).  

To make our algorithm more efficient, we can skip some computations using the alpha-beta prunning technique ( https://en.wikipedia.org/wiki/Alpha-beta_pruning ).

Your task is to compute the minimum gain for the first player using Minimax with alpha-beta cutoffs. Moves should be examined in left-to-right order, as provided in the input.

# Input
* Line 1: 2 space-separated integers:
  * D - depth of the game tree (assuming root is depth 0)
  * B - the branching factor
* Line 2: B^D space-separated integers - the leafs of the game tree containing scores of the first (max) player.

# Output
* Two space-separated numbers:
  - the best score that the root player is guaranteed to obtain
  - the number of visited tree nodes

# Constraints
* 0 < D < 15
* 0 < B < 15
* -1000 < game score < 1000
* number of leafs < 3500
