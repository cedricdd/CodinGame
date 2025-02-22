# Puzzle
**Reverse upside down Digital broken clock** https://www.codingame.com/contribute/view/747936e0eb23b14836ae22ad28570293216a6

# Goal
Julian's kids played with their alarm clock, and now the embedded projector displays the time ...  
well ... upside down on the wall : reversed horizontally and vertically !  

More explicitly, on the their room's wall the digits are now in reversed order, and:  
- 0 is now readable as O or 0,
- 1 is now readable as i or 1,
- 2 is still displayed 2,
- 3 is now readable as E,
- 4 is now readable as h,
- 5 is now readable as S or 5,
- 6 is now readable as 9,
- 7 is now readable as L,
- 8 is still displayed 8,
- 9 is now readable as 6.

Given a readableText, output the realTime formatted as H:mm.

Be careful, some texts may now refer to invalid time!  
If the realTime is not valid, output instead one or more lines to explain what is wrong, using the following format:
- if one or more invalid chars => print Error : invalid invalid chars (-> no Test Cases yet .. coming soon😉)
- if hours is NOT valid => then print Error hours hours
- if minutes is NOT valid => then print Error minutes minutes

# Input
* Line 1 : the readableText (string) projected on the wall

# Output
* If realTime is valid => then print the realTime in 24 hours format H:mm
* If realTime is NOT valid => then output one or more lines to explain what is wrong.

# Constraints
* prefix and suffix can be any of combination of zero (0) to two (2) of each one of these characters : #, +, -, . or =.
* A space (char 0x20) always follows the optional prefix if present.
* A space (char 0x20) always precedes the optional suffix if present.
* If readableText contains only valid digits (which may or may not indicate valid time):
  - 0 ≤ hours ≤ 99
  - 0 ≤ minutes ≤ 99
