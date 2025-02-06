# Puzzle
**Earth to Mars Date Converter** https://www.codingame.com/contribute/view/117660d2126a4ae5c2082cc51337cae9c9769c

# Goal
The goal of this task is to convert a given Earth date to its corresponding Martian date. The conversion takes into account the difference in day lengths between Earth and Mars.

The start date is the reference point in time where the Earth and Mars dates are assumed to be identical.

On Earth, a day lasts 24 hours, but on Mars, a day (called a "sol") lasts approximately 24 hours, 39 minutes, and 35.244 seconds. This means that a Martian day is longer than an Earth day . The program needs to take into account this time difference when converting dates.

The program will:  
1) Calculate the number of days elapsed between the start date and the Earth date.
2) Account for leap years on Earth when calculating the number of days.
3) Use a fixed time difference factor of 2375.244 seconds per day between Earth and Mars.
4) Convert the time difference into Mars days and calculate the equivalent Mars date based on the start date.

# Input
* line 1 Start date SDate (format: yyyy-MM-dd HH:mm:ss): A reference date for the calculation.
* line 2 Earth date EDate (format: yyyy-MM-dd HH:mm:ss): The Earth date that the user wants to convert to a Mars date.

# Output
* line 1 EqDate the equivalent date on Mars (format: yyyy-MM-dd HH:mm:ss),

# Constraints
* SDate is always earlier than EDate.
