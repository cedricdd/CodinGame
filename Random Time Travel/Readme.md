# Puzzle
**Random Time Travel** https://www.codingame.com/training/medium/random-time-travel

# Goal
A linear congruential generator (LCG) is a pseudorandom number generator algorithm defined by the recurrence relation:
```
lcg(seed) = (a * seed + c) % m
```

LCGs are notably used by Java's Math.random().   
It is sometimes useful to be able to check the value given by the random number generator a number of steps in the future or in the past, given the current internal seed of the LCG.

You are given the seed, the parameters a, c and m of an LCG and the number of steps.

If steps is positive you must return the result of the composition of the lcg function steps times.
```
lcg(lcg(...lcg(seed)))
```

If steps is negative you must return the result of the composition of the reverse of the lcg function.
```
lcg^-1(lcg^-1(...lcg^-1(seed)))
```

# Input
* Line 1: Three space separated integers a, c and m for the LCG parameters.
* Line 2: An integer seed
* Line 3: An integer steps

# Output
* Line 1 : The output of the LCG, starting at seed and repeating steps times.

# Constraints
* 0 ≤ a < 2^64
* 0 ≤ c < 2^64
* 1 ≤ m < 2^64, m is a power of 2
* 0 ≤ seed < 2^64
* -2^63 <= steps < 2^63
