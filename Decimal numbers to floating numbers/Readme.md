# Puzzle
**Decimal numbers to floating numbers** https://www.codingame.com/training/medium/decimal-numbers-to-floating-numbers

# Goal
You may wonder how a computer is storing decimal numbers ? Not so trivial, let's have a look !

Decimal numbers are managed as floating numbers on computers, which is a way to approximate as best as possible the decimal values.   
The most commonly used standard for floating numbers is the IEEE 754 standard (used in many programming languages such as C, C++, Python etc...)  

In this puzzle, you will implement the algorithm to encode a decimal number from its literal format using the IEEE 754 (Single Precision 32 bits).

So, how does it work ? We need first to convert the decimal number from its base 10 (denoted b10) to base 2 (denoted b2). Then, we will encode the result using the IEEE 754 standard.

Convert a decimal number from base 10 to base 2

For a decimal number there are two parts, the whole part and the fractional part.

For the whole part, we simply convert it to a binary number.  
For the fractional part:  
* Step 1: we multiply the fractional part by 2
* Step 2: if the result = 0, the conversion to base 2 is done, go to Step 3
    * If result < 1, we store 0 as bit value for this round. We use the result as new value for fractional part and we restart at Step 1
    * If result ≥ 1, we store 1 as bit value for this round, we substract 1 from result, and we use this value for fractional part and we restart at Step 1
* Step 3: we list all bits we stored and we have our result

Example: 15.5: the whole part = 15, the fractional part = .5 (if we include the decimal point).

Whole part: 15  
(b10) 15 => (b2) 1111

Fractional part: 0.5  
0.5 * 2 = 1, we get 1, substract 1 and get 0 (1-1)  
0 * 2 = 0 we are done  

Result: (b10) 15.5 = (b2) 1111.1

In the same way: (b10) 0.125 = (b2) 0.001

Unfortunately, not all base 10 numbers have a perfect match with base 2 numbers when we talk about fractional parts... To illustrate it, let's convert a very simple number: 1.1

whole part: 1  
fractional part: 1  
```
0.1 x 2 = 0.2 -> 0
0.2 x 2 = 0.4 -> 0   <------+ We are looping with the same result
0.4 x 2 = 0.8 -> 0          |
0.8 x 2 = 1.6 -> 1          |
0.6 x 2 = 1.2 -> 1          |
0.2 x 2 = 0.4 -> 0    ------+
```

Here, there is no end and the conversion can only be an approximation. So, we need to stop when we reached the maximum length of the bits which can be stored. This maximum length is described in IEEE 754.

Encoding a decimal number (b2) with IEEE 754

We are going to encode only using the single precision method which is using 32 bits, this is the classical 'float' in programming languages.   
IEEE 754 introduces other precisions like 64 bits or 128 bits. The principle is exactly the same, so we will only do the 32 bits version.

For 32 bits, the general format is the following:
```
[ s = 1 bit for the sign ] [ e = 8 bits for the biased exponent ] [ m = 23 bits for the mantissa ]
```
To perform the encoding, we need to adapt the number to match the following format: (1.xxxxx) * 2^exp

We then reformat our previous results:  
(b10) 15.5 = (b2) 1111.1 = (b2) 1.1111 * 2^3  
(b10) 0.125 = (b2) 0.001 = (b2) 1 * 2^-3  

IEEE 754 rules:

s sign rule  
s=0 for positive, s=1 for negative numbers.

e biased exponent rule  
e = 127+exp (this is only true for denormalized numbers which is the generic approach we use in this puzzle, check the IEEE 754 reference for more info)  
e is then converted to binary format on 8 bits.

m mantissa rule  
We simply take all bits after the decimal point with max 23 bits:  
- If less than 23 bits we fill the remaining ending bits with 0
- If more than 23 bits, we truncate to 23 bits and we round the binary number if needed.

Then:  
(b10) 15.5 = (b2) 1111.1 = (b2) 1.1111x2^3  
s = 0, e = 127 + 3 (b10) = (b2) 10000010  
m = 11110000000000000000000  

(b10) -0.125 = (b2) 0.001 = (b2) 1x2^-3  
s = 1, e = 127 - 3 (b10) = (b2) 01111100  
m = 00000000000000000000000  

Let's now look at number with more than 23 bits for the mantissa, such as (b10) 1.1
```
(b10) 1.1 = (b2) 1.0001100110011001100110011...x2^0
                                         ^
```
We need to truncate at 23 bits

If next bit (24th) is 1, we need to round the number.  
The rule is simple:  
- if the bit in the previous position equals 0, we put it to 1 and this is finished.
- if the bit in the previous position equals 1, we replace it by 0 and we continue to round by moving 1 position before.

Once, rounded we have (b10) 1.1 = (b2) 1.00011001100110011001101

Special cases  
0 is encoded as a normalized number: s = 0 / e = 00000000 / m = 00000000000000000000000 = 0x00000000  
Invalid numbers are called NaN (Not a Number): s = 0 / e = 11111111 / m = 11111111111111111111111 = NaN  

External reference  
https://en.wikipedia.org/wiki/Single-precision_floating-point_format

# Input
* A string N which may or may not be a valid decimal number. It may have a prefix of + or - to indicate its sign, and it may be expressed in scientific notation (such as 5.63e15, 3.14e+5).

# Output
* Line 1: the formatted result of the conversion [s][e][m]
* Line 2: the hexadecimal value of the converted number (as we could see it in computer memory dump)

# Constraints
* N is maximum 20 characters
