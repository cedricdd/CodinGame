# Puzzle
**GDQ - Binary Coded Decimal Clock** https://www.codingame.com/training/easy/gdq---binary-coded-decimal-clock

# Goal
Games Done Quick is back in season and it's a great time to see how coding can go very wrong! Unfortunately, something is missing... The Binary clock!

Runners keep track of their time during the marathon, and it is displayed alongside a nice Binary Clock graphic. Let's recreate this awesome bit of design! The goal for this challenge is to take an input time and display a clock.

The clock will be a 6x4 grid displaying Binary Coded Decimal (BCD). Each digit from the input time will have its own column of 4 bits, allowing that column to show the numbers 0-9. We need to display 1 hour digit, 2 minute digits, 2 second digits, and 1 fractional digit.

Each digit will be displayed across all 4 lines. The bits will be displayed as 5 underscores (_____) for Off and 5 Number Signs (#####) for On. Each digit will also be enclosed in a Pipe (|).

These lines will be in the format:
```
|H|M|M|S|S|f|
```

You can find out more about BCD here: https://en.wikipedia.org/wiki/Binary-coded_decimal

About GDQ: https://gamesdonequick.com/

# Input
* Line 1: A string Input containing the current time to display. It is in the 24-hour time format of HH:MM:SS:f, where HH (hours), MM (minutes), SS (seconds) are shown as 2 digits and f (fractional) is shown as a single digit.

# Output
* 4 lines displaying the Input as a Binary Coded Decimal.

# Constraints
* 00 ≤ HH ≤ 09
