# Puzzle
**Escape the madness** https://www.codingame.com/training/easy/escape-the-madness

# Goal
You are prerendering an HTML string from C99 code. You have already done the extraction part, what is left to do is to simulate the escape sequences of every step until you obtain the final document.

The steps to do so are the following:

Step 1. Process C-style trigraphs, i.e. three-character sequences starting with ??, using the following table:  
* ??=: #
* ??/: \
* ??': ^
* ??(: [
* ??): ]
* ??!: |
* ??-: ~

Step 2. Process escape sequences starting with \. The possible formats for such escape sequences are the following:  
* \xhh: Produce a character represented using its Unicode code point on two hexadecimal characters (e.g. \x68 produces h).
* \uhhhh: Produce a character represented using its Unicode code point on four hexadecimal digits (e.g. \u0068 produces h).
* \Uhhhhhhhh: Produce a character represented using its Unicode code point on eight hexadecimal digits (e.g. \U00000068 produces h).
* \C: Produce a literal character (e.g. \\\"\a produces \"a).

Note: Hexadecimal characters can be provided uppercase or lowercase, and all codes, even using \U, will be contained within the ASCII range, i.e. between 1 and 127 included.

Step 3. Process some HTML entities, using the following formats:  
* &entity_name;: Produce the entity for which the name is entity_name.
* &#nn;, &#nnn;, etc: Produce the entity using its Unicode code point on a variable number of decimal digits (e.g. &#43; for +).

Only the following entity names should be supported:  
* &amp;: Produce &.
* &lt;: Produce <.
* &gt;: Produce >.
* &bsol;: Produce \.

If an entity name is not found, the HTML entity code should be rendered literally, i.e. &unknownsequence; should be returned as is.

Note: All codes represented using &#nn;, will be contained within the ASCII range, i.e. between 1 and 127 included.

# Input
* First line: text to process.

# Output
* First line: Processed text.

# Constraints
* 0 < length(text) < 500
