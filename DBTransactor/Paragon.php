<!-- File: Paragon.php
    Constants used for database connection.

    Doing credentials in this way allows us to encrypt this file 
    in order to protect database credentials in case of server hack or data leak.
    Password could be made more complicated and harder to guess instead of empty. 
    Disabling root login to mysql server and creating a harder to guess username for mysql is helpful.
-->

<?php

    /** Paragon Constants Class
    * Protected credentials used to authenticate to the database to be used throughout code.
    * DBTransactor classes inherit this class in order to establish database connection.
    *
    * Each DBTransactor initalizes a database connection.
    */
    class Paragon {
        private $DB_LOCATION = 'localhost';
        private $DB_USERNAME = 'root';
        private $DB_PW       = '';
        private $DB_NAME     = 'ParagonMLS';
        static  $conn;        


        // Returns a connection to the database
        public function getConn() {
            $conn = new mysqli($this->DB_LOCATION, $this->DB_USERNAME, $this->DB_PW, $this->DB_NAME);
            return $conn;
        }
    }
?>
