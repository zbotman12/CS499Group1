<?php
    /*
    File: DB_Agencies.php
    Class to create Agencies database transactions in ParagonMLS database.
    
    When implementing a DBTransactor in your files, the transactor will initiate a
    connection to the ParagonMLS database.
    
    Once you are done with the object, you do not have to call the destructor implicitly.
    PHP calls it at the end of the script. */

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
            $this->connection->close();
        }

        // ***************************************************************************
        // DBTransactor Methods (needs testing)
        
        public function insert($assoc_array) : bool {
            
            //Quarantine Zone
            try {
                $assoc_array = $this->q_zone($assoc_array);
            }
            catch (BadMethodCallException $e) {
                throw $e;
            }

            //Check for duplicate entries
            $dup_query = "SELECT * FROM " . $this->AGENCIES_TABLE . " WHERE company_name=" . "\"" . $assoc_array['company_name'] . "\";";    
            $dup_results = $this->connection->query($dup_query);

            if ($dup_results) {
              if ($dup_results->num_rows == 1) {
                  throw new Exception("Agency already exists! Cannot create agency.");
              } 
            } else {
                throw new Exception($this->connection->error);
            }

            //Build agency query 
            $agency_q = "INSERT INTO " . $this->AGENCIES_TABLE   . " VALUES (NULL,";
            $agency_q .= "\"" . $assoc_array['company_name']         . "\"" . ",";
            $agency_q .= "\"" . $assoc_array['agency_phone_number']  . "\"" . ",";
            $agency_q .= "\"" . $assoc_array['city']                 . "\"" . ",";
            $agency_q .= "\"" . $assoc_array['state']                . "\"" . ",";
            $agency_q .= "\"" . $assoc_array['zip']                  . "\"" . ",";
            $agency_q .= "\"" . $assoc_array['address']              . "\"" . ");";
            
            //Insert agency into database
            $result = $this->connection->query($agency_q);

            //Check results. $results is either true or false
            if($results) {
                return true;
            } else {
                return false;
            }
        }
        
        /** update() -> Updates a table entry in database
        *               update() corresponds to following mysql syntax: 
        *               "UPDATE 'table_name' SET column_1 = [value1], column_2 = [value2], ... WHERE 'condition' ""
        *
        *   @param $set_array, $where_array
        *            -> $set_array is an associative array where you contain values to insert. i.e ["column_name"]    = "new value";
        *            -> $where_array is a single valued array where "["column_name"] = condition_value;" This cannot be empty.
        */
        public function update($set_array, $where_array) : bool {
            
            if(empty($set_array)) {
                throw new BadMethodCallException("\$set_array cannot be empty");
            }
            
            //Quarantine Zone
            try {
                $assoc_array = $this->q_zone($assoc_array);
            }
            catch (BadMethodCallException $e) {
                throw $e;
            }

            $ignore = ['submitted', 'Submit'];
            
            $columns     = $this->conditionBuilder($set_array, ",", $ignore);
            $condition   = $this->conditionBuilder($where_array, " AND ", $ignore);
            
            $query = "UPDATE " . $this->AGENCIES_TABLE . " SET " . $columns . " WHERE " . $condition . ";";

            $results = $this->connection->query($query);

            if ($results) {
                return true;
            }
            else {
                return false;   
            }
        }
        
        /*  delete()           -> Deletes an entry from the database
            @param $key_array -> A single valued associative array where ["column_name"] = value_to_delete; 
                                delete() corresponds to following mysql syntax: "DELETE FROM 'table_name' WHERE 'condition1' AND 'condition1' AND ...;
                                Array must not be empty.
          @throws BadMethodCallException  -> Throws mysql query failure if database query failed
        */
        public function delete($key_array) : bool {
            
            if (empty($key_array)) {
                throw new BadMethodCallException ("Nothing to delete.");
            }

            $condition = $this->conditionBuilder($key_array, " AND ", []);

            $query = "DELETE FROM " . $this->AGENCIES_TABLE . " WHERE " . $condition . ";";
            $results = $this->connection->query($query);
            
            if ($results) {
                return true;
            }
            else {
                return false;
            }
        }
        
        /* select($array) -> select($array) -> Selects an entry and returns an associative array of values obtained.
        *  @param $array -> Regular list. Just give a list of column names to select.
        *  @param $cond  -> A map of conditions to to select based on.
        */
        public function select($array, $cond) {
            $isThere = false;
            $result_array = Array();

            // Check if $array is empty.
            if (empty($array)) {
                throw new Exception ("Nothing to select");
            }

            // Check if agency_id is in the query to be requested.
            if (in_array($this->index, $array) || $array == ['*']){
                $isThere = true;
            }
            else {
                array_push($array, $this->index);
            }

            $s = implode(",", $array);

            // If condition is empty. Just select all columns given.
            if (empty($cond)) {
              $query = "SELECT " . $s . " FROM " . $this->AGENCIES_TABLE . ";"; 
              $results = $this->connection->query($query);

              $result_array = $this->resultToArray($results, $this->index);

            } else { //Else, select based on given conditions
              $c = $this->conditionBuilder($cond, " AND ", []);
              $query = "SELECT " . $s . " FROM " . $this->AGENCIES_TABLE . " WHERE " . $c . ";";
              
              $results = $this->connection->query($query);

			  //If results is false, return empty array.
			  if ($results == false) {
				return array();
			  }
			  
              $result_array = $this->resultToArray($results, $this->index);
            }

            //If agency_id was supplied as value in $array, just return the array.
            if($isThere){
                return $result_array;
            } 
            else { //Otherwise, filter the arrays that have the values for $index.
                $noID = array();
                foreach ($result_array as $agid => $value) {
                    foreach ($value as $k => $v) {
                        if ($k == $this->index) {
                            unset($result_array[$agid][$k]);
                        }
                    }
                }
                return $result_array;
            }
        }

        //public function search($assoc_rray) {return array();}

        // ***************************************************************************
        // Private Methods and Fields
        protected function q_zone($assoc_array){
            
            //Strip special tags
            $assoc_array = array_map(array($this, "sanitizer"), $assoc_array);

            // Check for empty fields. 
            if($this->hasEmptyFields($assoc_array)) {
                throw new BadMethodCallException ("Fields cannot be empty!");
            }

            return $assoc_array; 
        }

        // Index query control
        private $index = "agency_id";
    }

?>
