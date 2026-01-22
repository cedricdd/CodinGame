# Puzzle
**MiniCPU Instruction Decoder** https://www.codingame.com/contribute/view/141750007ce3df340495b02b17582f4f9b6b66

# Goal
A simple 8-bit CPU emulator must be debugged. The CPU has 4 registers (R0, R1, R2, R3) initialized to 0.

Instructions are encoded as hexadecimal bytes:
* 0x01 XX YY: MOV - Load value YY into register RX
* 0x02 XX YY: ADD - Add register RY to register RX
* 0x03 XX YY: SUB - Subtract register RY from register RX
* 0x04 XX YY: MUL - Multiply register RX by register RY
* 0x05 XX: INC - Increment register RX by 1
* 0x06 XX: DEC - Decrement register RX by 1
* 0xFF: HLT - Halt execution

All values wrap at 256 (8-bit unsigned arithmetic).

Execute the program and output final register values.

# Input
* Line 1: A string of space-separated hexadecimal bytes program

# Output
* 4 lines: The decimal value of each register R0, R1, R2, R3

# Constraints
* Program length ≤ 100 bytes
* Register index: 0-3
* Program always ends with HLT (0xFF
