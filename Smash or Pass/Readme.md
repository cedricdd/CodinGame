# Puzzle
**Smash or Pass** https://www.codingame.com/contribute/view/1262072dd32a78b6235b860f80ea026c532c60

You have n oranges, of various sizes. For each orange from 1 to n, you can either smash that orange or pass it. Smashing an orange means hitting it with a hammer really hard, and increasing the size of all oranges with a non-zero size by 1. The smashed orange will then be reduced to size 0. Passing an orange does nothing.

After either smashing or passing all oranges, the total size of all oranges is v. Your boss has a value k, and to impress him, you want to make v as close to k as possible without exceeding it! As a final touch, output an integer w representing the number of ways in order to achieve v, modulo 10⁹ + 7.

Note:
* Since the only order of smashes and passes you can perform is from 1 to n, ordering does not matter.
* An integer a modulo another integer b means the integer remainder when a is divided by b.

# Input
* Line 1: Two space-separated integers n and k — the number of oranges and boss's value.
* Line 2: n space-separated integers a — the size of the oranges.

# Output
* Two space-separated integers v and w — the total size of all oranges as close as possible to k without exceeding it, and the number of ways in order to achieve v modulo 10⁹ + 7, respectively.

# Constraints
* 1 ≤ n ≤ 100
* 0 ≤ k ≤ 10⁴
* 1 ≤ a ≤ 100
