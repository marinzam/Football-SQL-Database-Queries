We run the latest MySQL server that comes with the Red Hat 6
operating system. When you login to mysql the version will be
displayed.

The main department MySql server is named mydb.cs.unc.edu. Host
classroom.cs.unc.edu also runs MySql for course related work

The phpMyAdmin web interface can be reached at:

https://wwwx.cs.unc.edu/Courses/mysql/


Use your Computer Science username and password to get access the web
page when prompted. The phpMyAdmin web page is password protected because
it is a big hacker target.

Enter your mysql user name and password at the phpMyAdmin page to login to
phpMyAdmin. MySql maintains its own internal user and password database!
See below

The mysql web site is at:

http://www.mysql.com/

The MySql documentation is at:

http://dev.mysql.com/doc/index.html

Below are some commands to get you going. You can also use the PhpMyAdmin
interface described above.

You can use the mysql command line interface on any
department linux system. You can only access your
mysql database from the *.unc.edu domain.

To login using a mysql client command line client:

mysql -p [-u userid] -h hostname [db name]

# -p = prompt for password, required
# -u = optional user name, defaults to your login name
# -h = host to connect to even if on localhost, required
# [db name] use this db when logging in, optional

exmaples:

mysql -p -h mydb
mysql -p -h classroom

NOTE: You must always specify the -h host option and the -p option!
      the mysql client will default to using your login name. If
      you wish to use another login name use the -u option.

We only allow logins from machines in the unc.edu domain.

Your password is "CH@ngemenow99Please!USER" where USER is the username
of the account you requested, typically your Computer Science login name
in all lower case letters.

The database server name is "mydb.cs.unc.edu" unless you obtained your
mysql account information for host "classroom.cs.unc.edu" use. In this
case you instructor will give you the hostname to use.  Your database
name that you have full access to is USERdb, again USER is your username.

# use this to change your password
SET PASSWORD = PASSWORD('new_password');

# make this the current db
use userdb;;


# create tables
CREATE TABLE name 
(
first varchar(32),
last   varchar(32),
);

# list all tables in current db
show tables;

# show table schema:
describe table_name;

# print everything in table
select * from table_name;

# print columns from table:
select c1,c2... from table_name;
