# Puzzle
**The Curator’s Streak** https://www.codingame.com/contribute/view/133863fd7f96b728b030fd94d5fd0564332c3f

# Goal
A museum curator oversees a row of crates. Each crate is labeled with an integer between 1 and M (inclusive).  
The curator will choose one contiguous segment of crates for a special exhibit. In the final exhibit, all crates must end up showing the same label. To achieve this, the curator may repaint some crates; however, at most R crates in the chosen segment may be repainted.

Determine the maximum possible length of a contiguous segment that can be made uniform using at most R repaints.

# Input
* Line 1: Three space-separated integers N, M and R, representing the number of crates, the maximum possible value of a label, and the maximum number of crates that may be repainted respectively.
* Line 2: N space-separated integers representing the labels of the crates in order.

# Output
* A single integer — the maximum length of a contiguous segment that can be made uniform with at most R repaints.

# Constraints
* 1 ≤ N ≤ 100
* 1 ≤ M ≤ 100
* 0 ≤ R ≤ N
