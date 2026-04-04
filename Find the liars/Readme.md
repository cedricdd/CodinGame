# Puzzle
**Find the liars** https://www.codingame.com/training/medium/find-the-liars

# Goal
Among a group of people, will you be able to find the liars?  
They each give you a sentence to analyze.  

All N people give you one single sentence.  
A sentence is stated like: NUM>NUM>NUM[...]=(T or L)  
Where NUM is a person number. You can have up to a hundred of recursive NUM>.  
The Regex of a sentence is \d(>\d)*=[TL]  

T represents "Truth" and L represents "Lying".  
That can be translated by:  
NUM told that NUM told me that NUM [...] NUM is telling the truth/is lying

The people are numbered from 0 to 9.  
If someone is lying, then he inverses everything he says (truth became lie and lie became truth).  
If someone is telling the truth, then for him everything he said is correct.  

For every case, there is only one single solution.  

Examples:  
2>0=L: 2 told that 0 is lying  
2>3>0=T: 2 told that 3 told me that 0 is telling the truth  

Explanation of the first exemple case :  
If 0 is saying the truth, then 1 must lie 0>1=L  
But if 1 lie, 2 must lie too 1>2=T (a liar say that 2 is telling the truth)  
If 0 tell the truth, there is 2 liars, but it is impossible, so 0 is the liar.  

# Input
* Line 1: An integer N for the number of people.
* Line 2: An integer L for the number of liars.
* Next N lines: A string sentence about the sentence of the person.

# Output
* Line 1: The people who lie separated by spaces, in ascending order.

# Constraints
* 2 ≤ N ≤ 10
* 1 ≤ L ≤ 9
