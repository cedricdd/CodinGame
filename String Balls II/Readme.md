# Puzzle
**String Balls II** https://www.codingame.com/training/hard/string-balls-ii

# Goal
This puzzles builds on @Rafarafa's String Balls puzzle: https://www.codingame.com/training/medium/string-balls  

You've received a message from a galaxy far, far away. The inhabitants of that galaxy are looking to hire a contractor to count the points in several of their "string balls". The only problem is the radii and the string lengths can be much larger and they are worried the additional STRESS might make some algorithms infeasible. After all, time is money.

It is well understood that the points in some string balls just cannot be counted in a reasonable amount of time. As this is an extremely large contract, you have been asked to demonstrate your algorithmic prowess on a few “handpicked” radius/center combinations. Your task is to properly count the points in the string balls presented and make it to the next round in the selection process.

For your convenience, the rules from @Rafarafa's String Balls have been copied here:

Let's name the string abcdefghijklmnopqrstuvwxyz the alphabet, and let d be the distance between two elements in the alphabet defined by the absolute value of the difference of their indexes. For example:
```
d("b", "d") = d("d", "b") = 2
d("f", "f") = 0
d("a", "z") = 25
```

We can extend d to strings of equal length as follows: given two strings sa, sb of equal length len, d(sa, sb) is the sum of the pairwise d(sa[i], sb[i]) for all index values (i) from 0 to len-1. For example:
```
d("fb", "fd") = d("f", "f") + d("b", "d") = 0 + 2 = 2
d("ab", "ac") = d("ac", "ab") = 1
d("ac", "bb") = 2
```

We can now define a (closed) ball of center a given string and of (integer) radius. A point p (i.e. a string with letters in the alphabet and of same length as the center) is inside the ball if d(center, p) <= radius.

Find the number of points contained in the ball of center center and radius radius.

Because the number of points can be very large, print your answer modulo 10^9+7.

# Input
* Line 1: An integer radius, the radius of the ball.
* Line 2: A string center, the center of the ball.

# Output
* The number of points inside the ball of center center and radius radius.

# Constraints
* 0 < radius <= 100000
* 0 < length(center) <= 5000
* The string center contains only lowercase English letters.

Note: All string balls presented here have been handpicked and are guaranteed to be countable in a reasonable amount of time. ("Reasonable" is intentionally vague as it differs from language to language.)
