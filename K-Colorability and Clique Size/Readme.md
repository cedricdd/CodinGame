# Puzzle
**K-Colorability and Clique Size** https://www.codingame.com/contribute/view/10713364ef48f52caa7c916738f0e1f3a63bf2

# Goal
Determine if the vertices of a given undirected graph can be colored with at most k colors such that no two adjacent vertices share the same color. If it is possible, find the size of the largest clique in the graph.

*Note:*  
Note 1 The graph coloring and clique size are two independent tasks. You do not need to perform graph coloring to find the largest clique size.  
Note 2 A clique is a set of vertices where every pair of distinct vertices is connected by an edge.

*Input:*  
```
4 3
0 1
1 2
2 3
2
```

*Graph Example:*
```
0 --- 1 --- 2 --- 3
```

*Graph Coloring:*  
Color this graph with 2 colors:  
* Vertices 0 and 2 in color 1.
* Vertices 1 and 3 in color 2

The graph can be colored with 2 colors while ensuring no two adjacent vertices share the same color.

*Clique:*  
The largest clique in this graph consists of only 2 vertices, such as {1, 2}, as each pair of these vertices is connected by an edge.

*Output:*  
YES 2

# Input
* First Line Two space-separated integers, n (the number of vertices) and m (the number of edges).
* Next m Lines Each contains two space-separated integers:
* u and v, indicating an edge between vertices u and v.
* Last Line An integer k for the maximum colors to use.

# Output
* Line 1 If the graph can be colored with k colors, output YES followed by the size of the largest clique, separated by a space.
* If the graph cannot be colored with k colors, output NO.

# Constraints
* 1 ≤ n ≤ 10
* 0 ≤ m ≤ 10
* 0 ≤ u, v < n
* 1 ≤ k ≤ 10
