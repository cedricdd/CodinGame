# Puzzle
**Networking** https://www.codingame.com/contribute/view/1168352f1e2693c9e0c242d68a4d16a1ff9227

# Goal
Calculate how many separate groups of people there are in an organisation based on lists of users in email threads.

A group consists of people who have email threads in common up to any degree of separation - e.g. if Group 1 and 2 are separate and person A in Group 1 sends an email to person B in Group 2, the groups become one and include everyone from Group 1 and Group 2.

So two groups are separate if no member of either group has ever appeared in an email thread with anyone from the other group.

# Input
* Line 1: An integer N with the number of email threads.
* Next N lines: A list of space separated strings representing the unique list of p participants in an email thread. Each value represents a (hashed) user's email address.

# Output
* Line 1 : The number g of separate groups of users.

# Constraints
* 5 ≤ N ≤ 200
* 2 ≤ p ≤ 8
* 1 ≤ g ≤ 200
