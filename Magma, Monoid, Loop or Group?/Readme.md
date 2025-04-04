# Puzzle
**Magma, Monoid, Loop or Group?** https://www.codingame.com/contribute/view/95352b13c46ce5b09d2e6c133a2339bde3fb3

# Goal
One of the most basic algebraic structures in mathematics is a magma. A magma consists of a set M, together with a binary operation * that is closed. Thus, * can be seen as a deterministic function that takes as input two elements m, n from M and outputs a third element of M, often denoted as "m*n". Note that m, n, and m*n need not be distinct.

A magma M,* is said to have an identity if it contains an element e such that e*x = x = x*e for all elements x of M. Such element, if it exists, is always unique.

Two additional properties are often imposed on a magma M,* with identity e:
1) Associativity: for all x, y and z in M, (x*y)*z = x*(y*z).
2) Invertibility: for all x in M, there exist y and z in M such that y*x = e = x*z.

A magma with identity that satisfies (I) is called a monoid.  
A magma with identity that satisfies (II) is called a loop.  
A magma with identity that both (I) and (II) is called a group.  

The goal of this puzzle is to determine whether a given magma is a monoid, a loop, a group, or none of these. The magma will be provided in the form of a Cayley table. The elements of this table are always "row * column". For example:

```
M | a b
-------
a | b a
b | b b
```

This means that M,* is a magma with elements a and b, and the binary operation * is given by a*a = b, a*b=a, b*a=b and b*b=b.

# Input
* Line 1: An integer N that gives the number of elements the magma will contain.
* Line 2: N+1 space-separated characters, forming the heading of the Cayley table. The first character name is the name of the magma, the following N characters represent the elements of the magma and are distinct.
* Next N lines: the rows of the Cayley table, each row consisting of N+1 space-separated characters.

# Output
* Line 1: The line "name is a structure", where name is the name appearing in the Cayley table and structure is either monoid (if only (I) is satisfied), loop (if only (II) is satisfied), group (if both (I) and (II) are satisfied) or magma (if the magma has no identity, or neither (I) nor (II) is satisfied).

# Constraints
* 1 ≤ N ≤ 26
* The elements of the magma will always be represented by a single lowercase letter a-z.
