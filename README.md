# TPC-C Benchmark
Deployment can be found at http://tpcc.us-east-2.elasticbeanstalk.com/
# Overview
- This project was developed in Spring 2023 for Cloud Computing.
- The goal was to follow the TPC-C benchmark specification to measure the performance of an online transaction processing system (OLTP), specifically for a new order transaction.
- Developed with the WAMP stack locally via XAMPP, then deployed as a LAMP app with Amazon Elastic Beanstack and Relational Database Service.
- Used PHP to implement server side logic and dynamically generate HTML pages.
- dbedit.py is only used to generate text files with SQL statements for populating the database tables.
- db_configuraton.php needs to be modified to run on localhost, it is currently configured to use environment variables which are set on Elastic Beanstalk.
# Database Population
To populate the database, run the contents of these files as SQL scripts in the order shown:
- project.sql
- warehouse.sql
- district.txt
- customer.txt
- item.txt
- stock1.txt
- stock1-2.txt
- stock2.txt
- stock2-2.txt

## Languages/Technologies
HTML, CSS, PHP, MySQL, MySQLi, Apache, Python, Amazon Elastic Beanstalk, Amazon Relational Database Service
