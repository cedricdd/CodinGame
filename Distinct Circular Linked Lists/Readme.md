# Puzzle
**Distinct Circular Linked Lists** https://www.codingame.com/training/medium/distinct-circular-linked-lists

# Goal
A circular linked list (CLL) is a sequence of nodes such that each node points to the node that comes directly after itself and the "last" node points to the "first" node.

```
sequence: 1, 2, 3
CLL:      ┌─> 1 ─> 2 ─> 3 ─┐
          └────────────────┘
```

Two CLLs are considered equal if they consist of the same nodes (same number and value of nodes) and can be rotated (without changing the relative order of nodes) such that their sequence of nodes align with each other. Some examples of equivalent CLLs are shown below.

Distinct nodes:
```
┌─> 1 ─> 2 ─> 3 ─┐   ┌─> 2 ─> 3 ─> 1 ─┐   ┌─> 3 ─> 1 ─> 2 ─┐
└────────────────┘   └────────────────┘   └────────────────┘
```
Repeated nodes:
```
┌─> 1 ─> 1 ─> 2 ─> 3 ─┐   ┌─> 3 ─> 1 ─> 1 ─> 2 ─┐
└─────────────────────┘   └─────────────────────┘
┌─> 2 ─> 3 ─> 1 ─> 1 ─┐   ┌─> 1 ─> 2 ─> 3 ─> 1 ─┐
└─────────────────────┘   └─────────────────────┘
```

Given N disconnected nodes, how many possible combinations of distinct (non-equal) CLLs can be formed using all of the given nodes?

# Input
* Line 1: A single integer N, the number of nodes.
* Next N lines: A single integer node, the value of the given node.

# Output
* Line 1: A single integer denoting the number of distinct CLL(s) that can be formed from the given node(s).
* Since the answer may be very large, return the number of distinct CLL(s) modulo 10⁹+7.

# Constraints
* 1 ≤ N ≤ 4000
* -10⁹ ≤ node ≤ 10⁹
