===============================================
   OPENCART MySQLi Database Connector
===============================================

Supported OpenCart Versions:
================
v1.4.4, v1.4.6, v1.4.7, v1.4.8, v1.4.8b, v1.4.9, v1.4.9.1, v1.4.9.2, v1.4.9.3


What does it do:
================
Enables MySQLi database connection handling

How to install it:
==================
1) Unzip and upload the contents to the root directory of your OpenCart installation, preserving directory structure
-- No file are overwritten
2) Update the DB_Driver in your config files:
		/config.php
		/admin/config.php
		
		Change:
			define('DB_DRIVER', 'mysql');
		To:
			define('DB_DRIVER', 'mysql_i');