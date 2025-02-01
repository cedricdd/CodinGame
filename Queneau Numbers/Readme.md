# Puzzle
**Queneau Numbers** https://www.codingame.com/training/medium/queneau-numbers

# Goal
Queneau Numbers were discovered by the French writer and mathematician Raymond Queneau, while member of the OULIPO.

A Queneau Number is a number N such that the sequence [1..N] can go through a series of spiral permutations (or "snail" permutations) and come back to [1..N] in exactly N iterations.  
The permutation consists in tracing a spiral from the last number of the sequence, spiraling towards the center.

You can visualize it for the sequence 1 2 3 4 5 :
```
1←←←←5
1→→→45
12←←45
12→345
thus [1 2 3 4 5] becomes [5 1 4 2 3]
```

For instance, 5 being a Queneau Number, the permutations will start from the sequence

```
1,2,3,4,5
```

And go as follows:
```
5,1,4,2,3
3,5,2,1,4
4,3,1,5,2
2,4,5,3,1
1,2,3,4,5
```

The Nth line is always the same as the initial sequence, or else the number is not a Queneau Number.

Erratum: Actually, a Queneau number should be such that the order of the permutation is exactly N, (i.e the sequence [1..N] cannot become [1..N] again before exactly N spiral permutations).
In this problem, all numbers such that [1..N] is still [1..N] after N spiral permutations are considered valid even if it might take less than N spiral permutations to encounter [1..N]

# Input
* One number N

# Output
* N lines: the different steps of permutations, as a comma-separated sequence  
OR
* IMPOSSIBLE if the number is not a Queneau number.

# Constraints
* 2 ≤ N ≤ 30
