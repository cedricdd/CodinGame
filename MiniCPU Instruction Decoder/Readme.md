# Puzzle
**MiniCPU Instruction Decoder** https://www.codingame.com/training/easy/minicpu-instruction-decoder

# Goal
A simple 8-bit CPU emulator must be debugged. The CPU has 4 registers (R0, R1, R2, R3) initialized to 0.

Instructions are encoded as hexadecimal bytes:
* 01 X V: MOV - Load value V into register RX
* 02 X Y: ADD - Add register RY to register RX
* 03 X Y: SUB - Subtract register RY from register RX
* 04 X Y: MUL - Multiply register RX by register RY
* 05 X: INC - Increment register RX by 1
* 06 X: DEC - Decrement register RX by 1
* FF: HLT - Halt execution

Where X and Y are register indices (0-3), and V is an immediate byte value.

All arithmetic wraps at 256 (8-bit unsigned). Overflow wraps to 0, underflow wraps to 255.

The first instruction is not guaranteed to be 01 (MOV). Programs may start with any instruction, including 05 (INC) or 06 (DEC).

The smallest valid program is just FF (HLT).

Execute the program and output the final register values.

# Input
* Line 1: A string of space-separated hexadecimal bytes program

# Output
* 4 lines: The decimal value of each register R0, R1, R2, R3, one value per line

# Constraints
* Program length ≤ 100 bytes
* For the opcodes 02, 03 and 04, X ≠ Y
* Program always ends with HLT (FF) as an opcode. Byte value FF may also appear as an immediate value V.
