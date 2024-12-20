# Puzzle
**Master of Mayhem** https://www.codingame.com/training/easy/master-of-mayhem

# Goal
The Master of Mayhem has unleashed a crew of cyborgs on the city, and may be disguised as one - but which one?

From surveillance reports we have determined that each cyborg is wearing a hat and some neckwear, and has a companion and a catchphrase.

If Mayhem's hat is a FEDORA, then a cyborg wearing a BEANIE hat can't be the disguise.  
If you can eliminate all but one cyborg, that's Mayhem!

Mayhem has only been heard to utter one word from a catchphrase.

We might not know all the attributes of either Mayhem or the cyborgs.

Information about Mayhem and the cyborgs always follows one of these formats:
* Name's attribute is a string
* Name's attribute is an string
* Name's attribute is "string"

A string contains only letters and spaces.

# Input
* Line 1: An integer N for the number of cyborgs
* Next N lines: Cyborg names
* Next line: An integer M for the number of reports about Mayhem
* Next M lines: Reports about Mayhem in random order
* Next line: An integer C for the number of reports about the cyborgs
* Next C lines: Reports about the cyborgs in random order

# Output
* Line 1: The name of the only cyborg that could be Mayhem in disguise.
* If none of the listed cyborgs could be Mayhem, output MISSING
* If more than one cyborg could be Mayhem, output INDETERMINATE

# Constraints
* 1 <= N <= 10
* 0 <= M <= 4
* 0 <= C <= 40
