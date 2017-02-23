<!-- DBTransactorFactory.php
     This is the Factory class you must use to create objects that interact with the database!
    
    Description:
        Factory Pattern for database transactions.
        Returns different objects based on the Table you want to edit.
    
    Examples: 
        $agentobj = DBTransactorFactory::build("Agents");
        $listings = DBTransactorFactory::build("Listings");
        
-->
<?php
    class DBTransactorFactory {
        
        // @throws Exception and maybe mysql connection error exception      
        public static function build($table_name) {
            $class_name = "DB_" . $table_name;
            if (class_exists($class_name) {
                return new $class_name($table_name);
            } else {
                throw new Exception("Invalid table name.")
            }
        }
    }

?>
