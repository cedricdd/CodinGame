# Puzzle
**Monte Carlo Tree Search exercise** https://www.codingame.com/training/hard/monte-carlo-tree-search-exercise

# Goal
Assume we are dealing with (nondeterministic) one-player game. To find an optimal sequence of movements we could use Monte Carlo Tree Search algorithm (https://en.wikipedia.org/wiki/Monte_Carlo_tree_search).

Thus, we perform a number of so-called playouts, and gradually build an MCTS tree that will help us choosing statistically best choices for each turn of the game. A playout is a sequence of moves reaching the game tree leaf, so it has assigned a true score. It consists of two parts: the beginning, which is selected by the algorithm using the UCT formula; and the remaining part which is usually a random sequence of movements.

In this puzzle, we are given a list of playouts (encoded as words, where each letter is a single move) with assigned scores, that should be used to build an MCTS tree. After building a tree, the task is to return the sequence of moves, reaching the MCTS tree leaf, that will be chosen using UCT policy given exploration/exploitation constant C.

For given node N visited N.v times, according to the UCB1 formula we should choose a child M that maximizes the value given by: M.s/M.v + C*sqrt(ln(N.v)/M.v), where M.v is number of visits in node M and M.s is sum of scores obtained for this node (so the first component of the sum is average score for node M).

Final remarks:
- Note that this puzzle differs form the real-life-scenario where the playouts are not given, but they are also computed using UCT+random policies.
- In standard implementations you are forced to choose an unexplored move if such exists. Here we assume that after reading the playout data we do not have such moves in the non-leaf nodes of the MCTS tree.
- A tie-breaking rules when comparing UCT values is the ordering on letters (i.e. smaller letter should be chosen).

Example explanation:
- Reading baa 30 will create child node labeled b with avg. score 30 and one visit. The MCTS tree root will have the same statistics. Note that we are adding only one new node at a time.
- Reading ab 20 will create another child node for the root, updating its statistics.
- Finally, reading bbb 4 will create a new node on a path bb from the root, updating all statistics on a way to the root, so the root will have 3 visits, and b node 2 visits.
- Choosing move from the root based on the UCB1 formula will favor move a (average score 20), instead of move b (average score 17). This is because the small value of constant C, makes the exploration part of the equation not significant.
- As there are no further nodes in MCTS tree along that paths, the 1-move sequence a is the answer.

# Input
* Line 1: 2 space-separated values:
  * an integer N - the number of performed playouts
  * a real number C - the constant C (the exploration parameter)
* Next N lines: Sequence of movements performed in this playout, followed by a space, followed by the playout's result

# Output
* Sequence of movements that will be chosen in the MCTS tree using UCB1 selection.

# Constraints
* 0 < N < 500
* 0 < playout length < 50
* 1 < branching factor < 10
* -100.1 < score (playout's result) < 100.1
