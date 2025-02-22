# Puzzle
**Remove insert statements** https://www.codingame.com/training/easy/remove-insert-statements

# Goal
Given a SQL file, you must:  
- remove the INSERT statements that are actually inserting data in the database
- keep the INSERT statements that are embedded in functions.
- All others statements must remains the same

SQL syntax to consider:  
- INSERT statement is a statement that starts with the INSERT keyword and ends with the semicolon ;. It can be written anywhere in the SQL file, it can be written on one or many lines. 
There is no constraint on where INSERT keyword appears first. It can start a new line or after spaces or it may have some indentation before the INSERT keyword
- comments begin with -- and comments must be kept in the script. Comments end at the EOL.
- the syntax used to denote the body of functions:
```
  BEGIN start of body
  END end of body
  BEGIN and END keywords are always at the start of a line.
```

Body is the main part of the function where SQL statements must be checked. If INSERT statements are written in this part, INSERT statements must be kept.  
- INSERT, BEGIN and END are keywords, keywords are case-insensitive

EXAMPLES:  
- Example of INSERT statement that must be removed:
```
  INSERT INTO ref_metric VALUES (767, 'make it clear', 'some description', 2, 'LOW');
```

=> VALUES are hardcoded values or string literals

- Example of INSERT statement that must be kept:
```
  CREATE FUNCTION my_function(pObj integer, pUser integer) 
  LANGUAGE plpgsql
  AS $$
  declare
  begin 
    INSERT INTO lk_table(nb_object, id_user, stat) 
    VALUES ( pObj, pUser);
  end;
```

=> VALUES are variables, INSERT is embedded in the body of a function. The body is defined by BEGIN and END keywords.

TIP:  
- You can copy/paste input file on some sql beautifier tools online to help you to identify relevant lines to remove.  
- SQL statements are real statements that can be executed in SQL tools.  

# Input
* Line 1: An integer n for the number of lines to read
* Next n lines: SQL statements to parse

# Output
* m lines: SQL statements cleaned up without INSERT statements that are doing data insertion in the database. comments must remain in the output. m is the number of lines that remain.
