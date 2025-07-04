# Puzzle
**Find the Shortest Path Home** https://www.codingame.com/training/medium/find-the-shortest-path-home

# Goal
You are given a route that consists of directions represented by the characters N (North), W (West) and E (East). This route describes how you traveled from your starting point to your current location. Your task is to find the all shortest paths to return to your starting point without retracing any part of your original route or following the reverse order.

You can visit the same vertex multiple times, but you must avoid using any segment (the direct connection between two vertices) that was part of the original route.

For example:
```
4 ← 1 → 2
↓    ↑   ↓
5 → P ← 3
```

P: Starting Point  
Original route: N (P → 1)  
Valid return: ESW (1 → 2 → 3 → P)  
Valid return: WSE (1 → 4 → 5 → P)  
Invalid return: S (1 → P)  

# Input
* Line 1: The input consists of a single string route where each character in the string represents a direction you traveled (N, W or E). The first direction is always N.

# Output
* 1 or more lines: The paths to return to your starting point without retracing your original route. The output should be a string which consists of E (East), S (South) and W (West) only.
* If multiple shortest paths exist, the output should display each path on a separate line, sorted alphabetically.

# Constraints
* 1 ≤ length of route ≤ 25
