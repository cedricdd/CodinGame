# Puzzle
**Quantum Pantry** https://www.codingame.com/contribute/view/13449078f8e7dfbaf6d45ff0cf22e0e209b49a

# Goal
In a quantum culinary lab, there are n ingredient jars. Each jar starts in a superposition of two flavors: “low” and “high.” When you open (measure) a jar, it collapses to one of the two flavors depending on the total flavor you have accumulated so far.

Formally, jar i has three integers:
* Lᵢ — flavor value if it collapses to “low,”
* Hᵢ — flavor value if it collapses to “high,”
* Tᵢ — a collapse threshold.

Let S be the total flavor accumulated before opening jar i. Then:
* If S < Tᵢ, the jar collapses to Lᵢ (add Lᵢ to S).
* If S ≥ Tᵢ, the jar collapses to Hᵢ (add Hᵢ to S).

You may choose any order to open the jars. No other effects occur; unopened jars do not change until opened.

Your task is to determine the maximum final total flavor after all jars are opened.

# Input
* Line 1: An integer n — the number of jars.
* Next n lines: Three space-separated integers Lᵢ Hᵢ Tᵢ.

# Output
* A single integer — the maximum final total flavor

# Constraints
* 1 ≤ n ≤ 10
* 0 ≤ Lᵢ, Hᵢ ≤ 10⁹
* 0 ≤ Tᵢ ≤ 10¹⁰
