# Puzzle
**Sequence Counter** https://www.codingame.com/contribute/view/1007647caf3b8bef9c355580824ca66670bca3

# Goal
You are given a sequence of alphanumeric characters. You are to split the sequence into the longest subsequences which contain only either digits that are consecutive or characters that are consecutive. For example, if given, a sequence of AB13DE14ED13, the subsequences you obtain are AB, 13, DE, 14, ED and 13 again. After obtaining the subsequences, tabulate which subsequence appears most often and print out its number of appearances followed by what the subsequence is on the next line.

If there are 2 or more subsequences which appear most frequently, print out the longest subsequence. If 2 subsequences are as long as one another and appear as often as one another, print out the subsequence that appears first.

# Input
* Line 1:An alphanumeric sequence with only capital letters and digits from 0-9

# Output
* Line 1: The number of times the most common subsequence appears
* Line 2:The most common subsequence

# Constraints
* The length of the alphanumeric sequence is less then 100
