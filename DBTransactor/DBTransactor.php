<!--
    File: DBTransactor.php
    Interface to create database transactions classes in ParagonMLS database.
    
    When creating an object of DBTransactor in your files, the DBTransactor will initiate a
    connection to the ParagonMLS database.
    
    Once you are done with your queries, call the destructor of your corresponding DBTransactor at the end of your
    files or whenever you are done using the DBTransactor object to close the
    connection to the database.

    Interface behavior is described as:
        "If I want to be an Database Transactor (DBTransactor) object, I must fulfill the DBTransactor contract."
-->

<?php

    interface DBTransactor {

        /** insert()             -> Insert an entry to a table
        *   @param $assoc_array  -> Associative array of all values to insert in array. This associative array cannot be empty.
        *                           DBTransactors implementing insert throw an exception if number of arguments do not match up to the query.
        *                           
        *                           Key values of the associative array must be the same as the column names of the database table as each DBTransactor uses the following SQL syntax.
        *                           "INSERT INTO table VALUES (value1, value2, ... );""
        * 
        *   @return bool         -> True  : Insert operation succeeded.
        *                           False : Insert operation failed. 
        *   @throws              -> BadMethodCallException 
        */                          
        public function insert($assoc_array);
        



        /** update()             -> Updates a table entry in database
        *                           update() corresponds to following mysql syntax: "UPDATE 'table_name' SET column_1 = [value1], column_2 = [value2], ... WHERE 'condition' ""
        *
        *   @param $set_array    -> $set_array is an associative array where ["column_name"]    = "new value";
        *          $where_array  -> $where_array is a single valued array where "["column_name"] = condition_value;" This cannot be empty.
        *                           
        *   @return bool      -> Indicates if operation was successful (true if yes, false if no)
        *
        *   @throws 
        */    
        public function update($set_array, $where_array);



        /** delete()           -> Deletes an entry from the database
        *  @param $key_array   -> A single valued associative array where ["column_name"] = value_to_delete; 
        *
        *                         delete() corresponds to following mysql syntax: "DELETE FROM 'table_name' WHERE 'condition';
        *
        *  @return bool     -> Indicate if operation was sucessful or not
        *
        *  @throws Exception   -> Throws mysql query failure if database query failed
        */
        public function delete($key_array);   



        /** select()           -> Selects data from the database
        * @param  $array       -> Array of column names to select. 
        *               
        * @return array        -> Returns associative array of items selected from table ['column_name'] = Array(values for column) 
        *                         Functions use mysql_fetch_assoc() to turn result query into associative array of values you specified.
        *                         If query wasn't found, returns empty array. Function uses mysql_num_rows to check if anything from the query was returned.
        *
        *                         "SELECT column_name1,column_name2, .. FROM table_name; "
        * @throws exception    -> mysql errors if query failed 
        */
        public function select($array);



        // Ask team about this function implementation on Friday. 
        // Since this has the potential to be huge database, fetching all entries of a table is a nightmare.
        /** selectAll()   
        *
        */
        //public function selectAll() : array{}
        


        //Ask team about how this function should behave on Friday.
        /** search()              -> Selects all data from the database that matches the specified condition. Conditions can be chained using associative arrays.
        * @param  $assoc_array    -> Associative array where ['column_name'] = 'value to search for'
        *                            mysql syntax:   SELECT * FROM Listings WHERE price=100 AND MLS_number=2;
        *
        * @return array           -> Returns associative array of items selected from table. If no values found, array returned will be empty.
        * The difference between search() and select() is that select() searches for a very specific value. (i.e Return agent phone number.)
        * search() will return all possible matchings of the conditions supplied in the associative array (i.e return all agents where agency is "British Intelligence Agency").
        * select() can act like a search, but a search cannot return a single value, only an entire entry.
        */
        public function search($assoc_rray);
    }
?>
