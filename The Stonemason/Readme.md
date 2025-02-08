# Puzzle
**The Stonemason** https://www.codingame.com/training/medium/the-stonemason

# Goal
You are a Middle-Age stonemason and you have to shape stones with a special ruler.  
The ruler uses anthropomorphic lengths:   
* The (small) palm of the hand (its width)
* The full palm (from forefinger to little finger)
* The span (from thumb to little finger)
* The foot
* The cubit (from elbow to little finger)

They have the following feature:  
* A palm and a full palm are a span
* A full palm and a span are a foot
* A span and a foot are a cubit

For this puzzle, we will place the units on a line, from left to right, the biggest on the left, the smallest on the right. The span is the central unit, the full palm is on its right and the foot on its left.  
Two following units have the same added length than the one on their immediate left, including subdivisions of the palm or of the bigger units.  
A rectangular stone whose dimensions are a palm and a full palm has got the same shape than a rectangular stone whose dimensions are a full palm and a span. It’s just the same stone but bigger.  

For the purpose of this puzzle, we won’t use their real name but their position in the set:  
* The span in the centre, just call it C.
* The foot is one unit on the left of the span, call it 1L. The cubit is 2L.
* The full palm is one unit on the right of the span, it’s 1R and the palm is 2R.
* The unnamed units are 3L, 4R and so on.
* You only own one unit of each in your set. And you want the least amount of units used.

You are given a multiple of the span, for example three spans, and you must measure it, using the set of units, but you must not use two adjacent units, because the previous one can replace it. For example, if you have to use a span and a foot, replace them by a cubit.

# Input
* The multiple of span we are working on.

# Output
* set of units needed to measure the length
