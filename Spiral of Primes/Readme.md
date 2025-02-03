# Puzzle
**Spiral of Primes** https://www.codingame.com/contribute/view/1172310e009d21fe85d4abaacca62809586e57

# Goal
Your mission is to generate a square matrix of minimal odd dimension M that can hold the first N prime numbers. You must fill the matrix with these primes arranged in a clockwise spiral starting from the center, and then fill any remaining cells with 0.

The spiral is constructed as follows:  
1. Compute the smallest odd integer M.
2. Identify the center cell of the M * M matrix.
3. Place the first prime number in the center. Then, move in the following repeating pattern to place the subsequent primes:
  - Right 1 step
  - Up 1 step
  - Left 2 steps
  - Down 2 steps
  - Right 3 steps
  - Up 3 steps
  - … and so on, expanding the spiral until all N primes are placed.
4. If any cells remain unfilled after placing all N primes, fill them with 0.

# Input
* Line 1: the number N of prime numbers to generate and place in the spiral.

# Output
* Output the resulting matrix as M lines. Each line should contain M space-separated integers representing one row of the matrix.

# Constraints
* 1 ≤ N ≤ 100
* N is an integer.
