# Puzzle
**MAGICAL FROG** https://www.codingame.com/training/hard/magical-frog

# Goal
Reda commenced studies at ArcanumTech, an institution where the fusion of magic and technology thrived. His instructor for Potions, a firm believer in hands-on learning, advised all students to acquire magical companions to assist in their academic endeavors. Without hesitation, Reda chose a Frog as his trusted companion.

Their initial assignment was captivating: students were tasked with training their magical pets in mathematical tricks. Reda opted to closely observe his frog's movements, searching for discernible patterns that might reveal a suitable trick to teach.

The dwelling for Reda's frog was the Heliopea Tower staircase at ArcanumTech. Every day, beginning at the base step (stair number 0), the frog possessed the capability to leap to any subsequent K stairs (where i+j ≤ N and 1 ≤ j ≤ K, i being the current stair and j being the number of stairs the frog jumps, assuming the frog was on stair i). It repeated this sequence of leaps until reaching the N'th stair.

Would you kindly aid Reda in determining the count of ways his frog could reach the N'th stair? As the count might be substantial, the output should be provided modulo 10^9+7.

In this context, different sequences of jumps are considered distinct ways.

# Input
* 2 space-separated integers N and K as described above.

# Output
* A single integer, the number of different ways to reach the N'th stair (modulo 10^9+7).

# Constraints
* 1 ≤ N ≤ 10^9
* 1 ≤ K ≤ 20
* K ≤ N
