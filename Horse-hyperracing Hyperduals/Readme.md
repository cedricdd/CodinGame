# Puzzle
**Horse-hyperracing Hyperduals** https://www.codingame.com/training/medium/horse-hyperracing-hyperduals

# Goal
The Casablanca hyperduals are a great success. Such a huge hit that hamburger-heaving horse hoards were heard heading for the harbor, hampering heavy hearses from herding horny hens hither, and also helping hinder the hyper-hullabaloo hovering around the hippodrome. And registering to compete, obviously.

In addition to the regular horses whose velocity and elegance are directly provided in input, a waitlist of new applicants is provided in compressed form. You are provided with the seed to a linear congruential generator, whose even terms (starting at 0) represent the new horses' velocity, and whose odd terms represent their elegance. The LCG works as follows:

```
X(0) = X, the seed provided in input
X(n+1) = 1103515245 * X(n) + 12345 [mod 2^31]
```

As before, given a horse pair with strengths (V1,E1) and (V2,E2), the race is assumed to be as interesting as abs(V2-V1)+abs(E2-E1) is small.

Write a program which, using a given number of strengths, identifies the two closest strengths and shows their difference with an integer.

(This is a harder version of community puzzle “Horse-racing Hyperduals”. You may want to solve that problem first.)

Example

```
You are given a classical horse of strength (0,0), and two congruential horses seeded by 42424242. The congruential sequence is thus:
X(0) = 42424242
X(1) = 1443152643
X(2) = 717496960
X(3) = 654696633
```

So we are comparing horses of strengths (0,0), (42424242,1443152643) and (717496960,654696633). Interestingness of a race between the first and second horse is 1485576885; the first and third 1372193593; the second and third 1463528728. Therefore the most interesting race is between first and third, and you should output 1372193593.

# Input
* Line 1: the number N of classical horses, the number M of congruential horses, the seed X of the generator, space-separated
* N following lines: the velocity Vi and elegance Ei of each classical horse, space-separated

# Output
* Line 1: the difference D between the two closest strengths

# Constraints
* 2 ≤ N+M ≤ 100000
* 0 ≤ N, M
* 0 ≤ Vi,Ei < 2^31
* D ≥ 0
* All values are integral.
