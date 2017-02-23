<!--
    File: DB_Showings.php
    Class to create Showings database transactions in ParagonMLS database.
    
    When implementing a DBTransactor in your files, the transactor will initiate a
    connection to the ParagonMLS database.
    
    Once you are done with your queries, call the destructor at the end of your
    files or whenever you are done using the DBTransactor object to close the
    connection to the database.

-->

<?php
    class DB_Showing_Feedback extends Paragon implements DBTransactor {
    
        // ***************************************************************************
        // Private fields
        private $TABLE_NAME;


        // ****************************************************************************
        // Constructor/Desctructor and Public Methods

        // Initializes a connection to the ParagonMLS database.
        // Given a table name. Creates a database connection to the table.
        public function __construct($TABLE_NAME) {
            $conn = new mysqli(Paragon::DB_LOCATION, Paragon::DB_USERNAME, Paragon::DB_PW, Paragon::DB_NAME);
            $this->TABLE_NAME = $TABLE_NAME;
        }

        // Destroys object and closes database connection
        public function __destruct() {
            $conn->close();
        }

        // ***************************************************************************
        // DBTransactor Methods (To be implemented)
        public function insert($assoc_array)             : boolean {return false;}
        public function update($set_array, $where_array) : boolean {return false;}
        public function delete($key_array)               : boolean {return false;}
        public function select($array)                   : array   {return array();}
        public function search($assoc_rray)              : array   {return array();}

        // ***************************************************************************
        // Private Methods

    }

?>
