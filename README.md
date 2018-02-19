# Football-SQL-Database-Queries
Assignment for Web class

For this assignment you will design an SQL database, populate your database given a dataset, and use it to gather statistics and answer questions about a dataset. The dataset will represent scoring events in one or more football seasons, and will be given to you as in the following form (one event per line):



FirstName LastName TeamName OpposingTeamName Date (passing|rushing|fieldgoal) (FirstName LastName)?


The trailing name syntax "(FirstName LastName)?" indicates that this information may or may not be in the line. It will be present only in the case of a passing touchdown and represents the quarterback who threw the ball. There will not be any actual parentheses characters surrounding the information or a trailing ?. Similarly, the syntax "(passing|rushing|fieldgoal)" is meant to indicate that one of these specific values will be present (there won't be any actual parentheses characters).



All names will single tokens with no special characters or spaces.



We will give you the data later in a few days, but you should go ahead and design and implement your database now. You can fill your database with entries by hand if you must, but you will be MUCH better off if you write a PHP program that can be given the dataset and creates/updates rows in your database as appropriate. In fact, this is much of the value of the assignment since it will force you to exercise the PHP mysqli library.

Notes:



    If a player was not involved in at least one score for a game he is considered to have not "played" in that game.



    For this dataset a player never changes teams so once you have seen a player associated with a particular team, you can assume that they will always be associated with that same team in any other scoring events.

    Assume field goals = 3 points, and rushing/passing TDs = 7 points.



Write the appropriate SQL command to answer the following questions:

1) How many touchdowns did Cam Newton score or pass for when playing against Atlanta?



2) How rushing touchdowns has Marshawn Lynch scored in October?



3) Which players scored more points in 2016 than in 2015?



4) Who won the game between Dallas and Washington on Thanksgiving Day 2016?



5) List all the games (date and opposing team) that Dallas won in 2016 in chronological order

 

What to turn in:

    Files containing the SQL commands that output the answers to the above questions (call them answer1.sql, answer2.sql, etc.)
    A description of your database schema (call it a3-schema.txt)



It is important that you follow these file-naming conventions, since this assignment will be partially graded with a grading script.


Like past assignments, provide these files in an a3 directory in your class webspace.
