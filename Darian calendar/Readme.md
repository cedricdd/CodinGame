# Puzzle
**Darian calendar** https://www.codingame.com/contribute/view/977280faf97ddce2890da7c5eb92314dacfac

# Goal
The Darian calendar is a timekeeping system designed for planet Mars.  
Given a date and time on Earth, using the Gregorian calendar, output the corresponding date and time on Mars, using the Darian calendar.  

Some preliminary explanations:  
A "day" on Mars is called a sol, and lasts 24 hours, 39 minutes and 35.244147 seconds. Therefore it is equal to 88775.244147 seconds, whereas a day on Earth lasts 86400 seconds.

One year on Mars lasts about 668.5991 sols (≈ 686.98 days), therefore we need leap years, that will have 669 sols instead of 668.  
A year is a leap year when it is odd-numbered or divisible by 10.  
For a better approximation, a year which is divisible by 100 is not a leap year, except if it is divisible by 1000.  

Example:  
0, 1, 10, 15, 31, 50, 110, 1000 are leap years (669 sols).  
2, 6, 100, 200 are not leap years (668 sols).  

The Darian calendar has 24 months, named after the 12 constellations of the zodiac, and their Sanskrit equivalents:  
Sagittarius, Dhanus, Capricornus, Makara, Aquarius, Khumba, Pisces, Mina, Aries, Mesha, Taurus, Rishabha, Gemini, Mithuna, Cancer, Karka, Leo, Simha, Virgo, Kanya, Libra, Tula, Scorpius and Vrishika.  
Every month has 28 sols, except the last one of each quarter (Khumba, Rishabha, Simha and Vrishika), which have 27 sols.  
On leap years, Vrishika have one more sol, making it 28 sols long.  

The epoch of the Darian calendar was set on 1609 March 11, at 18:40:34. Therefore this Earth date/time is equivalent to 0 Sagittarius 1, 00:00:00.

You will be given a date of the Gregorian calendar and time of Earth, and will have to output the date and time of Mars at this moment. Output the time using Mars hours/minutes/seconds, which are a bit longer. One sol is divided into Mars hours, minutes and seconds the same way as an Earth day (24 hours of 60 minutes of 60 seconds), so one sol is 88775.244147 "actual seconds" long, but 86400 "Mars seconds" long (therefore you should not print any hour past 23:59:59).

You can find more detailed explanations on this page : https://en.wikipedia.org/wiki/Darian_calendar

--------  
Recap  
* 1 sol = 88775.244147 seconds
* 1 month = 28 sols, except 6th, 12th and 18th months, as well as 24th on non leap years : 27 sols
* 1 year (Darian) = 24 months = 668 or 669 sols
* Leap years : odd or multiples of 10, except multiples of 100. Multiples of 1000 are leap years (although multiples of 100).
* Epoch: 0 Sagittarius 1, 00:00:00 = 1609 March 11, 18:40:34

# Input
* One line, Earth time : year month day, hours:minutes:seconds (in the Gregorian calendar)
  
# Output
* One line, Mars time : year month day, hours:minutes:seconds (in the Darian calendar)
* Hours, minutes and seconds should be printed on 2 digits, and seconds are rounded down to the nearest integer.

# Constraints
* day : 1-31
* month : January, February, March, April, May, June, July, August, September, October, November, or December
* year : 1609-5000
* Date and time are valid, and past Darian epoch.
