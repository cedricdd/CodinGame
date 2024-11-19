# Puzzle
**Kaprekar Invariants** https://www.codingame.com/contribute/view/1118192da7cf6fd7b299effc1a274abe2b0bc7

# Goal
For a positive integer 𝒊 written in a given base, let α and β represent the largest and smallest values that can be rewritten using the same digits of 𝒊. Specifically, α and β are created by sorting the digits in either direction. If 𝒊 = 6174 in base 10, for instance, then α = 7641 and β = 1467.

Named after a 20th Century schoolteacher in India, a Kaprekar mapping is the function 𝑲ₙ that takes the difference between α and β in base n. Recall that an invariant of a function 𝒇 is a value 𝒙 such that 𝒇(𝒙) = 𝒙. 6174 is an invariant of 𝑲₁₀ because 𝑲₁₀(6174) = 7641 - 1467 = 6174.

To give another example, consider hexadecimal numbers with three digits. 7F8 is an invariant of 𝑲₁₆ since α - β = F87₁₆ - 78F₁₆ = 3975 - 1935 = 2040 = 7F8 base 16. In both this case and the one above, these happen to be the only nontrivial solutions, ignoring strings of all 0.

Given a base n and a number of digits d, find all nonzero invariants of 𝑲ₙ with that many digits.

# Input
* Line 1: An integer n for the numeral base
* Line 2: An integer d for the number of digits

# Output
* Line 1: An integer S for the number of solutions
* Next S lines: An integer solution (of length d written in base n)
* Solutions should be sorted. Use uppercase letters for any digits after 9.

# Constraints
* 2 < n ≤ 36
* 2 < d < 80
