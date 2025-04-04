# Puzzle
**ASCII Art QR code** https://www.codingame.com/training/hard/ascii-art-qr-code

# Goal 
Your task is to implement a simplified QR code reader for ASCII Art, decoding the information that is stored inside the data area.

**Structure**  
Data are encoded in binary format (0,1).  
- W, H: Width and Height in characters
- 3 Position detection markers located at the three corners (top left and right, bottom left), surrounded by no data zone (spaces of 1 character thick).  
Each position detection marker is indicated by a 5x3 rectangle made up of +, - and | with an @ character in the centre  
- 1 alignment marker near the bottom right corner (3 characters from right border, 1 character from bottom), without surrounding no data zone. 
The alignment marker is indicated by a 3x3 square made up of +, - and | with an X character in the centre.  
- Data area: all the remaining positions inside the rectangle W x H. A space is a 0, every ASCII which is not space character is a 1
- Mask pattern: a checkerboard pattern rectangle W x H of 0s and 1s.
The Mask pattern starts from the bit in the lower right corner set to 1 and does not stop at restricted areas. For example:
```
101010  
010101  
101010  
010101  
```

**Layout**  
The raw data (as bitstream) starts from the lower right corner, then it goes upwards (as happens in real QR codes).  
Every time the bitstream comes across the no data zone (or the borders), it moves left and changes direction (downwards, etc.).  
If it hits the alignment marker, the bitstream just crosses the marker straight. 
Below is an example of a 20x10 (WxH) QR code using the letters to simulate the sequence.  
The data starts from the lower right corner (uppercase A) and goes upwards.  
The case of the letters indicate the mask pattern (1 for uppercase, 0 for lowercase).  
The . character indicates the no data zone around the position detection markers. 
```
+---+.TsZyFeLk.+---+  
| @ |.uRaXgDmJ.| @ |  
+---+.VqBwHcNi.+---+  
......wPcViBoH......  
NmJiFeXoDuJaPgYxSrGf  
oLkHgDyNeTkZqFzWtQhE  
......ZmFsLyRe+-+pId  
+---+.aLgRmXsD|X|OjC  
| @ |.BkHqNwTc+-+nKb  
+---+.cJiPoVuBaVuMlA  
```

**Data Encoding**  
Raw data are encoded in binary where a space is a 0 and every other character is a 1.  
Every bit of the raw data is XORed with the mask pattern.  
```
data|pattern|  result
----+-------+----------
  0 |   0   | 0
  0 |   1   | 1 
  1 |   0   | 1
  1 |   1   | 0
```

The raw data are repeated until all the space available in QR code is filled.  
There is always room for a full copy of the raw data, subsequent copies may be truncated.  
Inside one copy of the raw data (bitstream) the structure is: 
BOM + Text + EOM  
BOM (8 bit)  
Text (sequence of 7 bit ASCII chars)  
EOM (7 bit)  
BOM: Begin of message, 8 bits.  
Value=0b1xxxxxxx means Text is not encrypted,  
Value=0b0xxxxxxx means that the Text is encrypted. The encryption KEY is the 7 bits (least significant bits) of BOM.  
EOM: End of message. Value=0b0000000 7 bits.  

**Encryption algorithm**  
Only when the first bit of the BOM is 0, the Text is encrypted.  
The KEY is XORed with all the bits of the remaining data (Text+EOM).  

References: https://en.wikipedia.org/wiki/QR_code  

# Input
* Line 1: integer W for the width of the QR code
* Line 2: integer H for the height of the QR code
* Next H lines: The ASCII QR code.

# Output
* The message encoded in the QR code (only the first copy).

# Constraints
* 12 ≤ W ≤ 100
* 8 ≤ H ≤ 100
  
The output message consists of ASCII characters only.
