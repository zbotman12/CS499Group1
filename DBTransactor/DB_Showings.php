<!--
    File: DB_Showings.php
    Class to create Showings database transactions in ParagonMLS database.
    
    When implementing a DBTransactor in your files, the transactor will initiate a
    connection to the ParagonMLS database.
    
    Once you are done with the object, you do not have to call the destructor implicitly.
    PHP calls it at the end of the script.

-->

<?php

    class DB_Showings extends Paragon implements DBTransactor {
    
        // ***************************************************************************
        // Private fields
        private $TABLE_NAME;

        // ****************************************************************************
        // Constructor/Desctructor and Public Methods

        // Initializes a connection to the ParagonMLS database.
        // Given a table name. Creates a database connection to the table.
        public function __construct($TABLE_NAME) {
            $conn = new mysqli($DB_LOCATION, $DB_USERNAME, $DB_PW, $DB_NAME);
            $this->TABLE_NAME = $TABLE_NAME;
        }

        // Destroys object and closes database connection
        public function __destruct() {
            $conn->close();
        }

        // ***************************************************************************
        // DBTransactor Methods (To be implemented)
        public function insert($assoc_array)             : bool {return false;}
        public function update($set_array, $where_array) : bool {return false;}
        public function delete($key_array)               : bool {return false;}
        public function select($array)                   : array   {return array();}
        public function search($assoc_rray)              : array   {return array();}

        // ***************************************************************************
        // Private Methods

    }

?>
