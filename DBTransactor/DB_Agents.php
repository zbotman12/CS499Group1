<?php
/*
 File: DB_Agents.php
 Class to create Agent database transactions in ParagonMLS database.
 When implementing a DBTransactor in your files, the transactor will initiate a
 connection to the ParagonMLS database.
 Once you are done with the object, you do not have to call the destructor implicitly.
 PHP calls it at the end of the script. */
class DB_Agents extends Paragon implements DBTransactor {
	// ****************************************************************************
	// Constructor/Destructor and Public Methods
	// Initializes a connection to the ParagonMLS database.
	// Given a table name. Creates a database connection to the table.
	public function __construct($TABLE_NAME) {
		$this->AGENTS_TABLE = $TABLE_NAME;
		$this->connection = $this->getConn();
		$this->AGENCIES_TABLE = 'Agencies';
		//Check for connection errors
		if ($this->connection->connect_error) {
			throw new Exception("Connection failed: " . $this->connection->connect_error);
		}
	}
	// Destroys object and closes database connection
	public function __destruct() {
		//echo "Closing connection! Goodbye! <br/>";
		$this->connection->close();
	}
	// ***************************************************************************
	// DBTransactor Methods (needs testing)
	/** insert()
	*  DB_Agents also creates an agency if agency supplied doesn't exist as agent depends on agency existence.
	*  @throws Exception, BadMethodCallException
	*/
	public function insert($assoc_array) : bool {

		//Quarantine Zone
		try {
			$assoc_array = $this->q_zone($assoc_array);
		}
		catch (BadMethodCallException $e) {
			throw $e;
		}
		//Check if passwords match
		if (strcmp($assoc_array['password'], $assoc_array['confirm_pass']) != 0) {
			throw new BadMethodCallException ("Could not create agent. Passwords do not match!");
		}

		// SALTS
		$ops = ['cost' => 10];
		$v = password_hash($assoc_array['password'], PASSWORD_DEFAULT, $ops);
		$assoc_array['password'] = $v;
		unset($v);

		//Build query to check existence of Agency
		$query  = "SELECT * FROM " . $this->AGENCIES_TABLE . " ";
		$query .= "WHERE company_name = \"" . $assoc_array['company_name'] . "\" ";
		//Query the database
		$agency_results = $this->connection->query($query);
		$agency_exists = false;
		//Check if agency exists. TODO: Remove echo statements. Throw exceptions.
		if ($agency_results) {
			if ($agency_results->num_rows == 1) {
				//echo "Agency exists <br/>";
				$agency_exists = true;
			} else {
				//echo "Agency doesn't exist<br/>";
				$agency_exists = false;
			}
		} else { // Something happened. Could not create agent.
			throw new Exception($this->connection->error);
		}
		//TODO: Once DB_Agencies is implemented. Just initialize object of that class here.
		if ($agency_exists) { //Agency exists. Get its agency ID. Create agent and assign agency ID obtained.
			//TODO: Once DB_Agencies is implemented. Just initialize object of that class here.
			//Build query to select agency id
			$query  = "SELECT agency_id FROM " . $this->AGENCIES_TABLE . " WHERE company_name=" . "\"" . $assoc_array['company_name'] . "\"" .";";
			//Fetch row of agency_id
			$r = $this->connection->query($query);
			$row = $r->fetch_assoc();
			//Build insert agent query
			$agent_query = "INSERT INTO " . $this->AGENTS_TABLE . " VALUES (NULL,";
			$agent_query .= "'" . $row['agency_id']                   . "'" . ",";
			$agent_query .= "\"" . $assoc_array['user_login']         . "\"" . ",";
			$agent_query .= "\"" . $assoc_array['password']           . "\"" . ",";
			$agent_query .= "\"" . $assoc_array['first_name']         . "\"" . ",";
			$agent_query .= "\"" . $assoc_array['last_name']          . "\"" . ",";
			$agent_query .= "\"" . $assoc_array['email']              . "\"" . ",";
			$agent_query .= "\"" . $assoc_array['agent_phone_number'] . "\"" . ");";
			//echo $agent_query . "<br/>";
			//IMPORTANT
			//Check if agent already exists in database!
			$dup_query = "SELECT * FROM " . $this->AGENTS_TABLE . " WHERE user_login=" . "\"" . $assoc_array['user_login'] . "\";";
			$dup_results = $this->connection->query($dup_query);
			if ($dup_results) {
				if ($dup_results->num_rows == 1) {
					throw new Exception("Username already exists!<br/> Cannot create agent.");
				}
			} else {
				throw new Exception($this->connection->error);
			}
			//Query the database. Insert Agent into Agents table
			$results = $this->connection->query($agent_query);
			//Check results. $results is either true or false
			if($results) {
				return true;
			} else {
				throw new Exception("Could not create agent! Database error! " . $this->connection->error);
				//echo $this->connection->error;
				//return false;
			}
		} else { //Agency doesn't exist. Create a new agency. After creating agency. Give agency ID to agent.
			//Build agency query
			$agency_q = "INSERT INTO " . $this->AGENCIES_TABLE   . " VALUES (NULL,";
			$agency_q .= "\"" . $assoc_array['company_name']         . "\"" . ",";
			$agency_q .= "\"" . $assoc_array['agency_phone_number']  . "\"" . ",";
			$agency_q .= "\"" . $assoc_array['city']                 . "\"" . ",";
			$agency_q .= "\"" . $assoc_array['state']                . "\"" . ",";
			$agency_q .= "\"" . $assoc_array['zip']                  . "\"" . ",";
			$agency_q .= "\"" . $assoc_array['address']              . "\"" . ");";
			//echo $agency_q . "<br/>";
			//Insert agency into database
			$result = $this->connection->query($agency_q);
			//Check results of insertion
			if ($result) {
				echo "Created Agency Successfully! <br/>";
				echo "Creating agent... <br/>";
				//Check if agent username is in database. Ensures unique usernames.
				$dup_query = "SELECT * FROM " . $this->AGENTS_TABLE . " WHERE user_login=" . "\"" . $assoc_array['user_login'] . "\";";
				$dup_results = $this->connection->query($dup_query);
				if ($dup_results) {
					if ($dup_results->num_rows == 1) {
						throw new Exception("Username already exists!<br/> Cannot create agent.");
						//$conn->close();
						//return false;
					}
				} else {
					throw new Exception($this->connection->error);
					//return false;
				}

				//Build agent entry as username is unique
				$query = "SELECT agency_id FROM " . $this->AGENCIES_TABLE . " WHERE company_name=" . "\"" . $assoc_array['company_name'] . "\"" .";";
				$r = $this->connection->query($query);
				$row = $r->fetch_assoc();
				//echo $row['agency_id'] . "<br/>";

				//Build insert agent query
				$agent_query = "INSERT INTO " . $this->AGENTS_TABLE . " VALUES (NULL,";
				$agent_query .= "'" . $row['agency_id']                   . "'" . ",";
				$agent_query .= "\"" . $assoc_array['user_login']         . "\"" . ",";
				$agent_query .= "\"" . $assoc_array['password']           . "\"" . ",";
				$agent_query .= "\"" . $assoc_array['first_name']         . "\"" . ",";
				$agent_query .= "\"" . $assoc_array['last_name']          . "\"" . ",";
				$agent_query .= "\"" . $assoc_array['email']              . "\"" . ",";
				$agent_query .= "\"" . $assoc_array['agent_phone_number'] . "\"" . ");";
				//echo $agent_query . "<br/>";

				//Insert agent into database
				$results = $this->connection->query($agent_query);
				//Check if agent was added succesfully
				if($results) {
					//echo "Created agent successfully!<br/>";
					return true;
				} else {
					throw new Exception("Could not create agent! Database error!");
					//return false;
				}
			} else {
				throw new Exception("Could not create Agency! Could not create agent credentials! Database error!");
				//return false;
			}
		}
	}
	/* insertAgent()
	 * This function already assumes agent knows his agency ID and creates an
	 * agent entry in Agents table. agency_id must be in the map.
	 * Returns true if successful completion.
	 * Otherwise, throws exception due to mysql.
	 * @throws Exception, BadMethodCallException
	 */
	public function insertAgent($assoc_array) {
		//Quarantine Zone
		try {
			$assoc_array = $this->q_zone($assoc_array);
		}
		catch (BadMethodCallException $e) {
			throw $e;
		}
		$agent_query = "INSERT INTO " . $this->AGENTS_TABLE . " VALUES (NULL,";
		$agent_query .= "\"" . $assoc_array['agency_id']          . "\"" . ",";
		$agent_query .= "\"" . $assoc_array['user_login']         . "\"" . ",";
		$agent_query .= "\"" . $assoc_array['password']           . "\"" . ",";
		$agent_query .= "\"" . $assoc_array['first_name']         . "\"" . ",";
		$agent_query .= "\"" . $assoc_array['last_name']          . "\"" . ",";
		$agent_query .= "\"" . $assoc_array['email']              . "\"" . ",";
		$agent_query .= "\"" . $assoc_array['agent_phone_number'] . "\"" . ");";
		$dup_query = "SELECT * FROM " . $this->AGENTS_TABLE . " WHERE user_login=" . "\"" . $assoc_array['user_login'] . "\";";
		$dup_results = $this->connection->query($dup_query);
		if ($dup_results) {
			if ($dup_results->num_rows == 1) {
				throw new Exception("Username already exists! Cannot create agent.");
			}
		} else {
			throw new Exception($this->connection->error);
		}
		//Query the database. Insert Agent into Agents table
		$results = $this->connection->query($agent_query);
		//Check results. $results is either true or false
		if($results) {
			return true;
		} else {
			//throw new Exception("Could not create agent! Database error! " . $this->connection->error);
			//echo $this->connection->error;
			return false;
		}
	}
	/** update() -> Updates a table entry in database
	 *               update() corresponds to following mysql syntax:
	 *               "UPDATE 'table_name' SET column_1 = [value1], column_2 = [value2], ... WHERE 'condition' ""
	 *
	 *   @param $set_array, $where_array
	 *            -> $set_array is an associative array where ["column_name"]    = "new value";
	 *            -> $where_array is a single valued array where "["column_name"] = condition_value;" This cannot be empty.
	 */
	public function update($set_array, $where_array) : bool {
		if(empty($set_array)) {
			throw new BadMethodCallException("\$set_array cannot be empty");
		}
		$ignore = ['submitted', 'Submit'];
		$columns     = $this->conditionBuilder($set_array, ",", $ignore);
		$condition   = $this->conditionBuilder($where_array, " AND ", $ignore);
		$query = "UPDATE " . $this->AGENTS_TABLE . " SET " . $columns . " WHERE " . $condition . ";";
		$results = $this->connection->query($query);
		return $results;
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
		$query = "DELETE FROM " . $this->AGENTS_TABLE . " WHERE " . $condition . ";";
		$results = $this->connection->query($query);
		return $results;
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
		// Check if agent_id is in the query to be requested.
		if (in_array($this->index, $array) || $array == ['*']) {
			$isThere = true;
		}
		else {
			array_push($array, $this->index);
		}
		$s = implode(",", $array);
		// If condition is empty. Just select all columns given.
		if (empty($cond)) {
			$query = "SELECT " . $s . " FROM " . $this->AGENTS_TABLE . ";";
			$results = $this->connection->query($query);
			$result_array = $this->resultToArray($results, 'agent_id');
		} else { //Else, select based on given conditions
			$c = $this->conditionBuilder($cond, " AND ", []);
			$query = "SELECT " . $s . " FROM " . $this->AGENTS_TABLE . " WHERE " . $c . ";";
			$results = $this->connection->query($query);
				
			//If results is false, return empty array.
			if ($results == false) {
				return array();
			}
				
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
	
	// added by Cray. Returns array of elements based on alphabetically order
	// last name
	public function select_with_order($array, $cond) {
		$isThere = false;
		$result_array = Array();
		// Check if $array is empty.
		if (empty($array)) {
			throw new Exception ("Nothing to select");
		}
		// Check if agent_id is in the query to be requested.
		if (in_array($this->index, $array) || $array == ['*']) {
			$isThere = true;
		}
		else {
			array_push($array, $this->index);
		}

		$s = implode(",", $array);
		// If condition is empty. Just select all columns given.
		if (empty($cond)) {
			$query = "SELECT " . $s . " FROM " . $this->AGENTS_TABLE . " ORDER BY last_name ASC;";
			$results = $this->connection->query($query);
			//If results is false, return empty array.
			if ($results == false) {
				return array();
			}
			$result_array = $this->resultToArray($results, 'agent_id');
		} else { //Else, select based on given conditions
			$c = $this->conditionBuilder($cond, " AND ", []);
			$query = "SELECT " . $s . " FROM " . $this->AGENTS_TABLE . " WHERE " . $c . " ORDER BY last_name ASC;";

			$results = $this->connection->query($query);

			//If results is false, return empty array.
			if ($results == false) {
				return array();
			}
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

	// added by Cray. Returns array of elements where not.
	public function select_where_not($array, $cond) {
		$isThere = false;
		$result_array = Array();
		// Check if $array is empty.
		if (empty($array)) {
			throw new Exception ("Nothing to select");
		}
		// Check if agent_id is in the query to be requested.
		if (in_array($this->index, $array) || $array == ['*']) {
			$isThere = true;
		}
		else {
			array_push($array, $this->index);
		}

		$s = implode(",", $array);
		// If condition is empty. Just select all columns given.
		if (empty($cond)) {
			$query = "SELECT " . $s . " FROM " . $this->AGENTS_TABLE . " ORDER BY last_name ASC;";
			$results = $this->connection->query($query);
			//If results is false, return empty array.
			if ($results == false) {
				return array();
			}
			$result_array = $this->resultToArray($results, 'agent_id');
		} else { //Else, select based on given conditions
			$c = $this->conditionBuilder($cond, " AND ", []);
			$query = "SELECT " . $s . " FROM " . $this->AGENTS_TABLE . " WHERE NOT " . $c . " ORDER BY last_name ASC;";

			$results = $this->connection->query($query);

			//If results is false, return empty array.
			if ($results == false) {
				return array();
			}
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
	// Do not know how this should be implemented
	/* public function search($assoc_rray) {
	throw new Exception("Search function not yet implemented for Agents");
	} */
	// ***************************************************************************
	// Private Methods and Fields
	/** Quarantine zone.
	*    Makes sure everything about the Agent associative array is ok
	*/
	protected function q_zone($assoc_array) {
		// Sanitize the associative array.
		//$assoc_array = array_map(array($this,"sanitizer"), $assoc_array);
		$assoc_array   = array_map(array($this, "sanitizer"), $assoc_array);
		// Check for empty fields.
		if($this->hasEmptyFields($assoc_array)) {
			throw new BadMethodCallException ("Fields cannot be empty!");
		}
		return $assoc_array;
	}
	//Index query control
	private $index = 'agent_id';
}
?>