# Puzzle
**Inversion count** https://www.codingame.com/training/medium/inversion-count

# Goal
In array sorting algorithms, an inversion count is a measure of how far an array is from being sorted.

Assuming we're sorting from lowest to highest, two values a[i] and a[j] form an inversion if a[i] > a[j] and i < j.  
An already sorted array has an inversion count of 0, and an array sorted in the exact opposite order has the maximum inversion count.

Your goal is to compute the inversion count of the given arrays.

For all the tests and validators:  
- Always assume a lowest to highest sort.
- The array values are generated with a simple LCG (https://en.wikipedia.org/wiki/Linear_congruential_generator).
- The LCG formula is X(n+1) = A * X(n) % M, with M, A and S (=X(0), the seed) given as part of the inputs.
- All the generated values are unique in their array.

Example : with M = 251, A = 33, S = 13 and N = 5

Using our LCG, we obtain the following array : 178 101 70 51 177  
178 forms an inversion with 4 values (101, 70, 51 and 177).  
101 forms an inversion with 2 values (70 and 51).  
70 forms an inversion with 1 value (51).  
51 doesn't form any inversion.  
177 doesn't form any inversion.  
So the inversion count of the array is 7, which is our output.  

# Input
* 1 line with 4 space separated integers : M, A, S and N.
* M and A are the parameters of the LCG. S is the seed (=X(0)).
* N is the length of the array, also equal to the number of values to generate. Note that the seed itself should not be included in the array.

# Output
* The inversion count of the array, for a lowest to highest sort.

# Constraints
* 1 < M, A, S < 10^7
* 1 < N < 10^6
