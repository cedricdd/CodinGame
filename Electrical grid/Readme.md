# Puzzle
**Electrical grid** https://www.codingame.com/training/hard/electrical-grid

# Goal
Edison is bringing electricity to N houses. He has already set up a power generator in house 1 and wants to connect it to the other houses. There are M pairs of houses that can be connected together, and we know how much making a link between each pair costs. Your job is to find which houses to link so that all the houses are connected to house 1 (directly or through other houses), while minimizing the total cost.

* **there is always a solution that connects all houses**
* **the total distance from the generator to a house does not matter, as long as there is a path between them**

# Input
* Line 1: two integers, N and M, respectively the number of houses, and the number of connectable pairs
* Next M lines three integers House1, House2 and Cost representing a possible connection between two houses

# Output
* Line 1: two integers, K and C, respectively the number of connections to make, and the total cost
* Next K lines: the connections, as given, numerically sorted (on House1, then on House2)

# Constraints
* 1 ≤ N ≤ 5000
* 0 ≤ M ≤ 50000
* 1 ≤ House1, House2, ≤ N
