# Puzzle
**A Coin Guessing Game** https://www.codingame.com/training/medium/a-coin-guessing-game

# Goal
Yulia has annotated both sides of N identical coins with the numbers from 1 to 2×N.  
Each number has been used exactly once and each coin has received an odd number on one side and an even number on the other side.  
She asks Zack, who is aware of these rules but does not know the chosen distribution of numbers, to guess all the even/odd combinations by playing a little game. 

Yulia shakes and throws the coins on the table and reveals the resulting (seemingly random) configuration to Zack, letting him see the numbers on the visible side of each coin.  
No other information can allow Zack to identify or distinguish the coins.

Yulia repeats that operation several times and, after T throws in total, stops and informs Zack he has seen enough to guess all the pairs of numbers on the coins.

Can you help Zack guess the numbers that were written on all of the coins?

**Example:** N = 3 coins, the numbers from 1 to 6 are used.  
- First throw: 3 1 6.  
Zack learns that the even number 6 is not associated with the odd numbers 1 or 3, hence it has to be paired with 5.  
- Second throw: 4 1 6.  
Zack learns that 1 is not paired with 4. He also sees, for the second time, that it is not paired with 6. So 1 it has to be paired with 2, and consequently 3 is paired with 4.  
Solution: 1/2, 3/4, 5/6. Expected output: 2 4 6.  


That said, Yulia has a secret criterion. She calls "coins ring" a sequence of numbers i1, i2, i3, ..., ik, such that all the coins i1/i2, i2/i3, ..., ik/i1 are still acceptable assuming all possible "deductions" are made from the configurations that have been seen until now.  
She never stops before making sure that Zack can deductively get rid of all the coins rings.

# Input
* Line 1: Two space-separated integers N and T corresponding to the number of coins and the number of configurations to follow.
* Next T lines: N space-separated integers, in no particular order, corresponding to the coin sides that Zack sees after each throw.

# Output
* One line of N space-separated even integers corresponding to the even numbers written on the other side of the coin sides carrying the odd numbers 1, 3, 5, ..., 2×N-1 in order.

# Constraints
* 2 ≤ N ≤ 150
* 1 ≤ T ≤ 15
  
The given data guarantees a unique solution.
