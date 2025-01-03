# Puzzle
**Learning words** https://www.codingame.com/contribute/view/537069161bfbd37abe5eb74fa5af5f44ef652

# Goal
Lisa wants to learn English with minimum effort, and she has prepared a text to study.

Her objective is to learn the minimum amount of words while reaching her comprehension target. Here, her target is to understand ALL the sentences.   
To "understand a sentence" she sets the bar at understanding 50% of the words. Find the amount of words she needs to learn.

Notes:
1) For this puzzle there are no duplicate words inside the sentences.
2) If the sentence is of odd length, round the half up. That is if it's 3, you'd need 2 words, if 7, 4 etc.
3) The text only contains English letters and spaces to differentiate the words.
4) Ignore case when comparing words. Hello is equal to hello.

# Input
* Line 1: An integer n for the number of sentences.
* Next N lines: A string sentence.

# Output
* The minimum amount of words that Lisa has to learn to reach her target.

# Constraints
* 0 < n < 100
* 0 < length of sentence < 500
* The total amount of words across all sentences is lower than 1000
