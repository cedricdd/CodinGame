# Puzzle
**Find the missing plus signs in addition** https://www.codingame.com/training/medium/find-the-missing-plus-signs-in-addition

# Goal
The sum of a set of N integers is S  
Unfortunately, the plus signs have disappeared and the integers have been concatenated in a string O...  
You have to find the positions of the plus signs to recover the addition.  
If there is no solution , then print "No solution", otherwise print the solution(s) in lexicographic order ( 1+11 before 11+1 ).  

# Input
* Line 1 : An integer N as the number of terms in the addition
* Line 2 : An long integer S as the sum of the N integers
* Line 3 : A string O as the concatenation of the N integers

# Output
* Line : If there is no solution, print "No solution"
* Otherwise print the solution(s), one per line, ordered in lexicographic order (+ before 0,1,2,3...): formatted as a valid equation a1+a2+...+aN=S

# Constraints
* 2 <= N <= 10
