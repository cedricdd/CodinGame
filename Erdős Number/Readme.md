# Puzzle
**Erdős Number** https://www.codingame.com/ide/puzzle/erdos-number

# Goal
The Erdős number describes the minimum "collaborative distance" between the scientist Paul Erdős and another person, as measured by co-authored publications. The Hungarian mathematician is the most prolific author of his field since he wrote more than 1500 papers in his lifetime.

If a person has an Erdős number of 1, it means that he has written a research paper with Erdős; a Erdős number equal to 2 means that he co-authored an article with a direct collaborator of Erdős but not with Erdős himself, etc.

If a person is not a direct or indirect collaborator with Erdős, their Erdős number is infinite.

From a list of publications and their authors, you need to give the Erdős number of the scientist given in the input. If this number is not zero or infinity, you must output the list of ordered article titles (from the scientist's paper to the paper written by Erdős).

# Input
* Line 1: A string for the name of the scientist whose Erdős number is requested.
* Line 2: An int N for the number of publications (the list contains at least one paper from Paul Erdős and one from the scientist).
* Next N lines: The title of each publications between ".
* Next N lines: The authors of the corresponding publication, separated by spaces.

# Output
* Line 1: The Erdős number e of the requested scientist or infinite.
* Next e lines: The titles of publications, from the one that the scientist published to the one published by Paul Erdős.

# Constraints
* 1 ≤ N ≤ 100
