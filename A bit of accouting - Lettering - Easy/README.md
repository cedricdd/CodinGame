# Puzzle
**A bit of accouting - Lettering** https://www.codingame.com/training/easy/a-bit-of-accounting---lettering

# Goal
As a developer in an accounting company, you are tasked with developing a program that performs the lettering of a payment entry with one or more invoices.

Lettering is like matching your payment entries with your bills. It’s a way to keep track of which payments have cleared for which invoices, kind of like when you check off items on a shopping list.

You will be giving a list of invoices and a list of payment entries on a bank statement. You must match each entry with one or more invoices.  
Each amount can only be used in one match.  
Matches are output in the same order of the payment entries. Each match is labelled with a letter, starting with A, then B and so on. In case a payment entry is matched to multiple invoices, the invoices are output in the given order.

**Example :**  
You got the list of invoice amounts : [30, 42, 27] and the list of payment entry amounts : [27, 30, 42].  
By associating a letter to each payment entry => A 27 / B 30 / C 42 you have to match one or more invoices to each.  
That gives:  
A 27 - 27  
B 30 - 30  
C 42 - 42  

# Input
* Line 1: An integer N representing the number of invoices
* Line 2: An integer M representing the number of payment entries
* Next N lines: An integer invoice representing the amount of an invoice
* Next M lines: An integer paymentEntry representing the amount of a payment entry

# Output
* K lines: A B - C : One match per line where A is the letter of the lettering, B the amount of payment entry and C the amounts of invoices. Payment entry amount and invoice amounts are separated by a dash -.

Invoice amounts are separated by a space.

# Constraints
* There are no cases where a match can only be made between multiple payment entries with one or multiple invoices, e.g.

A 2 4 - 6  
B 2 4 - 1 5  

* 1 ≤ K ≤ 26

All cases have a unique solution.
