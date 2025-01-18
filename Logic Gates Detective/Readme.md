# Puzzle
**Logic Gates Detective** https://www.codingame.com/training/medium/logic-gates-detective

# Goal
Given a graph of logic gates, can you deduce the values of expected nodes?

In the example case, from (1) a or b -> d and (2) a=0, d=1, we can deduce that b=1.  
Based on the other dependency rules, we got c=0, f=0, g=1 and h=1.  
So the output for h c g is 101.  

# Input
* Line 1: the observations for some of the nodes, formatted as node name:value, separated by a space
* Line 2: the names of the nodes to output, separated by a space
* Line 3: number of dependency rules n
* Following n lines: the dependency rules on the graph. formatted as node_a operation node_b -> node_c, meaning that node_c is the result of the operation on node_a and node_b
 
# Output
* A single concatenated string containing the values of the specified nodes in the given order.

# Constraints
* every node's value is either 1 or 0.
* operation: or, and, xor.
* node name is alphanumeric and always starts with a letter.
* While multiple solutions may exist for a given graph, the sequence of values for the output nodes is guaranteed to be unique.
