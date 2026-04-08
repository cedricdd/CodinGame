# Puzzle
**Logic Gates**
https://www.codingame.com/contribute/view/1457103173fc1ac09f804c82de3e771810baa8
https://www.codingame.com/contribute/view/1457433ef751d8be85463ed5048fbf6dc459d6

# Goal
A sequence of logic gates must be evaluated in order.  
An initial binary value is provided.  
Each gate in the sequence uses the current output and a provided operand.  
Single‑input gates (BUFFER, NOT) ignore the operand and apply only to the current output.  
Two‑input gates use: (gate(currentOutput, operand) 
The final output after all gates is required.

# Input
* Line 1: N — number of gates
* Line 2: initialValue — the starting binary value
* Line 3: N space‑separated gate names
* Line 4: N space‑separated integers, the operands for each gate
* For single‑input gates, the operand is ignored.
* All values are binary (0 or 1).

# Output
* A single integer (0 or 1): the final output.

# Constraints
* 1 ≤ N ≤ 100
* initialValue ∈ {0, 1}
* operand[i] ∈ {0, 1}
* Gates ∈ {BUFFER, NOT, AND, OR, NAND, NOR, XOR, XNOR}
