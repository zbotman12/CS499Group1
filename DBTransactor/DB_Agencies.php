<!--
    File: DB_Agencies.php
    Class to create Agencies database transactions in ParagonMLS database.
    
    When implementing a DBTransactor in your files, the transactor will initiate a
    connection to the ParagonMLS database.
    
    Once you are done with the object, you do not have to call the destructor implicitly.
    PHP calls it at the end of the script.

-->

<?php

    class DB_Agencies extends Paragon implements DBTransactor {

        // ****************************************************************************
        // Constructor/Destructor and Public Methods

        // Initializes a connection to the ParagonMLS database.
        // Given a table name. Creates a database connection to the table.
        public function __construct($TABLE_NAME) {
            $this->AGENCIES_TABLE = $TABLE_NAME;
            $this->connection = $this->getConn();

            //Check for connection errors
            if ($this->connection->connect_error) {
                throw new Exception("Connection failed: " . $this->connection->connect_error);
            } 
        }

        // Destroys object and closes database connection
        public function __destruct() {
            $connection->close();
        }

        // ***************************************************************************
        // DBTransactor Methods (To be implemented)
        public function insert($assoc_array)             : bool  {return false;}
        public function update($set_array, $where_array) : bool  {return false;}
        public function delete($key_array)               : bool  {return false;}
        
        /* select($array) -> Selects an entry and returns a SQL object of
        *                    results obtained. 
        *  @param $array -> Regular list. Just give a list of column names to select.
        *  @param $cond  -> A map of conditions to to select based on.
        *                   Returns mysqli_result object
        */
        public function select($array, $cond) {
            if (empty($array)) {
                throw new Exception ("Nothing to select");
            }
            
            $s = implode(",", $array);
            
            // If condition is empty. Just select all columns given.
            if (empty($cond)) {
              $query = "SELECT " . $s . " FROM " . $this->AGENCIES_TABLE . ";"; 
              $results = $this->connection->query($query);

              return $results;
            }{ //Else, select based on given conditions
              $c = $this->conditionBuilder($cond, " AND ", []);
              $query = "SELECT " . $s . " FROM " . $this->AGENCIES_TABLE . " WHERE " . $c . ";";
              
              $results = $this->connection->query($query);
              return $results;
            }
        }

        public function search($assoc_rray)                {return array();}


        // ***************************************************************************
        // Private Methods and Fields
        protected function q_zone($assoc_array){
            return true;
        }
    }

?>
