# Real Estate Utility - CS 499 Team 1
Senior Project for UAH CS undergrad. 

## Installation

### Prerequisites
You will need to install the following software on your system for Linux. You must have a web server that can display webpages and execute PHP code.  

* Apache (2.0 or greater)
* PHP (7.0 or greater)
* MySQL (5.6 or greater) 

You will also need to set up an SMTP server on your machine so that PHP is allowed to send outgoing emails to real estate agents. Throughout the course of the project, we have set up an SMTP server using the program [sSMTP](https://wiki.debian.org/sSMTP) on our Debian (Kali Linux) server since sSMTP allowed us to use Gmail as our outward mailer. We used sSMTP throughout the project in order to avoid purchasing and configuring a domain for the Debian server. 


For MySQL, you must create a new database using the command ```CREATE DATABASE myDatabaseName;``` on the MySQL command line interpreter. 

On your terminal, you must import the database model located in ```Helpers/DatabaseModel/ParagonMLS_model.sql``` using the following command: ``` mysql -u myMySQLusername -p myDatabaseName < ParagonMLS_model.sql``` into your MySQL server.


### Installing
Once the prerequisites are satisfied and you have a webserver listening for HTTP requests, you are then ready to install the real estate utility. 

Download and place the entire program in the root of your webserver directory. You must configure Apache to read the ```index.php``` file that must be located at the root of the webserver.  

You must then place a configuration file named ```config.ini``` in the root of the webserver. You must have the information filled out on all of these fields in ```config.ini```, otherwise the software will not work as intended:

Example config.ini file:
```
[database]
username   = myMySQLusername
password   = mypassword
dbname     = myDatabaseName
dblocation = localhost
adminEmail  = "example@example.com"
websiteURL  = "1.2.3.4" or "http://mydomain.com/"
firstName  = "sys admin first name"
lastName   = "sys admin last name"

```

The ```username```, ```password```, ```dbname```, and ```dblocation``` variables are the user settings to allow the real estate utility to connect to MySQL database. The system administrator must keep this file secure. 

The ```adminEmail```, ```websiteURL```, ```firstName```, and ```lastName``` config variables are used for the real estate utility mail functions and must be configured otherwise mail functionality will not work as intended.

After placing the program in the root of the webserver and configuring the ```config.ini``` file, you have successfully installed the real estate utility. 

-------------
## For System Administrators
You will need to generate salted passwords for agents using PHP when creating an account for an agent. The password hashes in the database have a 255 character limit. You will be in charge of managing user accounts in MySQL. 
 
## Project Software
* [MySQL Workbench](http://dev.mysql.com/downloads/workbench/) - Database model.
* [Wamp64 Server 2.5](https://sourceforge.net/projects/wampserver/files/WampServer%202/Wampserver%202.5/) - For local hosting.
* [Eclipse IDE](https://eclipse.org/downloads/packages/eclipse-php-developers/neon2) - For PHP.
* [Test Mail Server Tool](http://www.toolheap.com/test-mail-server-tool/) - To simulate email server locally. 

## Team Members
* **Nick Diliberti**
* **T. Ryan Kline**
* **Cray Pella**
* **Jean Michael Almonte**

CS499 - Spring 2017. 
