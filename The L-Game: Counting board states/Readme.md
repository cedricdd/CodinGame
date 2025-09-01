# Puzzle
**The L-Game: Counting board states** https://www.codingame.com/contribute/view/133467cb6a3f574dde5cd07050123309d657a4

# Goal
You must count the number of possible board states for a generalized version of the L-Game.

Context: The L-Game is an abstract strategy board game designed by lateral thinker Edward de Bono. The board consists of a 4x4 grid of squares. The board is occupied by two 1x1 sized neutral blocking pieces, and one red and one blue L shaped tetromino (each of size 3x2). The shapes cannot overlap. You and your opponent own one L each. Players take turns making moves. You make a move by picking up your L and placing it in a new position on the board (which may involve flipping the L). Then moving one of the neutral blockers to a new location. The game is lost by the player who is unable to place their L in a new position.

In this problem, we consider a generalized version of the game. This is played on a height x width sized board and there are N 1x1 sized neutral blocking pieces. The two players' Ls remain the same size as the original. The task is, for a given board size and number of blockers, to print the total number of possible valid board configurations. A configuration is valid only when both Ls and all N blocks are placed on the board.

Note: The player to move (red or blue) is considered irrelevant for this problem. Boards differing only by a rotation and/or a flip are still considered different configurations. Boards that are otherwise the same, but can be made identical by swapping the colours of the Ls (red to blue and vice-versa) are considered distinct configurations. On the other hand, having different blockers in the same locations would not be considered as distinct configurations, because the blockers are considered identical.

Example: Consider a square board sized height = 3 x width = 3, which has N=1 neutral block. We represent the neutral block by an 'x', and the two Ls with 'R' and 'B' symbols, with the '.' as empty space. If the neutral piece is placed along any of the sides of the board, then it is not possible to put both players' Ls on the board at the same time. So there are no configurations in these 8 cases.

```
x..   .x.   ..x   ...   ...   ...   ...   ...
...   ...   ...   x..   ..x   ...   ...   ...
...   ...   ...   ...   ...   x..   .x.   ..x
```

When the blocker is in the middle of the board, the red L can be translated and rotated so that the long side lies along each of the edges of the board in turn. The blue L can fit in the remaining space. This gives four configurations.
```
RRR   BRR   BBB   RBB
RxB   BxR   BxR   RxB
BBB   BBR   RRR   RRB
```

And then if you flip the red L, you can get another set of four configurations.
```
RRR   BBR   BBB   RRB
BxR   BxR   RxB   RxB
BBB   BRR   RRR   RBB
```

Note that in, for example, configuration 1 and 3 above, the Ls are in the same locations but are different colours. These are considered different configurations.

So the total number of configurations would be 8x0+4+4 = 8, so you would print 8 here.

# Input
* Line 1: A row of three space separated integers: height width and N.
* height and width are the dimensions of the board.
* N is the number of neutral blocking pieces.

# Output
* Line 1 : A single integer with N_configs being the total number of legal configurations.

# Constraints
* 3 <= height <= 8
* 3 <= width <= 8
* N >= 0
* 0 <= N_configs < 2^64
