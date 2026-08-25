# Puzzle
**Decimation sequence** https://www.codingame.com/contribute/view/15379528950cf01ee29cd9d3a77b684faade64

# Goal
You have to find the k-th value of a sequence whose n first terms are given.  
The next terms are defined by these n first terms in a weird way.  
If you decimate every n+1-th term, the sequence built on the remaining terms is the same as the original sequence.  
More surprising: the decimated terms also yield the original sequence.  
Beware, the first term’s index in the sequence is 1.  

# Input
* Line 1 : Two space-separated integers, n and k
* Line 2: n space-separated integers, representing the n first terms of the sequence

# Output
* The k-th term of the sequence

# Constraints
* 0 < n < 10
* 0 < k < 10¹⁰
* 0⩽ each of the n first terms of the sequence ⩽100
