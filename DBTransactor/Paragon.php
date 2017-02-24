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

        private $DB_LOCATION = 'localhost';
        private $DB_USERNAME = 'root';
        private $DB_PW       = '';
        private $DB_NAME     = 'ParagonMLS';
        
        private $AGENTS_TABLE;
        private $AGENCIES_TABLE;
        private $LISTINGS_TABLE;
        private $SHOWINGS_TABLE;
        private $SHOWINGS_FEEDB_TABLE;
        private $connection;
        
        // *******************************************************************************************************************************
        // Paragon Abstract Methods

        protected function getConn() {
            return new mysqli($this->DB_LOCATION, $this->DB_USERNAME, $this->DB_PW, $this->DB_NAME);
        }

        abstract protected function q_zone($assoc_array);
        
        /* conditionBuilder : Given an associative array of values, constructs a string for suitable for MYSQL queries.
           Intersperces the given $str in between query strings.
           Example Input:
                $agent_id = array('agency_id'  => '100',
                                  'user_login' => 'dasani',
                                  'password'   => 'dasani');
                $var = conditionBuilder($agent_id, ",", [values in array to ignore]);
           Example Output:
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

        /* columnBuilder
           Given an associative array. Returns a string of array keys listed by commas
           Example Input: 
                    $agent_id = array('agency_id'  => '100',
                                      'user_login' => 'dasani',
                                      'password'   => 'dasani');
                    $var = columnBuilder($agent_id);
           
           Example Output: $var is now $var = "agency_id, user_login, password"
        */
        protected function columnBuilder($assoc_array) {
            if (empty($assoc_array) {
                throw new BadMethodCallException ("selectColumns: Array cannot be empty");
            }
            
            $a = array();
            $s = '';

            foreach ($assoc_array as $key => $value) {
                $s = $key;
                array_push($a, $s);
            }
            return (implode (", ", $a));
        }

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
    }
?>
