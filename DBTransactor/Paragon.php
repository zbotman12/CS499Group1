<!-- File: Paragon.php
     Constants used for database connection. Initializes a database connection. 
     If your class extends Paragon, you may

    * Doing credentials this way may allows us to encrypt this file 
      in order to protect database credentials in case of server hack or data leak.
    
    * Password could be made more complicated and harder to guess instead of empty. 
    * Disabling root login to mysql server and creating a harder to guess username for mysql is helpful.
    
-->

<?php
    
    /** Paragon Utility Class
    * Protected credentials used to authenticate to the database to be used throughout code.
    * DBTransactor classes inherit this class in order to establish database connection.
    *
    * Each DBTransactor initalizes a database connection.
    */
    abstract class Paragon {

        private $AGENTS_TABLE;
        private $AGENCIES_TABLE;
        private $LISTINGS_TABLE;
        private $SHOWINGS_TABLE;
        private $SHOWINGS_FEEDB_TABLE;
        private $connection;
        
        // *******************************************************************************************************************************
        // Paragon Abstract Methods (needs testing)

        /*
            getConn()
            returns a new mysql object and authenticates to the server using credentials from Paragon.
        */
        protected function getConn() {
            $config = parse_ini_file('../../config.ini');
            //$config = parse_ini_file('config.ini');
            $o = new mysqli($config['dblocation'], $config['username'], $config['password'], $config['dbname']);
            return $o;
        }

        /*
            q_zone() - Quarantine Zone
            The "quarantine zone" is a function called to sanitize your input.
            Each DBTransactor must implement its own quarantine zone.
        */
        abstract protected function q_zone($assoc_array);

        // *******************************************************************************************************************************
        // Utilities
        
        /*
            hasEmptyFields()
            Given an associative array with strings as values, determines if any of the values are empty
            Returns bool
        */
        protected function hasEmptyFields($arr) 
        {
            foreach($arr as $k => $v) 
            {
                if (empty($v)) {
                  //echo "$k cannot be empty </br>";
                  return true;
                }
            }
            return false;
        }

        /* 
            sanitizer() 
            Given a string, strips special characters and slashes
        */
        protected function sanitizer($data) {
            //IMPORTANT NOTE (RYAN): We need to alter test_input so that we can
            //Use special characters like apostrophes without causing sql errors.
           return htmlspecialchars(stripslashes(trim($data))); 
        }

        /* 
            array_except()
            Returns all elements of array except for the keys. 
            Ex.
        */
        protected function array_except($array, $keys) {
            return array_diff_key($array, array_flip((array) $keys));   
        }

        /*
            printer()
            Print all values of database for testing.
        */
        public function printer($array) {
            if(empty($array)) {
                //throw new Exception("printer() : Array cannot be empty.");
                echo "Nothing to print <br/>";
            }
            
            foreach ($array as $key => $val) {
                echo "Key: " . $key . "<br/>";
                foreach ($val as $k => $v) {
                    echo "$k " . "=" . "$v" . "<br/>";
                }
                echo "<br/>";
            }
        }
        
        /*
            selectAll()
            Queries the database for all entries and returns it in an associative array.
        */
        public function selectAll(){
            return $this->select(['*'], []);
        }
        
        /*
            resultToArray()
            After getting the query from the database, this function
            transforms the result object into an associative array to be used throughout the program.
        */
        protected function resultToArray($result, $index) {
            $rows = array();
            while($row = $result->fetch_assoc()) {
                //$rows[] = $row;
                foreach ($row as $key => $value) {
                    $rows[$row[$index]][$key] = $value;
                }
            }
            return $rows;
        }
              
        /* conditionBuilder : Given an associative array of values, constructs a string for suitable for MYSQL queries.
           Intersperces the given $str in between query strings.
           
           * Example Input:
                $agent_id = array('agency_id'  => '100',
                                  'user_login' => 'dasani',
                                  'password'   => 'dasani');
                $var = conditionBuilder($agent_id, ",", [values in array to ignore]);
           
           * Example Output:
                agency_id='100' , user_login='dasani' , password='dasani'

             If you are ignoring a specific value, for example agency_id:
                Input:
                    $var = conditionBuilder($agent_id, ",", ['agency_id']); 
                
                Output:
                    user_login='dasani' , password='dasani'
        */
        protected function conditionBuilder($array, $str, $ignorevalues) {
            $array = $this->array_except($array, $ignorevalues);
            
            // Check $empty array
            if(empty($array)){
                throw new BadMethodCallException ("Condition builder cannot take empty arrays.");
            }

            $a = array();
            $s = '';

            foreach ($array as $key => $value) {
                $s = $key . '=' . "'" . $value . "'";
                array_push($a, $s);
                //echo $s;
            }
            return (implode ($str ,$a));
        }
    }
?>
