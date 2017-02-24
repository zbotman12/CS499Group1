<!--
    File: DB_Listings.php
    Class to create Listings database transactions in ParagonMLS database.
    
    When implementing a DBTransactor in your files, the transactor will initiate a
    connection to the ParagonMLS database.
    
    Once you are done with the object, you do not have to call the destructor implicitly.
    PHP calls it at the end of the script.

-->

<?php

    class DB_Listings extends Paragon implements DBTransactor {

        // ****************************************************************************
        // Constructor/Desctructor and Public Methods

        // Initializes a connection to the ParagonMLS database.
        // Given a table name. Creates a database connection to the table.
        public function __construct($TABLE_NAME) {
            $this->LISTINGS_TABLE = $TABLE_NAME;
            $this->connection = $this->getConn();
            
            //Check for connection errors
            if ($this->connection->connect_error) {
                throw new Exception("Connection failed: " . $this->connection->connect_error);
            } 
        }

        // Destroys object and closes database connection
        public function __destruct() {
            $this->connection->close();
        }

        // ***************************************************************************
        // DBTransactor Methods (To be implemented)
        public function insert($assoc_array)             : bool {return false;}
        public function update($set_array, $where_array) : bool {return false;}
        public function delete($key_array)               : bool {return false;}
        public function select($array)                   {return array();}    
        public function search($assoc_rray)              {return array();}

        // ***************************************************************************
        // Private Methods and Fields
        protected function q_zone($assoc_array){
            return true;
        }
    }
?>
