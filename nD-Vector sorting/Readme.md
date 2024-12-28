# Puzzle
**nD-Vector sorting** https://www.codingame.com/training/easy/nd-vector-sorting

# Goal
Given an n-dimensional topology space and a partial order definition, you'll need to sort a set of vectors in that topology space.

The topology space does not have a fixed number of dimensions, so you'll have to implement dimensions dynamically.

The ordering relation we will use is the lexicographical order for each coordinate of each vector, following a permutation of coordinates given as input.  
For instance, in a 3D space, with 2 3 1 as coordinates permutation, the vectors should be sorted first by their 2nd coordinate, then their 3rd, then their 1st.

# Input
* Line 1: An integer D for the number of dimensions
* Line 2: An integer N for the number of vectors to sort
* Line 3: D space separated integers representing the coordinate permutation to apply for the ordering.
* Next N lines: D space separated integers representing the coordinate of a vector in this space.

# Output
* A single line containing N space separated integers representing the indexes of the input vectors, ordered by the given permuted ordering relation (ascending).
* Indexation of vectors begins at 1 (input line 4).

# Constraints
* 1 ≤ D ≤ 128
* 1 ≤ N ≤ 64
* There are no duplicates in the input vectors
  
