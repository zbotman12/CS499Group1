<?php /*
    File: DB_Showings.php
    Class to create Showings database transactions in ParagonMLS database.
    
    When implementing a DBTransactor in your files, the transactor will initiate a
    connection to the ParagonMLS database.
    
    Once you are done with the object, you do not have to call the destructor implicitly.
    PHP calls it at the end of the script.*/

    class DB_Showings extends Paragon implements DBTransactor {

        // ****************************************************************************
        // Constructor/Desctructor and Public Methods

        // Initializes a connection to the ParagonMLS database.
        // Given a table name. Creates a database connection to the table.
        public function __construct($TABLE_NAME) {
            $this->SHOWINGS_TABLE = $TABLE_NAME;
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
            } catch (BadMethodCallException $e) {
                throw $e;
            } 
            //var_dump($assoc_array);

            //Check for duplicate entries
            $dup_query  = "SELECT * FROM " . $this->SHOWINGS_TABLE . " WHERE ";
            $dup_query .= "start_time="          . $assoc_array['start_time']                 . " AND ";
            $dup_query .= "end_time="            . $assoc_array['end_time']                   . " AND ";
            $dup_query .= "Listings_MLS_number=" . "'"  . $assoc_array['Listings_MLS_number'] . "';";

            $dup_results = $this->connection->query($dup_query);
            
            //var_dump($dup_results);
            
            if ($dup_results) {
              if ($dup_results->num_rows == 1) {
                  throw new Exception("Showing already exists! Cannot create showing.");
              } 
            } else {
                throw new Exception($this->connection->error);
            }

            //Build showing query 
            $showing_q  = "INSERT INTO " . $this->SHOWINGS_TABLE . " (";
            $showing_q .= "Listings_MLS_number, start_time, end_time, is_house_vacant, customer_first_name, customer_last_name,";
            $showing_q .= "lockbox_code, showing_agent_name, showing_agent_company) VALUES (";
            $showing_q .= "'"  . $assoc_array['Listings_MLS_number']    . "'"  . ",";
            $showing_q .=        $assoc_array['start_time']                    . ",";
            $showing_q .=        $assoc_array['end_time']                      . ",";
            $showing_q .= "'"  . $assoc_array['is_house_vacant']        . "'"  . ",";
            $showing_q .= "\"" . $assoc_array['customer_first_name']    . "\"" . ",";
            $showing_q .= "\"" . $assoc_array['customer_last_name']     . "\"" . ",";
            $showing_q .= "\"" . $assoc_array['lockbox_code']           . "\"" . ",";
            $showing_q .= "\"" . $assoc_array['showing_agent_name']     . "\"" . ",";
            $showing_q .= "\"" . $assoc_array['showing_agent_company']  . "\"" . ");";
            var_dump($showing_q);
            
            
            //Insert showing into database
            $result = $this->connection->query($showing_q);

            //Check results. $results is either true or false
            if($result) {
                return true;
            } else {
                return false;
            }
        }
        
        public function insertPlus($str) {
            $result = $this->connection->query($str);
            if ($result) {
                return true;
            }
            else {
                throw new Exception ($this->connection->error);
                //return false;
            }

        }
        public function update($set_array, $where_array)  : bool {
            
            if(empty($set_array)) {
                throw new BadMethodCallException("\$set_array cannot be empty");
            }
            //Quarantine Zone
            try {
                $set_array = $this->q_zone($set_array);
            }
            catch (BadMethodCallException $e) {
                throw $e;
            }
            
            $ignore = ['submitted', 'Submit'];
            
            $columns     = $this->conditionBuilder($set_array, ",", $ignore);
            $condition   = $this->conditionBuilder($where_array, " AND ", $ignore);
            
            $query = "UPDATE " . $this->SHOWINGS_TABLE . " SET " . $columns . " WHERE " . $condition . ";";

            $results = $this->connection->query($query);

            if ($results) {
                return true;
            }
            else {
                return false;   
            }
        }

        public function updateShowing($query) {
          $results = $this->connection->query($query);
          
          if ($results) {
              return true;
          }
          else {
              return false;
          }
        }

        /* delete()           -> Deletes an entry from the database
            @param $key_array -> A single valued associative array where ["column_name"] = value_to_delete; 
                                delete() corresponds to following mysql syntax: "DELETE FROM 'table_name' WHERE 'condition1' AND 'condition1' AND ...;
                                Array must not be empty.
          @throws BadMethodCallException  -> Throws mysql query failure if database query failed
        */
        public function delete($key_array) : bool {
            if (empty($key_array)) {
                throw new BadMethodCallException("Nothing to delete.");
            }

            $condition = $this->conditionBuilder($key_array, " AND ", []);

            $query = "DELETE FROM " . $this->SHOWINGS_TABLE . " WHERE " . $condition . ";";

            $results = $this->connection->query($query);

            if ($results) {
                return true;
            }
            else {
                return false;
            }
        }

        /* select($array) -> Selects an entry and returns an associative array of values obtained.
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

            // Check if showing_id is in the query to be requested.
            if (in_array($this->index, $array) || $array == ['*']) {
                $isThere = true;
            }
            else {
                array_push($array, $this->index);
            }

            // Make string acceptable for SQL command
            $s = implode(",", $array);

            // If condition is empty. Just select all columns given.
            if (empty($cond)) {
              $query = "SELECT " . $s . " FROM " . $this->SHOWINGS_TABLE . ";"; 
              $results = $this->connection->query($query);

              $result_array = $this->resultToArray($results, $this->index);

            } else { //Else, select based on given conditions
              $c = $this->conditionBuilder($cond, " AND ", []);
              $query = "SELECT " . $s . " FROM " . $this->SHOWINGS_TABLE . " WHERE " . $c . ";";
              
              $results = $this->connection->query($query);

              $result_array = $this->resultToArray($results, $this->index);
            }

            //If agent_id was supplied as value in $array, just return the array.
            if($isThere){
                return $result_array;
            } 
            else { //Otherwise, filter the arrays that have the values.
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

        // ***************************************************************************
        // Private Methods and Fields 
        protected function q_zone($assoc_array){
            //Strip special tags
            $assoc_array = array_map(array($this, "sanitizer"), $assoc_array);

            // Check for empty fields. 
            // Do not have to check for empty fields since
            // fields can be null.
            
            /*if($this->hasEmptyFields($assoc_array)) {
                throw new BadMethodCallException ("Fields cannot be empty!");
            }*/
            return $assoc_array; 
        }
        private $index = "showing_id";
    }

?>
