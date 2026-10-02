# Puzzle
**Log Sanitizer** https://www.codingame.com/training/easy/log-sanitizer

# Goal
As a SecOps engineer, you must ensure that sensitive data never leaks into application logs.

For the purposes of this task, tokens are defined as being bounded by non-alphanumeric characters or the beginning or end of the line.

Inspect a stream of server log lines and sanitize all occurrences of the following two patterns, subject to the overlapping rule:

1. Credit card numbers
Exactly four consecutive tokens, each consisting of exactly 4 digits and joined by -, form a credit card number and should be replaced with [CARD_REDACTED].

2. API token
A token token (case-sensitive), immediately followed by = and another token (the value) consisting of one or more alphanumeric characters, forms an API token. Redact the value token only, replacing it with [TOKEN_REDACTED].

*Overlapping rule*  
Overlapping occurrences of a single pattern should not be considered to fit the pattern and should remain unchanged. For example, this applies to:
* Five or more consecutive tokens, each consisting of exactly 4 digits and joined by -.
* token= appears consecutively two or more times.

If token= is immediately followed by a token consisting of exactly 4 digits, treat that 4-digit token as the API-token value. This takes precedence over any credit-card matching that might otherwise involve that token. Continue processing the remaining text after redacting that token.

All other log characters must remain untouched.

# Input
* Line 1: An integer N for the number of log lines.
* Next N lines: A string line representing a raw log entry.

# Output
* N lines: The sanitized log entries.

# Constraints
* 1 ≤ N ≤ 10
* line contains between 1 and 100 printable ASCII characters.
