# Puzzle
**Santa's Garland** https://www.codingame.com/training/medium/santas-garland

# Goal
It's Christmas Eve, and Santa is preparing to light up the grand Christmas tree! The garland consists of N nodes: a power source, a star, and N-2 bulbs in between, all connected by wires.

Each wire has a fuse rated for T steps. A step occurs when electricity moves along a wire from one node to another. When electricity passes through a wire at step i, the fuse blows at step i + T, permanently disconnecting the wire.

Important: The circuit must stay connected! If ANY wire on the path burns out before the electricity reaches the star, the garland won't light up.

Example: Consider a simple path: Power(0) — Bulb(1) — Star(2), where wire 0-1 has T=2 and wire 1-2 has T=3.
* Step 1: Electricity moves from node 0 to node 1 (wire 0-1 used, will burn at step 1+2=3)
* Step 2: Electricity moves from node 1 to node 2 (wire 1-2 used, will burn at step 2+3=5)
* Result: Path length is 2. Wire 0-1 burns at step 3, wire 1-2 burns at step 5. Both survive until step 2. Valid!

If wire 0-1 had T=1 instead, it would burn at step 1+1=2, exactly when we reach the star. Not valid!

Help Santa find the shortest valid path from the power source to the star!

# Input
* Line 1: Two space-separated integers N and M - the number of nodes and wires
* Line 2: Two space-separated integers S and E - the power source and the star
* Next M lines: Three space-separated integers A, B and T - a wire connecting nodes A and B with fuse rating T

# Output
* Line 1: The minimum number of steps to reach the star, or IMPOSSIBLE if no valid path exists

# Constraints
* 1 < N <= 100
* 0 < M <= 100
* 0 <= S, E < N
* 0 <= A, B < N
* 1 <= T <= 100
* S ≠ E
* No duplicate wires or self-loops
* Every node is connected to at least one other node
