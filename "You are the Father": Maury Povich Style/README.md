# Puzzle 
**"You are the Father": Maury Povich Style** https://www.codingame.com/training/easy/you-are-the-father-maury-povich-style

# Goal
~ ~ ~ P o p   C u l t u r e   B a c k g r o u n d ~ ~ ~

Maury Povich hosted a popular talk show in America for decades.

A famous and common theme for an episode was helping a new mom figure out which of her past "gentleman callers" is her child's biological father. 
Maury’s staff would swab and paternity-test a sample from each possible man and then Maury would announce with much fanfare either "You are NOT the father!" or "You ARE the father!"

(For your amusement only, see banner image and video link far below for clips of that; it isn't needed to solve this puzzle.)

~ ~ ~ B i o l o g y   B a c k g r o u n d ~ ~ ~

Every creature has multiple "Pairs of Chromosomes," henceforth called chromPairs.

For each chromPair,
Mother and Father each contribute 1 chromosome to form the child's chromPair.

In the very simplified world of this puzzle, a chromosome is simply 1 character and a chromPair is simply 2 characters.

~ ~ ~ E x a m p l e ~ ~ ~

The species has 2 chromPairs.
* Mother is: ab cd
* Father is: wx yz

Their child is created by having:
* 1 of ab plus 1 of wx for its 1st chromPair, and
* 1 of cd plus 1 of yz for its 2nd chromPair.

So the child could be: aw cy or bw cz ... or any of 14 other combinations.

However, their child cannot be:
* aq cy ... because q is not a chromosome from either parent.
* ab cy ... because it doesn't have anything from Father's 1st chromPair.
* az cy ... because even though Father has z, it's not in his 1st chromPair.

NOTE: Order in chromPair doesn't matter: aw is exactly equal to wa.

~ ~ ~ Y o u r   T a s k ~ ~ ~

Given the above rules, help Maury Povich tell each single mother who the actualFather of her child is.

# Input
- Line 1: Mother mother's name: some spaces, followed by some number of chromPairs (each separated by a space)
- Line 2: Child child's name: some spaces, followed by some number of chromPairs (each separated by a space)
- Line 3: An integer, the number of possible fathers (numOfPossibleFathers)

- Next numOfPossibleFathers Lines: Possible father's name: some spaces, followed by some number of chromPairs (each separated by a space)

# Output
- Line 1: actualFather, you are the father!

# Constraints
- All names are one word (no spaces).
- All creatures in a given test/validator have the same number of chromPairs.
- There is only one that can be the father; in other words, there is always exactly one actualFather.
