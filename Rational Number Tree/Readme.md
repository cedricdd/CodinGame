# Puzzle
**Rational Number Tree** https://www.codingame.com/training/medium/rational-number-tree

# Goal
A rational number is a number that can be expressed as the fraction p/q of two integers. We are going to describe a Number System which covers rational numbers.

We start with two seeds of rational numbers: 0/1 and 1/0.  
0/1 is zero. In this context it is the smallest rational number if we exclude negative numbers.  
1/0 is usually undefined and causes error in computing. But now we define it to be the largest rational number in our Number System, within computer's capacity.  

Then, we find the mediant of the two extreme seeds.  
The mediant of a/b and c/d is defined as (a+c)/(b+d).  

Insert the mediant in between.
```
       0/1  1/0
     0/1 (1/1) 1/0
0/1 (1/2) 1/1 (2/1) 1/0
```

For every two adjacent terms, insert a mediant. The row will grow in length indefinitely.

We can represent these terms in a binary tree.  
The above row of numbers is the inorder-traversal of the binary tree.
```
0/1................         ,................1/0
                   ,~ 1/1 ~.
                 ;           :
               ;               :
            1/2                 2/1
          /     \             /     \
       1/3       2/3       3/2       3/1
      /   \     /   \     /   \     /   \
     1/4  2/5  3/5  3/4  4/3  5/3  5/2  4/1
```

1/1 is the root of the tree.  
All rational numbers in the tree will not duplicate. All positive rational numbers in the Number System can be found somewhere in the tree. The tree itself is a subset of the Number System.

Using computer scientists' term, we use L and R to denote the left and right branches of a node in a binary tree. We specify a number by tracing its path from the root.

Some examples:
```
3/5 is LRL
2/5 is LLR
8/5 is RLRL
```

Tasks:  
You will be given some rational numbers. Translate them into L-R paths.  
You will also be given some L-R paths. Translate them into the rational numbers as they are found in the tree.  

All rational numbers in the tree are in reduced form. There is no 6/4 but there is 3/2.  
To keep them as fractions, we do not simplify 2/1 into 2. We keep expressing it as a numerator and a denominator.  
The two seeds and the root shall have special symbols other than L-R to represent them. In this puzzle we will not involve these special symbols.  
Ref: https://en.wikipedia.org/wiki/Stern%E2%80%93Brocot_tree  

# Input
* There will be multiple tests in each testcase.
* Line 1: An integer N for the number of tests to follow.
* Following N lines: Each line will be either a rational number in the form of p/q, or a path representation which is a string consisting of L and R
* By reading a line, you have to identify what kind of input it is. Then translate it into its equivalent representation of the other kind.

# Output
* Write N lines:
* For each input line,
  * write a L-R string if the input line is a rational number
  * write a p/q rational number if the input line is a L-R string

# Constraints
* 1 ≤ p, q ≤ 2^63
* 1 ≤ length of L-R string ≤ 2000
