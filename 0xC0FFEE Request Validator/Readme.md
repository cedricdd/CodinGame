# Puzzle
**0xC0FFEE Request Validator** https://www.codingame.com/contribute/view/1424762fbefe49c880720181ce675d20734cd6

# Goal
Crystal runs a specialty coffee station in a tech company where employees can send their order to the station via an internal API endpoint. Recently, she has been seeing more suspicious requests to the machines that do not seem to originate from the internal API endpoint. She suspects non-employees have hacked into the internal request system, and has tasked you to investigate.

Task
An order is a hexadecimal number with orderSize digits, where each digit corresponds to a drink ID drinkId in the coffee station. The internal API endpoint wraps the order into a data frame frame, another hexadecimal number, with the following format:
* First 8 digits - frame header, a fixed hexadecimal value DECAFBAD (0xDECAFBAD).
* Next 3 digits - frame size, a hexadecimal value equal to orderSize₁₀ (e.g. if orderSize = 10, frame size = 0x00A).
* Next orderSize digits - the actual order.
* Last 1 digit - checksum, derived such that the sum of all hexadecimal digit values in frame (including those in the header, size, and checksum) is divisible by 16.

A data frame is valid (coming from the internal API endpoint) only if it fulfils all formatting and criteria listed above. Fulfil orders of valid data frames and reject invalid ones. Time to determine which coffees to brew and which coffees to block!

Example  
frame = 0xDECAFBAD00744C23A5F  
Header = 0xDECAFBAD (valid)  
Size = 0x007; orderSize = 7  
Data order = 0x44C23A5 (7 drinks total, valid)  
Checksum = 0xF (0xD + 0xE + 0xC + ... + 0xA + 0x5 + 0xF is divisible by 16, valid)  
=> Coffee request is valid, fulfil the order.  
(note: the 0x- prefixes here are for easier understanding and not part of the actual input)

# Input
* Line 1: A single integer frameLength, the total length of a received data frame frame.
* Line 2: frameLength hexadecimal characters (0-9, A-F), the value of frame, without the 0x- prefix.

# Output
* If the data frame frame is invalid, output a single line: 403 Forbidden
* Else, for each unique drinkId that appears in order:
  * Count the number of drinks ordered (count) for that drink ID.
  * Output "count drinkId" on a separate line.
* Order the sequence of outputs in order of appearance of each drinkId in order.

# Constraints
* 1 ≤ frameLength < 1000
* For valid data frames, orderSize > 0
* Hexadecimal characters A-F will only be used in its uppercase form (i.e., no a-f characters)
* Order and frame are valid hexadecimal numbers (but may contain leading zeros)
