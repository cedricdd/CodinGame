# Puzzle
**Mask-Matching** https://www.codingame.com/contribute/view/1084536b00a9c8ed311d1f295b5670475806f7

# Goal
You are given a positive integer called mask in hexadecimal notation, which is less than 2^28. Your task is to find up to 15 integers that match the condition:

(mask & n) == n

where n is a positive integer. These integers are called mask-matching integers.

Output the mask-matching integers in decimal form, starting from the smallest. If there are more than 15 integers that match, output the first 13 smallest numbers, followed by ,..., and the last 2 largest numbers.

# Input
* Line 1: A single positive integer mask in hexadecimal notation

# Output
* Line 1: A comma-separated list of up to 15 mask-matching integers in decimal.

# Constraints
* 1 ≤ mask ≤ 0xFFFFFFF (i.e. 2^28 - 1)
