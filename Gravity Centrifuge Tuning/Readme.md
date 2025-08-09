# Puzzle
**Gravity Centrifuge Tuning** https://www.codingame.com/training/medium/gravity-centrifuge-tuning

# Goal
The program must generate an octal bitstream suitable for use in a damaged Gravity Centrifuge for tumbling a landscape a given number of times. This puzzle is in the same theme but completely independent, difficulty- and code-wise, from the Gravity Centrifuge puzzle at https://www.codingame.com/training/community/gravity-centrifuge .

Pristine Gravity Centrifuges

Same as in the parallel puzzle, a Gravity Centrifuge works as such: a twin inertial drive is programmed with an octal bitstream to perform a certain number of tumbles. How does the bitstream control the twin inertial drives?  
* Both drives are gotten to roll with an initial momentum of 1.
* The bits operate on the drives in alternating order, from least significant bit on. So bit 0 controls drive A, bit 1 drive B, bit 2 drive A again, and so on.
* When the bit is set, the drive tumbles the landscape around as many times as the current value of its momentum. It's all done by frictionless induction, so the drive's own momentum is unaffected.
* Simultaneously and regardless of bit value, the drive accelerates its twin by the current value of its momentum. Its own is still unaffected.
* Control then shifts to the other drive for the next bit in the stream.

Pristine Example

Using binary bitstream 1010, which we're reading right to left (lsb first, remember):
```
┌────────┬────────┬─────────┬──────────────────┐
│ A mom. │ B mom. │ Tumbles │ Action           │
├────────┼────────┼─────────┼──────────────────┤
│      1 │      1 │       0 │ 0 => no A tumble │
│      1 │      2 │       0 │ A induces 1 on B │
├────────┼────────┼─────────┼──────────────────┤
│      1 │      2 │       2 │ 1 => 2 B tumbles │
│      3 │      2 │       2 │ B induces 2 on A │
├────────┼────────┼─────────┼──────────────────┤
│      3 │      2 │       2 │ 0 => no A tumble │
│      3 │      5 │       2 │ A induces 3 on B │
├────────┼────────┼─────────┼──────────────────┤
│      3 │      5 │       7 │ 1 => 5 B tumbles │
 (B would induce 5 on A here, but we're done anyway)
└────────┴────────┴─────────┴──────────────────┘
```

The bitstream is then fully consumed and operation can stop. The landscape has been tumbled 7 times.

Damaged Gravity Centrifuges

The Gravity Centrifuge you've got access to has a cooling issue that hasn't been fixed yet. On your damaged Gravity Centrifuge, if two consecutive bits in the bitstream are set, the twin inertial drive overheats and burns down.

So don't do that.

# Input
* Line 1: N, the number of tumbles you want to program the centrifuge for.
  
# Output
* The octal representation of a bitstream that encodes a non-overheating N-tumble program. No leading zeroes.

# Constraints
* N >= 0
