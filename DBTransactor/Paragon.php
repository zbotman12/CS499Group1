<!-- File: Paragon.php
	Constants used for database connection.

	Doing credentials in this way allows us to encrypt this file in order to protect database credentials in case of server hack or data leak.
-->

<?php

	/** Paragon Constants Class
	* Protected credentials used to authenticate to the database to be used throughout code.
	* DBTransactor classes inherit this class in order to establish database connection.
	*
	* Each DBTransactor initalizes a database connection using $conn.
	*/
	class Paragon
	{
		protected const DB_LOCATION = 'localhost';
		protected const DB_USERNAME = 'root';
		protected const DB_PW       = '';
		protected const DB_NAME     = 'ParagonMLS';
		protected $conn; 								
	}
?>