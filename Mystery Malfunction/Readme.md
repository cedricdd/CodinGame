# Puzzle
**Mystery Malfunction** https://www.codingame.com/training/easy/mystery-malfunction

# Goal
The year is 2423 and you are trying to deliver a package to your friend in the Phobos Surface Colony. The problem is, you're on Earth, your teleporter's busted, and there's not enough time to go by a conventional spacecraft. Luckily you have the teleporter parts on hand, all you need to do is identify the issue. You read through the manual and find it has this to say:
* If the item REMAINS after activation, there is an issue with the DISASSEMBLER.
* If the item is broken apart but DOESNT APPEAR on the other side, there is an issue with the REASSEMBLER.
* If the item appears in the WRONG LOCATION, there is an issue with the LOCATOR.
* If all of the above, there is an issue with the MAIN COMPUTER.

There will always be at least one part broken.  
Each part will only generate its report once.  
Multiple parts can be broken, but never everything at the same time.  
The MAIN COMPUTER cannot be broken alongside anything else.  
The system automatically generates issue reports, but can also generate clutter reports. (reports that mean nothing)  
Other than the event of a MAIN COMPUTER failure all issues are independent and do not affect each other.  
Broken parts should be printed one per line in the order their issue report came in.  

# Input
* Line 1: An integer c for the number of reports.
* Next c lines: A string containing an issue report.

# Output
* n lines containing one or more of the broken parts (DISASSEMBLER, REASSEMBLER, LOCATOR, or MAIN COMPUTER), one part per line

# Constraints
* c > 0
