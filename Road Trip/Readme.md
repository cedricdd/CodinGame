# Puzzle
**Road Trip** https://www.codingame.com/training/medium/road-trip

# Goal
You are tired of your daily routine as a developer, and thus decide to take some vacation and go on a road trip!

You consider inviting N friends to come along. Your travel plan has a base cost of C, independent of the number of travelers, and an additional cost of P per person.  
Each of your friends has a limited budget. Your friends have their pride: they won't accept money from others, hence every traveler - including yourself - has to pay the same price (keep in mind that this amount might not be an integer).   
A friend that cannot afford the trip will decline your invitation.  
Since you have developed countless Java applications, you are very rich and will always be able to afford the vacation.

Each friend brings you a certain amount of joy by coming along on the trip.  
Among your friends, there are some people that you don't really like: they bring you negative joy. Being a pragmatic person, you still consider inviting them to lower the price per person, and allow your real friends to come.

Your happiness is the sum of the joy brought to you by every friend that comes along on the trip.  
Find the maximum happiness that you can get if you invite the right friends.

# Input
* Line 1: three integers N, C and P.
* Next N lines: two integers, the budget and joy of each friend.

# Output
* Line 1: the maximum happiness that you can get from this trip.

# Constraints
* 1 ≤ N ≤ 900
* 0 ≤ P ≤ 1000
* 0 ≤ C ≤ 10^5
* 0 ≤ budget ≤ 10^5
* -10^5 ≤ joy ≤ 10^5
