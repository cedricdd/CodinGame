# Puzzle
**Jumping squirrels** https://www.codingame.com/contribute/view/113304dcffc65a35a9540307ebdbd9740e388c

# Goal
N squirrels are located on the first tree out of K trees.  
Each second each squirrel can either stay on the tree it is on or jump to another tree.  
The probability of staying on the tree is p.  
The probabilities of jumping to any of the available trees are equal, meaning (1 - p) / number of available trees.  

Print the expected number of squirrels on the Lth tree after T seconds.

(To solve this, you might need to read about Markov chains, create a transition matrix and multiply it by itself T times)  

# Input
* Line 1: N, K, T: number of squirrels, number of trees, number of seconds, separated by a space.
* Line 2: p, L: probability of staying on the same tree, id of the tree to count squirrels on, separated by a space.
* Next K lines: list of tree ids (1..K) available to jump to from this tree, separated by a space. There always is at least one tree available.

# Output
* The expected amount of squirrels on the Lth tree after T seconds, rounded to 2 decimal places.

# Constraints
* 0 < N, K, T < 10
* 0 <= p <= 1
