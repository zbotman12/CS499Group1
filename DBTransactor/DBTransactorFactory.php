<!-- DBTransactorFactory.php
     This is the Factory class you must use to create objects that interact with the database!
    
    Description:
        Factory Pattern for database transactions.
        Returns different objects based on the Table you want to edit.
    
    Examples: 
        $agentobj = DBTransactorFactory::build("Agents");
        $listings = DBTransactorFactory::build("Listings");

    Note: 
        include_once is a better choice. Consider it in the future.         
-->
<?php

    require_once('Paragon.php') ;
    require_once('DBTransactor.php');
    require_once('DB_Agencies.php');
    require_once('DB_Agents.php');
    require_once('DB_Listings.php');
    require_once('DB_Showing_Feedback.php');
    require_once('DB_Showings.php');

    class DBTransactorFactory {    
        // @throws Exception and maybe mysql connection error exception      
        public static function build($table_name) {
            $class_name = "DB_" . $table_name;
            if (class_exists($class_name)) {
                return new $class_name($table_name);
            } else {
                //You do not have to catch this one.
                throw new Exception("Invalid table name.");
            }
        }
    }
?>
