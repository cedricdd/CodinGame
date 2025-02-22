# Puzzle
**Monday Tuesday Happy Days** https://www.codingame.com/training/easy/monday-tuesday-happy-days

# Goal
Given a start date with a known week day, your program must compute the day of the week at another date anytime in the same year.

# Input
* Line 1: whether or not the year is a leap year: 1 if it is, 0 otherwise. A leap year is a year when February has 29 days instead of 28. 
* The actual year itself is not given.
* Line 2: the initial date formatted as day of the week abbreviated month day in month, e.g. Monday Apr 23 for April 23rd.
* Line 3: the date you must give the day of the week for, formatted as abbreviated month day in month, e.g. Apr 24 for April 24th.

The abbreviated month names are Jan, Feb, Mar, Apr, May, Jun, Jul, Aug, Sep, Oct, Nov and Dec.

# Output
* Line 1: The day of the week for the second date: Monday, Tuesday, Wednesday, Thursday, Friday, Saturday or Sunday.

# Constraints
* Both dates are always within the same year.
* Both dates are valid—there is no Jan 45, Feb 29 on non-leap years, etc.
* The second date may be before the first one.
