# Puzzle
**Plague, Jr** https://www.codingame.com/training/medium/plague-jr

# Goal
You want to destroy humankind.

To practice your humankind-destruction skills, you've set up a network of nutritive tissue pads connected with organic rods, such that a unique path from a pad to another always exists.   
You'll infect one of the pads with the Disease, and watch it spread.   
Every night, the Disease will spread from the infected pads to the adjacent non-infected pads.  

You are given the network structure. Assuming optimal choice for the initial Disease injection, after how many nights would the entire network be affected?  

# Input
* Line 1: N the number of rods.
* N lines: A B indices of the pads connected by that rod.

# Output
* R number of nights to total infection.

# Constraints
* The network is connected and acyclic.
* 0 ≤ A, B ≤ N < 1000
