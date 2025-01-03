# Puzzle
**A-star exercise** https://www.codingame.com/training/medium/a-star-exercise

# Goal
You are given an undirected graph with weighted edges, a start and a goal node, and for each node the heuristic value, which is the estimated distance to the end. Your task is to trace a canonical A* execution (see https://en.wikipedia.org/wiki/A*_search_algorithm) by computing a shortest path from the start to the goal.

We recall that the A* algorithm will rely on three values for each node v:
- the g-value, which is the minimum distance from the start to v;
- the h-value, which is an estimation of the minimum distance from v to the goal and is given by the heuristic provided in input;
- the f-value, which is the sum of the g-value and h-value.

There is always a path between the start and the goal. The given heuristic is admissible and consistent, meaning that the A* algorithm will always find a shortest path from the start to the goal.

When some nodes have the same f-value, the one with the smaller identifier is considered first.

# Input
* Line 1: 4 space-separated integers:
  * N - the number of nodes in the graph (nodes are identified by integers from 0 to N-1),
  * E - the number of edges in the graph,
  * S - the identifier of the start node,
  * G - the identifier of the goal node

* Line 2: N space-separated integers - estimated distances to the goal (heuristics) for each node from 0 to N-1

* Next E lines: three space-separated integers X Y C that indicate the edge between nodes X and Y with the cost C.
  
Notice that, since the graph is undirected, there is also an edge from Y to X with the same cost.

# Output
* A sequence of lines containing information about the node expanded in each step of the algorithm: the node's identifier, followed by a space, followed by its f-value.

# Constraints
* 0 < N < 100
* 0 < E < 10000
* 0 < C < 1000
