# Puzzle
**DAWG** https://www.codingame.com/training/hard/dawg

# Goal
A directed acyclic word graph (DAWG) is a data structure that represents a set of strings, often used as a compact way to store a dictionary. Each word starts from the source node and ends at the sink node. In between the source and sink is a network of nodes, connected by directed edges labeled either with a letter or as EOW (end-of-word) when connecting to the sink. Each node has at most one outgoing edge for each letter or EOW. Following every possible path from the source node to the sink node gives you the list of words in the dictionary.

Given a set of strings, determine the minimum number of nodes needed to store them in a DAWG.

A graph for the example can be found here: https://en.wikipedia.org/wiki/Deterministic_acyclic_finite_state_automaton

# Input
* Line 1: The number of words N
* Next N lines: The word list

# Output
* The number of nodes needed

# Constraints
* N ≤ 1300
