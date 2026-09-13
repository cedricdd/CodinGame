# Puzzle
**You have been Hacked** https://www.codingame.com/contribute/view/78658089fc5f6fedf11c055682408582f2eb

# Goal
Hackers carry out Advanced Persistent Threat cyber attacks against a number of companies. Each company has a firewall with a protection level p.

Cyber attack stages

Hackers execute 3 types of attack in the following order:
* Stage 1: Port scanning (ps)
* Stage 2: Brute force (bf)
* Stage 3: Malware installation (mi)

There may be multiple attack attempts against the same company in a single stage. The sum of their strengths is used to evaluate the stage. If a stage is successful, the attack proceeds to the next stage; otherwise, the attack is blocked and later stages are not evaluated.

Once the next stage begins, no further attempts of the previous stage occur.

The status of the cyber attack on a company is Hacked if all three stages succeed; otherwise it is Blocked.

Cyber attack attempts on different companies may be interleaved, and they should be evaluated separately.

Firewall

The firewall behaves according to its protection level as follows. The value for each stage in the table is the exclusive upper bound on the total attack strength that the firewall can block in that stage:
```
Firewall       Port         Brute        Malware
protection     scanning     force        installation
level (p)     (ps)         (bf)         (mi)
------------------------------------------------------
p ≥ 7          10000        ∞            ∞
5 ≤ p ≤ 6      0            5000         3000
p < 5          0            500          1000
```

For example:
* 10000 means that the attack is blocked if the total strength is strictly less than 10000.
* 0 means that the attack is always successful (not blocked).
* ∞ means that the attack is always blocked.

Your task is to determine the final status of the cyber attack for each company.

# Input
* Line 1: An integer n, the number of companies.
* Next n lines: A string in the format of name:p where:
  * name (string) is the company's name.
  * p (integer) is its firewall protection level.
* Next line: An integer a, the number of cyber attack attempts.
* Next a lines: A string in the format of name:type:s where:
  * name (string) is the attacked company's name.
  * type (string) is the attack stage (ps, bf, or mi).
  * s (integer) is the attack strength.

# Output
* n lines: name:status where:
  * name is the company's name.
  * status is the status of the cyber attack on the company (Hacked or Blocked).

The output order is the same as the order of companies in the company list.

# Constraints
* 1 ≤ n ≤ 10
* 1 ≤ length of name ≤ 30
* 1 ≤ p ≤ 10
* 1 ≤ a ≤ 100
* 1 ≤ s ≤ 20000
* All names in the company list are unique.
* There is always at least one attack of each type against every company, and the attacks for each company are always in the correct order.
