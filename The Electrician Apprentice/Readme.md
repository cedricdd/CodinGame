# Puzzle
**The Electrician Apprentice** https://www.codingame.com/training/easy/the-electrician-apprentice

# Goal
After working with your apprentice Tom on a very bizarre electrical installation, you are about to turn on the power to carry out the final checks.   
As a professional, you labelled all switches beforehand and made sure they were off before you disconnected the power supply.  

However during the intervention, Tom flipped the switches all over the place! Fortunately, you had asked him to take notes, so you should be able to find out which equipment will trigger when the power supply is turned back on.

Switches can be mounted in series or in parallel. For a circuit to be on, all switches in series must be on and at least one switch for each parallel derivation must be on.

Wiring description is a space-delimited sequence of:  
* the - character followed by the identifiers of the switches mounted in series
* the = character followed by the identifiers of the switches mounted in parallel
Each SWITCH has a unique label.

Eg. for the following circuit:
```
                      +-[A1]-+        +-[A4]--[RADIO]---+
                      |      |        |                 |
                      |      +--[A3]--+----------[TV]---+
                   +--+      |        |                 |
                   |  |      |        +-----[CONSOLE]---+
                   |  |      |                          |
                   |  +-[A2]-+                          |
                   |                                    |
                   +------------[POWER SUPPLY]----------+
                   |                                    |
                   +--[B1]--[B2]-------------[LIGHTS]---+
```

The wiring description is:
```
    TV = A1 A2 - A3
    RADIO = A1 A2 - A3 A4
    CONSOLE = A1 A2 - A3
    LIGHTS - B1 B2
```

# Input
* First line: the number of circuits C
* Next C lines: name of the EQUIPMENT and wiring description
* Next line: the number of Tom's actions A
* Next A lines: the SWITCH that Tom toggled

# Output
* C lines, one for each equipment in the same order.
* Each line should read EQUIPMENT is ON or EQUIPMENT is OFF

# Constraints
* 1 ≤ C ≤ 25
* 0 ≤ A ≤ 25
* Length of SWITCH ≤ 20
* Length of EQUIPMENT ≤ 40
* Max input line length = 1024
