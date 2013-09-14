<?php
/**
 * This is the database module. It handels all database operations.
 * There are 4 basic database operations: connect, read, write and disconnect,
 * everyone handled by a function with same name.
 *
 * mysqli connect();
 *
 *      Returns a mysqli object used for database connection.
 *
 * disconnect(mysqli db);
 *
 *      Disconnects db database.
 *
 */


function connect(){
    static $DB;
    $DB = mysqli_connect('localhost', 'mysql', '123456', 'timetable');
    if(!$DB)
        exit('Connect error '.mysqli_connect_errno());

    return $DB;
}
