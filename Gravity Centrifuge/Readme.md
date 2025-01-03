# Puzzle
**Gravity Centrifuge** https://www.codingame.com/training/community/gravity-centrifuge

# Goal
The program must output the result of tumbling a landscape a certain (large!) number of times.

*Tumbling entails:*  
 * rotating the landscape counterclockwise by 90°
 * letting the hash bits # fall down

The map is composed of . and #.

But wait… we're going to be tumbling the landscape so many times we might not live to see the result! So instead of just typing the number of tumbles we want on a simple Gravity Tumbler, we're going to use a Gravity Centrifuge and its much improved tumbling capacity, relying on twin inertial drives and their incomparable frictionless movement induction.

The twin inertial drives are programmed with a bitstream used as such:  
* Both drives are gotten to roll with an initial momentum of 1.
* The bits operate on the drives in alternating order, from least significant bit on. So bit 0 controls drive A, bit 1 drive B, bit 2 drive A again, and so on.
* When the bit is set, the drive tumbles the landscape around as many times as the current value of its momentum. It's all done by frictionless induction, so the drive's own momentum is unaffected.
* Simultaneously and regardless of bit value, the drive accelerates its twin by the current value of its momentum. Its own is still unaffected.
* Control then shifts to the other drive for the next bit in the stream.

For convenience (and input size limitations), the operation bitstream is provided in octal. Yes, twin inertial drives are a wee bit baroque.

Example
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


(This puzzle is a “harder” version of community puzzle “Gravity Tumbler”. You may want to solve that one first.)

# Input
* Line 1: two space-separated integers: the map width and height
* Line 2: the operation bitstream, in octal form
* Next height lines: width characters (empty bits . and heavy bits #)

# Output
* For an odd tumble count: width lines of height characters where the # are at the bottom.
* For an even tumble count: height lines of width characters.

# Constraints
* 0 < width ≤ 100
* 0 < height ≤ 100
* 0 < number of bits ≤ 29999
* The input map is in a “stable” configuration, i.e. the heavy bits are already at the bottom.
