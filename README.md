# TansyOJ
A minimilistic Online Jury written in PHP and Python. This project is a basic setup for all Online Juries. It is simple to install and configure. I have pen down the steps of installation in details. I hope that you find it useful. Don't forget to star the repository.

# Features
1. Supports two languages (from compilation to run) C++ and Java. Additional languages can be added similarly. 
2. Adding problems is simple. I have not included an Admin Panel. You can build your own if you wish.
3. Submissions are stored directly in database.
4. Leaderboard is auto-updated.
5. Simple and light-weighted. The whole source code is no more than 1 MB in size (including graphics).

# Installation

1. Install the compilers. For C++ install MinGW (Command 'g++' must work). For Java install Java8 (Command 'javac' & 'java' must work). Adding other compilers depends upon your choice.
2. Install Apache, PHP, Python3, MySQL, PhpMyAdmin. Check the documentation of these softwares for more information on installation.
3. Copy all the files to Server root (or whichever folder you would like to host the site on).
4. Change the permission of 'Problems' folder. Set it to 000.

    <code>sudo chmod -R 000 Problems/</code>
  
    This would make the Problems folder inaccessible from outer web.
5. Login to phpmyadmin and create new database. Import the SQL file 'judge.sql' into the database.
6. Open 'judge/dbconfig.php' and set the values of the database configuration fields (servername, username, password, databasename) accordingly.
7. Open 'judge/judge.py' and set the values of database configuration fields (servername, username, password, databasename) accordingly.
8. Create new user named 'oj'.

    <code>sudo adduser oj</code>
    
    This user will be used to run the program as.
9. Use pip to install pymysql. 'pymysql' is the only external library on which this software is dependent.

    <code>pip install pymysql</code>
    
               OR
               
    <code>pip3 install pymysql</code>        
               
    If pip is not present, you may install it for your corresponding OS.
10. Run the python script 'judge.py'. It MUST be run as root.

    <code>sudo python3 judge.py</code>
    
    This script will automatically judge the submissions. This script is what the judge is all about.
11. Open the page in your browser. Register for a new account. Then login and make a new submission. If the submission is judged, your installation was fine.
12. That's all :).

# Adding new problem

1. Login to PhpMyAdmin and add the new problem in the 'problems' table. Each problem has a unique CAPITALIZED code of maximum 10 alphabets called 'problemcode'. Set the 'users_solved' field to 0. Add short description, problem statement and sample I/O. You can use HTML syntax in these fields. Set the time limit in seconds and the level of difficulty (0 for Easy, 1 for Medium, 2 for Hard, 3 for Extreme). 
2. The I/O files over which the program will be checked is to be kept in 'Problems/' directory. Inside the directory, create a new folder named same as the problem code. Create a folder named 'input' and put your input files (numbered serially 1,2,3,4....) each having extension '.in' in the folder. Create another folder 'output' and put your corresponding output files (numbered serially 1,2,3,4....) each having extension '.out' in that folder. 
3. Done :). Submit and check.

# Additional info

1. The judge runs on port number 8080. If you need to change the port number, change the same in 'judge.py' and 'judge/index.php'. Just search for '8080' and replace it with your required port number.
2. The judge does strict comparison of expected and actual output. Even whitespaces may result in WA. You can modify the judge to ignore the whitespaces character.
3. The 'Leaderboard' and 'My Submissions' load only the top 100 records by default. The corresponding scripts can be modified to featch even more records.
4. You can send messages to individuals that would appear as popup. To send a new message, add the username and message to 'msg' table in the database. 
5. If you would like to run the judge.py in the background, then use nohup:
       
     <code>nohup sudo python3 judge.py &</code>
       
   Type in some other command and exit from the terminal.
6. You can add more languages yourself. The code is simple to read. If you have any doubts or queries, please ping me. :)
