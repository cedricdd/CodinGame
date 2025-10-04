# Puzzle
**Van Eck's sequence** https://www.codingame.com/training/easy/van-ecks-sequence

# Goal
The rule here is that you start with an element A1, and whenever you get to a number you have not seen before, the following term is a 0. But if the number An has appeared previously in the sequence, then you count the number of terms since the last appearance of An, and that number is the following term.

For a series starting with A1 as 0, the series will be:
```
0, 0, 1, 0, 2, 0, 2, 2, 1, 6, 0, 5, 0, 2, 6, 5, 4, 0, 5, 3, 0, 3, …
```

Term 1: The first term is 0.  
Term 2: Since we haven’t seen 0 before, the second term is 0.  
Term 3: Since we had seen a 0 before, one step back, the third term is 1  
Term 4: Since we haven’t seen a 1 before, the fourth term is 0  
Term 5: Since we had seen a 0 before, two steps back, the fifth term is 2.  
And so on...  

# Input
* Line 1: a single integer A1 that is the first element in the sequence.
* Line 2: an integer N representing the nth position of an element in the sequence that is to be displayed as output.

# Output
* A single integer that is the Nth element of the sequence.

# Constraints
* 0 ≤ A1 ≤ 200
* 1 ≤ N ≤ 1000000
