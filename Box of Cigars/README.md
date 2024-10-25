# Puzzle
**Box of Cigars** https://www.codingame.com/training/medium/box-of-cigars

# Goal
Hercule Poirot is a man of order and precision. He has a number of cigars, and he keeps them strictly in increasing height order.  
As a New Year present, Poirot decides to gift his friend, Captain Hastings, a box of cigars. He has decided to give Hastings a set of cigars, such that the difference between every 2 consecutive cigars is same.  
Find out the maximum number of cigars Poirot can gift Hastings.

*The Problem:*  
Given the lengths of N cigars (sorted in ascending order), find the maximum number of cigars which have a common difference.

*Rules:*  
There are N cigars.  
Each cigar has a length LNT.  
Display the largest number of cigars which are increasing with the same difference.  

*Example:*  
Let there be 10 cigars of length:  
3, 5, 6, 7, 10, 12, 14, 15, 18, 20  
In this case the maximum number of cigars Poirot can gift is 4. (5 - 10 - 15 - 20)

# Input
* Line 1: An integer N, the number of cigars
* Next N Lines: An integer LNT, the length of a cigar

(Note: The lengths of the cigars are sorted in ascending order)

# Output
* Line 1: An integer MAX, the maximum number of cigars Poirot can gift

# Constraints
* 2 ≤ N ≤ 1000
* 1 ≤ LNT ≤ 1000

(Note: The lengths of the cigars may not be unique)
